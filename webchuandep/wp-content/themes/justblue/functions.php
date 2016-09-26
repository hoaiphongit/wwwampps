<?php
define( 'MTS_THEME_VERSION', '1.0.4' );
require_once( dirname( __FILE__ ) . '/theme-options.php' );
if ( ! isset( $content_width ) ) $content_width = 960;

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
	set_post_thumbnail_size( 150, 150, true );
	add_image_size( 'related', 175, 125, true ); //related
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
            <div class="avatar">
                    <?php echo get_avatar( $comment->comment_author_email, 68 ); ?>
                    <time><?php comment_date(); ?></time>    
            </div>
	</div>
            <div class="comment-content">
                
                <?php printf(__('<span class="fn">%s</span>', 'mythemeshop'), get_comment_author_link()) ?>    
                <time><?php the_time('F j, Y'); ?></time>
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
                          'footer-menu' => 'Footer Menu&after=<span>|</span>',   
	  		)
	  	);
	}

//Add first and last item classes to menus
add_filter( 'wp_nav_menu_items', 'nav_menu_first_last' );
function nav_menu_first_last( $items ) {
$position = strrpos($items, 'class="menu-item', -1);
$items=substr_replace($items, 'menu-item-last ', $position+7, 0);
$position = strpos($items, 'class="menu-item');
$items=substr_replace($items, 'menu-item-first ', $position+7, 0);
return $items; }

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
/* Breadcrumb
/*-----------------------------------------------------------------------------------*/
function the_breadcrumb() {
	echo '<a href="';
	echo home_url();
	echo '" rel="nofollow">Home';
	echo "</a>";
		if (is_category() || is_single()) {
			echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
			the_category(' &bull; ');
				if (is_single()) {
					echo " &nbsp;&nbsp;&#187;&nbsp;&nbsp; ";
					the_title();
				}
        } elseif (is_page()) {
            echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
            echo the_title();
		} elseif (is_search()) {
            echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;Search Results for... ";
			echo '"<em>';
			echo the_search_query();
			echo '</em>"';
        }
    }

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