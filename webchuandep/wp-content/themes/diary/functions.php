<?php
define( 'MTS_THEME_VERSION', '1.0.3' );
require_once( dirname( __FILE__ ) . '/theme-options.php' );
if ( ! isset( $content_width ) ) $content_width = 1050;

/*-----------------------------------------------------------------------------------*/
/*	Load Translation Text Domain
/*-----------------------------------------------------------------------------------*/

load_theme_textdomain( 'mythemeshop', get_template_directory().'/lang' );

if ( function_exists('add_theme_support') ) add_theme_support('automatic-feed-links');

/*-----------------------------------------------------------------------------------*/
/*	Post Thumbnail Support
/*-----------------------------------------------------------------------------------*/
	if ( function_exists( 'add_theme_support' ) ) { 
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 600, 300, true );
	add_image_size( 'featured', 600, 300, true ); //featured
	}

/*-----------------------------------------------------------------------------------*/
/*	Enable Widgetized sidebar
/*-----------------------------------------------------------------------------------*/
	if ( function_exists('register_sidebar') )
	// Sidebar Widget
	register_sidebar(array('name'=>'Sidebar',
		'id'            => 'sidebar',
		'before_widget' => '<li class="widget widget-sidebar">',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
/*-----------------------------------------------------------------------------------*/
/*	Load Widgets & Shortcodes
/*-----------------------------------------------------------------------------------*/

// Add the 125x125 Ad Block Custom Widget
include("functions/widget-ad125.php");

// Add the 125x125 Ad Block Custom Widget
include("functions/widget-ad300.php");

// Add the Latest Tweets Custom Widget
include("functions/widget-tweets.php");

// Add Facebook Like box Widget
include("functions/widget-fblikebox.php");

// Add Social Profile Widget
include("functions/widget-social.php");

// Add Welcome message
include("functions/welcome-message.php");

// Theme Functions
include("functions/theme-actions.php");

// TGM Plugin Activation
include( "functions/plugin-activation.php" );

/*-----------------------------------------------------------------------------------*/
/*	Filters customize wp_title
/*-----------------------------------------------------------------------------------*/
// Filter the page title wp_title() in header.php
	if ( ! function_exists('mythemeshop_page_title' ) ) {
		function mythemeshop_page_title( $title ) { 
			$the_page_title = $title;
			if( ! $the_page_title ){
				$the_page_title = get_bloginfo("name");
			}else{
				$the_page_title = $the_page_title;
			}
			return $the_page_title;
		} 
		add_filter('wp_title', 'mythemeshop_page_title');
	}

/*-----------------------------------------------------------------------------------*/
/*	Custom Comments template
/*-----------------------------------------------------------------------------------*/
function mytheme_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
	<div id="comment-<?php comment_ID(); ?>" style="position:relative;">
	<div class="comment-author vcard">
	<?php echo get_avatar( $comment->comment_author_email, 75 ); ?>
	<?php printf(__('<span class="fn">%s</span>', 'mythemeshop'), get_comment_author_link()) ?> 
	<?php $options = get_option('diary'); if($options['mts_comment_date'] == '1') { ?>
		<time><?php comment_date(); ?></time>
	<?php } ?>
	</div>
	<?php if ($comment->comment_approved == '0') : ?>
	<em><?php _e('Your comment is awaiting moderation.', 'mythemeshop') ?></em>
	<br />
	<?php endif; ?>
	<div class="comment-meta commentmetadata">
	<?php edit_comment_link(__('(Edit)', 'mythemeshop'),'  ','') ?></div>
	<?php comment_text() ?>
	<div class="reply">
	<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	</div>
<?php
        }

/*-----------------------------------------------------------------------------------*/
/*	excerpt
/*-----------------------------------------------------------------------------------*/

// Excerpt length
function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt);
  } else {
    $excerpt = implode(" ",$excerpt);
  }
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
  return $excerpt;
}

/*-----------------------------------------------------------------------------------*/
/* nofollow to next/previous links
/*-----------------------------------------------------------------------------------*/
function pagination_add_nofollow($content) {
    return 'rel="nofollow"';
}
add_filter('next_posts_link_attributes', 'pagination_add_nofollow' );
add_filter('previous_posts_link_attributes', 'pagination_add_nofollow' );

/*-----------------------------------------------------------------------------------*/
/* Nofollow to category links
/*-----------------------------------------------------------------------------------*/
add_filter( 'the_category', 'add_nofollow_cat' ); 
function add_nofollow_cat( $text ) {
$text = str_replace('rel="category tag"', 'rel="nofollow"', $text); return $text;
}

/*-----------------------------------------------------------------------------------*/	
/* nofollow post author link
/*-----------------------------------------------------------------------------------*/
add_filter('the_author_posts_link', 'mts_nofollow_the_author_posts_link');
function mts_nofollow_the_author_posts_link ($link) {
return str_replace('<a href=', '<a rel="nofollow" href=',$link); 
}

/*-----------------------------------------------------------------------------------*/
/* removes detailed login error information for security
/*-----------------------------------------------------------------------------------*/
	add_filter('login_errors',create_function('$a', "return null;"));
	
/*-----------------------------------------------------------------------------------*/
/* removes the WordPress version from your header for security
/*-----------------------------------------------------------------------------------*/
	function wb_remove_version() {
		return '<!--Theme by MyThemeShop.com-->';
	}
	add_filter('the_generator', 'wb_remove_version');
	
/*-----------------------------------------------------------------------------------*/
/* Removes Trackbacks from the comment count
/*-----------------------------------------------------------------------------------*/
add_filter( 'get_comments_number', 'mts_comment_count', 0 );
function mts_comment_count( $count ) {
    if ( ! is_admin() ) {
        global $id;
        $comments = get_comments( 'status=approve&post_id=' . $id );
        $comments_by_type = separate_comments( $comments );
        return count( $comments_by_type['comment'] );
    } else {
        return $count;
    }
}
	
/*-----------------------------------------------------------------------------------*/
/* category id in body and post class
/*-----------------------------------------------------------------------------------*/
	function category_id_class($classes) {
		global $post;
		foreach((get_the_category($post->ID)) as $category)
			$classes [] = 'cat-' . $category->cat_ID . '-id';
			return $classes;
	}
	add_filter('post_class', 'category_id_class');
	add_filter('body_class', 'category_id_class');

/*-----------------------------------------------------------------------------------*/
/* adds a class to the post if there is a thumbnail
/*-----------------------------------------------------------------------------------*/
	function has_thumb_class($classes) {
		global $post;
		if( has_post_thumbnail($post->ID) ) { $classes[] = 'has_thumb'; }
			return $classes;
	}
	add_filter('post_class', 'has_thumb_class');

/*-----------------------------------------------------------------------------------*/	
/* Pagination
/*-----------------------------------------------------------------------------------*/
function pagination($pages = '', $range = 3)
{ $showitems = ($range * 3)+1;
 global $paged; if(empty($paged)) $paged = 1;
 if($pages == '') {
 global $wp_query; $pages = $wp_query->max_num_pages; if(!$pages)
 { $pages = 1; } }
 if(1 != $pages)
 { echo "<div class='pagination'><ul>";
 if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<li><a rel='nofollow' href='".get_pagenum_link(1)."'>&laquo; First</a></li>";
 if($paged > 1 && $showitems < $pages) echo "<li><a rel='nofollow' href='".get_pagenum_link($paged - 1)."' class='inactive'>&lsaquo; Previous</a></li>";
 for ($i=1; $i <= $pages; $i++)
 { if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
 { echo ($paged == $i)? "<li class='current'><span class='currenttext'>".$i."</span></li>":"<li><a rel='nofollow' href='".get_pagenum_link($i)."' class='inactive'>".$i."</a></li>";
 } } if ($paged < $pages && $showitems < $pages) echo "<li><a rel='nofollow' href='".get_pagenum_link($paged + 1)."' class='inactive'>Next &rsaquo;</a></li>";
 if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a rel='nofollow' class='inactive' href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
 echo "</ul></div>"; }}

/*-----------------------------------------------------------------------------------*/
/* Redirect feed to feedburner
/*-----------------------------------------------------------------------------------*/
$options = get_option('diary');
if ( $options['mts_feedburner'] != '') {
function mts_rss_feed_redirect() {
    $options = get_option('diary');

    global $feed;
    $new_feed = $options['mts_feedburner'];

    if (!is_feed()) {
            return;
    }
    if (preg_match('/feedburner/i', $_SERVER['HTTP_USER_AGENT'])){
            return;
    }

    if ($feed != 'comments-rss2') {
            if (function_exists('status_header')) status_header( 302 );
            header("Location:" . $new_feed);
            header("HTTP/1.1 302 Temporary Redirect");
            exit();
    }
}
add_action('template_redirect', 'mts_rss_feed_redirect');
}

?>