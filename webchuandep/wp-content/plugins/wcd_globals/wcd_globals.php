<?php
/**
* Plugin Name: WebChuanDep.com
* Plugin URI: http://webchuandep.com/
* Description: Update themes & plugins from WebChuanDep.com
* Version: 1.0
* Author: HoaiphongIT
* Author URI: http://wpsama.net/
**/

add_action( 'login_enqueue_scripts', 'wcd_globals_login_enqueue_scripts' );
function wcd_globals_login_enqueue_scripts(){
	$logo = plugins_url( 'banner-login-wcd.jpg', __FILE__ );
	print '<style type="text/css" media="screen">';
	print 	'#login h1 a { 
				background-image:url('. $logo .'); 
				background-size: contain;
				width: 320px;
			}';	
	print '</style>';
}
 
add_filter( 'login_headerurl', 'wcd_globals_login_headerurl');
function wcd_globals_login_headerurl(){
	return "http://webchuandep.com/";
}

add_filter( 'login_headertitle', 'wcd_globals_login_headertitle');
function wcd_globals_login_headertitle(){
	return "Made by WebChuanDep";
}

add_action('wp_enqueue_scripts','wcd_globals_define_scripts');
function wcd_globals_define_scripts() {
	$theme_url = plugins_url() . '/wcd_globals';
	wp_enqueue_style( 'bootstrap-grid', $theme_url . '/bootstrap-grid.css' );    
	wp_enqueue_style( 'wcd-globals', $theme_url . '/wcd-globals.css' );    
	wp_enqueue_style( 'wcd-owl', $theme_url . '/libs/owl.carousel.2.0.0/assets/owl.carousel.css' );    

	wp_enqueue_script( 'wcd-owl', $theme_url . '/libs/owl.carousel.2.0.0/owl.carousel.min.js', false );
	wp_enqueue_script( 'wcd-globals', $theme_url . '/wcd-globals.js', false );
}

add_action( 'widgets_init', 'theme_slug_widgets_init' );
function theme_slug_widgets_init() {
    register_sidebar( array(
		'name' 			=> __( 'Before Content', 'WebChuanDep' ),
		'id' 			=> 'wcd_globals_before_front',
		'description' 	=> __( 'Widgets in this area will be shown on all posts and pages.', 'WebChuanDep' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="wcd-widget-title">',
		'after_title'   => '</div>',
    ) );
    register_sidebar( array(
		'name' 			=> __( 'Front Content', 'WebChuanDep' ),
		'id' 			=> 'wcd_globals_front',
		'description' 	=> __( 'Widgets in this area will be shown on all posts and pages.', 'WebChuanDep' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="wcd-widget-title">',
		'after_title'   => '</div>',
    ) );
    register_sidebar( array(
		'name' 			=> __( 'After Content', 'WebChuanDep' ),
		'id' 			=> 'wcd_globals_after_front',
		'description' 	=> __( 'Widgets in this area will be shown on all posts and pages.', 'WebChuanDep' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="wcd-widget-title">',
		'after_title'   => '</div>',
    ) );
}

function wcd_globals_news_template($posts, $tid, $thumbnail, $thumbsize){
	$dir_path = plugin_dir_path( __FILE__ );	
	$tpl_path = $dir_path . 'templates/news_'.$tid . '.tpl.php';

	//var_dump($posts);
	$file = file_exists( $tpl_path );
	if($file){
		include($tpl_path);
	}
	else{
		print "<p>This template not exist!</p>";
	}
}

function wcd_globals_news_entry_meta() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		get_the_date(),
		esc_attr( get_the_modified_date( 'c' ) ),
		get_the_modified_date()
	);

	printf( '<span class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
		_x( 'Posted on', 'Used before publish date.', 'twentyfifteen' ),
		esc_url( get_permalink() ),
		$time_string
	);
	

	// if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
	// 	echo '<span class="comments-link">';
		/* translators: %s: post title */
	// 	comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'twentyfifteen' ), get_the_title() ) );
	// 	echo '</span>';
	// }
}