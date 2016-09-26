<?php
$options = get_option('justblue');	

/*------------[ Meta ]-------------*/
if ( ! function_exists( 'mts_meta' ) ) {
	function mts_meta() { 
	global $options
?>
<?php if ($options['mts_favicon'] != '') { ?>
<link rel="icon" href="<?php echo $options['mts_favicon']; ?>" type="image/x-icon" />
<?php } ?>
<!--iOS/android/handheld specific -->	
<link rel="apple-touch-icon" href="apple-touch-icon.png">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<?php }
}

/*------------[ Head ]-------------*/
if ( ! function_exists( 'mts_head' ) ) {
	function mts_head() { 
	global $options
?>
<!--start fonts-->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet" type="text/css">
<!--end fonts-->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js?ver=1.6.1"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/modernizr.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/customscript.js" type="text/javascript"></script>
<style type="text/css">
<?php if ($options['mts_logo'] != '') { ?>
#header #logo, #header #logo {text-indent: -999em; min-width:175px; }
#header #logo a, #header #logo a {background: url(<?php echo $options['mts_logo']; ?>) no-repeat; min-width: 175px; display: block; min-height: 70px; line-height: 70px; }
<?php } ?>
<?php if($options['mts_bg_color'] != '') { ?>
body {background-color:<?php echo $options['mts_bg_color']; ?>;}
<?php } ?>
<?php if($options['mts_bg_pattern_upload'] != '') { ?>
body {background-image:url(<?php echo $options['mts_bg_pattern_upload']; ?>);}
<?php } ?>
<?php if ($options['mts_layout'] == 'sclayout') { ?>
.main-container .content { border-right: 0; border-left: 1px #C6DFF1 solid; }
.article { float: right; margin-right:0;}
.sidebar.c-4-12 { float: left; padding-right: 0; padding-left: 1.3%; }
#tabber{margin-right:17px; margin-left:0;}
<?php } ?>
<?php echo $options['mts_custom_css']; ?>
</style>
<!--start custom CSS-->
<?php echo $options['mts_header_code']; ?>
<!--end custom CSS-->
<?php }
}

/*------------[ footer ]-------------*/
if ( ! function_exists( 'mts_footer' ) ) {
	function mts_footer() { 
	global $options
?>
<!--start social button script-->

<!--end social button script-->
<!--start footer code-->
<?php if ($options['mts_analytics_code'] != '') { ?>
<?php echo $options['mts_analytics_code']; ?>
<?php } ?>
<!--end footer code-->
<?php }
}

/*------------[ Copyrights ]-------------*/
if ( ! function_exists( 'mts_copyrights_credit' ) ) {
	function mts_copyrights_credit() { 
	global $options
?>
<!--start copyrights-->
<div class="row" id="copyright-note">
<span><?php echo $options['mts_copyrights']; ?></span>
<div class="footer-navigation">
	<nav id="navigation" >
		<?php if ( has_nav_menu( 'footer-menu' ) ) { ?>
			<?php wp_nav_menu( array( 'theme_location' => 'footer-menu', 'menu_class' => 'menu', 'container' => '', 'before' => '<span>&#8226;</span>' ) ); ?>
		<?php } else { ?>
			<ul class="menu">
				<?php wp_list_categories('title_li='); ?>
			</ul>
                <?php } ?>
	</nav>
</div> 
</div>
<!--end copyrights-->
<?php }
}

?>