<?php

// Creating box
add_action( 'add_meta_boxes', 'wcd_crawl_add_url_metabox' );
function wcd_crawl_add_url_metabox() {

	$excluded_post_types = array(
		'attachment', 'revision', 'nav_menu_item', 'wpcf7_contact_form',
	);

	foreach ( get_post_types( '', 'names' ) as $post_type ) {
		if ( in_array( $post_type, $excluded_post_types ) )
			continue;
		add_meta_box(
			'wcd_crawl_url_metabox',
			'External Featured Image',
			'wcd_crawl_url_metabox',
			$post_type,
			'side',
			'default'
		);

		if($post_type == "post"){
			add_meta_box(
				'wcd_crawl_detail_source_of_post_metabox',
				'Source Of Post',
				'wcd_crawl_detail_source_of_post_metabox',
				$post_type,
				'side',
				'default'
			);
		}
	}

}

function wcd_crawl_detail_source_of_post_metabox($post){
	$crawl_url = get_post_meta( $post->ID, 'wcd_crawl_detail_url', true );	
	$url  = get_bloginfo("url");
	$text = get_bloginfo("name");
	if( ($crawl_url != NULL) && !empty($crawl_url) ){
		$url  = $crawl_url;
		$text = $crawl_url;
	}
	print '<a href="'. $url .'" style=" display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; ">'. $text .'</a>';
}

function wcd_crawl_url_metabox( $post ) {
	$wcd_crawl_url = get_post_meta( $post->ID, _wcd_crawl_url(), true );
	$wcd_crawl_alt = get_post_meta( $post->ID, '_wcd_crawl_alt', true );
	$has_img = strlen( $wcd_crawl_url ) > 0;
	if ( $has_img ) {
		$hide_if_img = 'display:none;';
		$show_if_img = '';
	}
	else {
		$hide_if_img = '';
		$show_if_img = 'display:none;';
	}
	?>
	<input type="text" placeholder="ALT attribute" style="width:100%;margin-top:10px;<?php echo $show_if_img; ?>"
		id="wcd_crawl_alt" name="wcd_crawl_alt"
		value="<?php echo esc_attr( $wcd_crawl_alt ); ?>" /><?php
	if ( $has_img ) { ?>
	<div id="wcd_crawl_preview_block"><?php
	} else { ?>
	<div id="wcd_crawl_preview_block" style="display:none;"><?php
	} ?>
		<div id="wcd_crawl_image_wrapper" style="<?php
			echo (
				'width:100%;' .
				'max-width:300px;' .
				'height:200px;' .
				'margin-top:10px;' .
				'background:url(' . $wcd_crawl_url . ') no-repeat center center; ' .
				'-webkit-background-size:cover;' .
				'-moz-background-size:cover;' .
				'-o-background-size:cover;' .
				'background-size:cover;' );
			?>">
		</div>

	<a id="wcd_crawl_remove_button" href="#" onClick="javascript:nelioefiRemoveFeaturedImage();" style="<?php echo $show_if_img; ?>">Remove featured image</a>
	<script>
	function nelioefiRemoveFeaturedImage() {
		jQuery("#wcd_crawl_preview_block").hide();
		jQuery("#wcd_crawl_image_wrapper").hide();
		jQuery("#wcd_crawl_remove_button").hide();
		jQuery("#wcd_crawl_alt").hide();
		jQuery("#wcd_crawl_alt").val('');
		jQuery("#wcd_crawl_url").val('');
		jQuery("#wcd_crawl_url").show();
		jQuery("#wcd_crawl_preview_button").parent().show();
	}
	function nelioefiPreview() {
		jQuery("#wcd_crawl_preview_block").show();
		jQuery("#wcd_crawl_image_wrapper").css('background-image', "url('" + jQuery("#wcd_crawl_url").val() + "')" );
		jQuery("#wcd_crawl_image_wrapper").show();
		jQuery("#wcd_crawl_remove_button").show();
		jQuery("#wcd_crawl_alt").show();
		jQuery("#wcd_crawl_url").hide();
		jQuery("#wcd_crawl_preview_button").parent().hide();
	}
	</script>
	</div>
	<input type="text" placeholder="Image URL" style="width:100%;margin-top:10px;<?php echo $hide_if_img; ?>"
		id="wcd_crawl_url" name="wcd_crawl_url"
		value="<?php echo esc_attr( $wcd_crawl_url ); ?>" />
	<div style="text-align:right;margin-top:10px;<?php echo $hide_if_img; ?>">
		<a class="button" id="wcd_crawl_preview_button" onClick="javascript:nelioefiPreview();">Preview</a>
	</div>
	<?php
}

add_action( 'save_post', 'wcd_crawl_save_url' );
function wcd_crawl_save_url( $post_ID ) {
	if ( isset( $_POST['wcd_crawl_url'] ) ) {
		$url = strip_tags( $_POST['wcd_crawl_url'] );
		update_post_meta( $post_ID, _wcd_crawl_url(), $url );
	}

	if ( isset( $_POST['wcd_crawl_alt'] ) )
		update_post_meta( $post_ID, '_wcd_crawl_alt', strip_tags( $_POST['wcd_crawl_alt'] ) );
}



