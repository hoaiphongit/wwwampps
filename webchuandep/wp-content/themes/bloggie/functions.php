<?php
define( 'MTS_THEME_VERSION', '1.0.5' );
require_once( dirname( __FILE__ ) . '/theme-options.php' );
if ( ! isset( $content_width ) ) $content_width = 960;

/*-----------------------------------------------------------------------------------*/
/*	Load Translation Text Domain
/*-----------------------------------------------------------------------------------*/

load_theme_textdomain( 'mythemeshop', TEMPLATEPATH.'/lang' );

if ( function_exists('add_theme_support') ) add_theme_support('automatic-feed-links');

function mythemeshop_enqueue_style() {
    wp_enqueue_style( 'signika', 'https://fonts.googleapis.com/css?family=Signika:600,700' );
    wp_enqueue_style( 'style', get_stylesheet_uri() );

    wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.min.js' );
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'custom', get_template_directory_uri() . '/js/customscript.js' );

    if ( is_singular() ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'mythemeshop_enqueue_style' );

/*-----------------------------------------------------------------------------------*/
/*	Post Thumbnail Support
/*-----------------------------------------------------------------------------------*/
	if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 200, 200, true );
	add_image_size( 'featured', 200, 147, true ); //featured
	add_image_size( 'featured-small', 82, 60, true ); //sidebar
	}

/*-----------------------------------------------------------------------------------*/
/*	Enable Widgetized sidebar
/*-----------------------------------------------------------------------------------*/
	if ( function_exists('register_sidebar') )
	// Header Widget
	register_sidebar(array('name'=>'Header',
		'id' => 'widget-header',
		'description' => __('This header area can be used for Search Form or 728x90 Ad.', 'mythemeshop'),
		'before_widget' => '<div class="widget-area widget-header"><ul>',
		'after_widget' => '</ul></div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));
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

// Add the 728x90 Ad Block Custom Widget
include("functions/widget-ad728.php");

// Add Facebook Like box Widget
include("functions/widget-fblikebox.php");

// Add Welcome message
include("functions/welcome-message.php");

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
/*	Filters that allow shortcodes in Text Widgets
/*-----------------------------------------------------------------------------------*/

add_filter('widget_text', 'shortcode_unautop');
add_filter('widget_text', 'do_shortcode');

/*-----------------------------------------------------------------------------------*/
/*	Search form in first navigation
/*-----------------------------------------------------------------------------------*/
//add_filter('wp_nav_menu_items', 'add_search_form', 10, 2);
function add_search_form($items, $args) {
if( $args->theme_location == 'primary-menu' )
        $items .= get_search_form( $echo );
        return $items;
}

/*-----------------------------------------------------------------------------------*/
/*	Register Footer widgets
/*-----------------------------------------------------------------------------------*/
if (function_exists('register_sidebar')) {
	$sidebars = array(1, 2, 3);
	foreach($sidebars as $number) {
	register_sidebar(array(
		'name' => 'Footer ' . $number,
		'id' => 'footer-' . $number,
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
	}
}
function widgetized_footer() {
?>
		<div class="f-widget">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer 1') ) : ?>
			<?php endif; ?>
		</div>
        <div class="sepFoot"></div>
		<div class="f-widget">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer 2') ) : ?>
			<?php endif; ?>
		</div>
        <div class="sepFoot"></div>
		<div class="f-widget last">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer 3') ) : ?>
			<?php endif; ?>
		</div>
<?php
}

/*-----------------------------------------------------------------------------------*/
/*	Custom Comments template
/*-----------------------------------------------------------------------------------*/
function mytheme_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
     <div id="comment-<?php comment_ID(); ?>" style="position:relative;">
     <div class="commentImageLeft"></div>
      <div class="comment-author vcard">
         <?php echo get_avatar( $comment->comment_author_email, 75 ); ?>

         <?php printf(__('<span class="fn">%s</span>'), get_comment_author_link()) ?>

      </div>
      <?php if ($comment->comment_approved == '0') : ?>
         <em><?php _e('Your comment is awaiting moderation.') ?></em>
         <br />
      <?php endif; ?>

      <div class="comment-meta commentmetadata">

	  <?php edit_comment_link(__('(Edit)'),'  ','') ?></div>

      <?php comment_text() ?>

      <div class="reply">
         <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
      </div>
     </div>
<?php
        }
/*-----------------------------------------------------------------------------------*/
/*	Custom Menu Support
/*-----------------------------------------------------------------------------------*/
	add_theme_support( 'menus' );
	if ( function_exists( 'register_nav_menus' ) ) {
	  	register_nav_menus(
	  		array(
	  		  'primary-menu' => 'Primary Menu',
			  'secondary-menu' => 'Secondary Menu',
	  		)
	  	);
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

?>
