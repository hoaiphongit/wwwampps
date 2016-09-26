<?php
/**
* Plugin Name: Crawl news
* Plugin URI: http://webchuandep.com/
* Description: Tạo post tự động từ wpsama.net
* Version: 1.0
* Author: HoaiphongIT
* Author URI: http://wpsama.net/
**/

// ==========================================================================
// PLUGIN INFORMATION
// ==========================================================================


// Defining a few important directories
define( 'WCD_CRAWL_ROOT_DIR', rtrim( plugin_dir_path( __FILE__ ), '/' ) );
define( 'WCD_CRAWL_DIR', WCD_CRAWL_ROOT_DIR . '/includes' );
define( 'WCD_CRAWL_ADMIN_DIR', WCD_CRAWL_DIR . '/admin' );
define( 'WCD_CRAWL_ASSETS_URL', plugins_url() . '/' . basename( dirname( __FILE__ ) ) . '/assets' );

// ADMIN STUFF
if ( is_admin() ) {
	require_once( WCD_CRAWL_ADMIN_DIR . '/edit-post.php' );	
}

/* =========================================================================*/
/*             SOME USEFUL FUNCTIONS                                        */
/* =========================================================================*/

/**
 * This function returns post meta key. The key can be changed
 * using the filter `wcd_crawl_post_meta_key'
 */
function _wcd_crawl_url() {
	return apply_filters( 'wcd_crawl_post_meta_key', '_wcd_crawl_url' );
}

/**
 * This function returns whether the post whose id is $id uses an external
 * featured image or not
 */
function uses_external_featured_image( $id ) {
	$image_url = wcd_crawl_get_thumbnail_src( $id );
	if ( $image_url === false )
		return false;
	else
		return true;
}


/**
 * This function returns the URL of the external featured image (if any), or
 * false otherwise.
 */
function wcd_crawl_get_thumbnail_src( $id, $called_on_save = false ) {

	// Remove filter temporarily, because uses_external_featured_image checks if a regular
	// feat. image is used.
	wcd_crawl_unhook_thumbnail_id();
	$regular_feat_image = get_post_meta( $id, '_thumbnail_id', true );
	wcd_crawl_hook_thumbnail_id();

	if ( isset( $regular_feat_image ) && $regular_feat_image > 0 ) {
		return false;
	}//end if

	$image_url = get_post_meta( $id, _wcd_crawl_url(), true );

	if ( ! $image_url || strlen( $image_url ) === 0 ) {

		$is_frontend = ! is_admin() || $called_on_save;

		if ( apply_filters( 'wcd_crawl_use_first_image', true ) && $is_frontend ) {

			$first_feat_image = get_post_meta( $id, '_wcd_crawl_first_image', true );

			if ( empty( $first_feat_image ) ) {

				$image_url = '""';

				$matches = array();
				$post = get_post( $id );
				if ( ! is_wp_error( $post ) && $post ) {

					preg_match(
						'/<img [^>]*src=("[^"]*"|\'[^\']*\')/i',
						$post->post_content,
						$matches
					);

					if ( count( $matches ) > 1 ) {
						$image_url = $matches[1];
					}//end if

				}//end if

				$image_url = substr( $image_url, 1, strlen( $image_url ) - 2 );
				$first_feat_image = array( $image_url );
				delete_post_meta( $id, '_wcd_crawl_first_image' );
				update_post_meta( $id, '_wcd_crawl_first_image', $first_feat_image );
			}

			if ( count( $first_feat_image ) > 0 && strlen( $first_feat_image[0] ) > 0 ) {
				return $first_feat_image[0];
			}

		}

		return false;
	}

	return $image_url;
}

add_filter( 'save_post', 'wcd_crawl_fix_first_image' );
function wcd_crawl_fix_first_image( $post_id ) {
	if ( wp_is_post_revision( $post_id) || wp_is_post_autosave( $post_id ) ) {
		return;
	}
	delete_post_meta( $post_id, '_wcd_crawl_first_image' );
	wcd_crawl_get_thumbnail_src( $post_id, true );
}


/**
 * This function prints an image tag with the external featured image (if any).
 * This tag, in fact, has a 1x1 px transparent gif image as its src, and
 * includes the external featured image via inline CSS styling.
 */
function wcd_crawl_the_html_thumbnail( $id, $size = false, $attr = array() ) {
	if ( uses_external_featured_image( $id ) )
		echo wcd_crawl_get_html_thumbnail( $id );
}


/**
 * This function returns the image tag with the external featured image (if
 * any). This tag, in fact, has a 1x1 px transparent gif image as its src,
 * and includes the external featured image via inline CSS styling.
 */
function wcd_crawl_get_html_thumbnail( $id, $size = false, $attr = array() ) {
	if ( uses_external_featured_image( $id ) === false )
		return false;

	$image_url = wcd_crawl_get_thumbnail_src( $id );

	$width = false;
	$height = false;
	$additional_classes = '';

	global $_wp_additional_image_sizes;
	if ( is_array( $size ) ) {
		$width = $size[0];
		$height = $size[1];
	}
	else if ( isset( $_wp_additional_image_sizes[ $size ] ) ) {
		$width = $_wp_additional_image_sizes[ $size ]['width'];
		$height = $_wp_additional_image_sizes[ $size ]['height'];
		$additional_classes = 'attachment-' . $size . ' ';
	}

	if ( $width && $width > 0 ) $width = "width:${width}px;";
	else $width = '';

	if ( $height && $height > 0 ) $height = "height:${height}px;";
	else $height = '';

	if ( isset( $attr['class'] ) )
		$additional_classes .= $attr['class'];

	$alt = get_post_meta( $id, '_wcd_crawl_alt', true );
	if ( isset( $attr['alt'] ) )
		$alt = $attr['alt'];
	if ( !$alt )
		$alt = '';

	$style = '';
	if ( isset( $attr['style'] ) )
		$style = 'style="' . $attr['style'] . '" ';
	
	$html = sprintf(
		'<img src="%s" %s' .
		'class="%s wp-post-image external-featured-image" '.
		'alt="%s" />',
		$image_url, $style, $additional_classes, $alt );

	return $html;
}


/* =========================================================================*/
/* =========================================================================*/
/*             ALL HOOKS START HERE                                         */
/* =========================================================================*/
/* =========================================================================*/

add_action( 'wp_head', 'wcd_crawl_add_hooks_for_head' );
function wcd_crawl_add_hooks_for_head(){
?>
	<style type="text/css" media="screen">
		.external-featured-image{
			max-width: 100%;
		}
	</style>
<?php
}


// Overriding post thumbnail when necessary
add_filter( 'genesis_pre_get_image', 'wcd_crawl_genesis_thumbnail', 10, 3 );
function wcd_crawl_genesis_thumbnail( $unknown_param, $args, $post ) {
	$image_url = get_post_meta( $post->ID, _wcd_crawl_url(), true );

	if ( !$image_url || strlen( $image_url ) == 0 ) {
		return false;
	}

	if ( $args['format'] == 'html' ) {
		$html = wcd_crawl_replace_thumbnail( '', $post->ID, 0, $args['size'], $args['attr'] );
		$html = str_replace( 'style="', 'style="min-width:150px;min-height:150px;', $html );
		return $html;
	}
	else {
		return $image_url;
	}
}


// Overriding post thumbnail when necessary
add_filter( 'post_thumbnail_html', 'wcd_crawl_replace_thumbnail', 10, 5 );
function wcd_crawl_replace_thumbnail( $html, $post_id, $post_image_id, $size, $attr ) {
	if ( uses_external_featured_image( $post_id ) )
		$html = wcd_crawl_get_html_thumbnail( $post_id, $size, $attr );
	return $html;
}


add_action( 'init', 'wcd_crawl_add_hooks_for_faking_featured_image_if_necessary' );
function wcd_crawl_add_hooks_for_faking_featured_image_if_necessary(){			
	if( isset( $_REQUEST['crawlfrom'] ) && $_REQUEST['crawlfrom'] == "wpsama.net") {
		global $wpdb;	
		// $timezone = date_default_timezone_get();
		// if( isset( $_REQUEST['timezone'] ) ){
		// 	date_default_timezone_set($_REQUEST['timezone']);
		// }

		$post_title = $_REQUEST['title'];
		$user_email = wp_strip_all_tags( $_REQUEST['author_email'] );
		
		$query 		= $wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_title = %s", $post_title);	
		$post_ID 	= $wpdb->get_var( $query );
		$post_user 	= get_user_by("email", $user_email);				
		$post_user_id = $post_user ? $post_user->ID : 1;
		$post_user_id = 1;
		$post_status  = (isset($_REQUEST['publish_post']) && $_REQUEST['publish_post']) ? 'publish' : 'draft';
		$timestamp = time();
		$categories = array();
		$rcats = explode("[|]", $_REQUEST['categories']);
		foreach ($rcats as $key => $cat_name) {					
			$term = term_exists($cat_name, 'category');
			if ( isset($term['term_id']) ) {
				$tid = $term['term_id'];
			}
			else{
				$term = wp_insert_term( $cat_name, 'category' );
				$tid = $term['term_id'];
			}
			
			$categories[] = $tid;
		}

		if($post_ID){		    
			$crawl_post = array(
				'ID'           => $post_ID,
				'post_title'   => $post_title,
				//'post_content' => $_REQUEST['body'],
			);		
			// wp_update_post( $crawl_post );

			wp_set_post_categories($post_ID, $categories, true);
			//update_post_meta( $post_ID, _wcd_crawl_url(), $_REQUEST['thumbnail'] );
		}
		else {
			$post_body = html_entity_decode($_REQUEST['body']);
			$post_body = str_replace('wcd=crawl_driver', "", $post_body);

			if( isset($_REQUEST["date_interval"]) ){
				$post_date = $timestamp + $_REQUEST["date_interval"];
			}
			else{
				$post_date = $_REQUEST['post_date'];
			}
			$post_date = date("Y-m-d H:i:s", $post_date);
			
			$crawl_post = array(
				'post_title'    => $post_title,
				'post_status'   => $post_status,
				'post_author'   => $post_user_id,				
				'post_date'  	=> $post_date,
				'post_content'  => $post_body,
				'post_category' => $categories,
			);			

			// Insert the post into the database
			$post_ID = wp_insert_post( $crawl_post );
			if($post_ID && isset($_REQUEST['thumbnail'])) {
				update_post_meta( $post_ID, _wcd_crawl_url(), $_REQUEST['thumbnail'] );			
				update_post_meta( $post_ID, "wcd_crawl_detail_url", $_REQUEST['link'] );			
			}
		}		
		//reset timezone to default of site
		//date_default_timezone_set($timezone);
	}

	wcd_crawl_hook_thumbnail_id();	
}

function wcd_crawl_fake_featured_image_if_necessary( $null, $object_id, $meta_key ) {

	$result = null;
	if ( '_thumbnail_id' === $meta_key ) {

		if ( uses_external_featured_image( $object_id ) ) {
			$result = -1;
		}
	}

	return $result;
}

function wcd_crawl_hook_thumbnail_id() {
	foreach ( get_post_types() as $post_type ) {
		add_filter( "get_${post_type}_metadata", 'wcd_crawl_fake_featured_image_if_necessary', 10, 3 );
	}
}

function wcd_crawl_unhook_thumbnail_id() {
	foreach ( get_post_types() as $post_type ) {
		remove_filter( "get_${post_type}_metadata", 'wcd_crawl_fake_featured_image_if_necessary', 10, 3 );
	}
}