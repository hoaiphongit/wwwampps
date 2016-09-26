<?php
$options = get_option('diary');	

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
<link href='http://fonts.googleapis.com/css?family=Merriweather:400,700' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js?ver=1.6.1"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/modernizr.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/customscript.js" type="text/javascript"></script>
<style type="text/css">
<?php if ($options['mts_logo'] != '') { ?>
#header h1, #header h2 {text-indent: -999em; min-width: 200px; }
#header h1 a, #header h2 a {background: url(<?php echo $options['mts_logo']; ?>) center no-repeat; min-width: 200px; display: block; min-height: 80px; line-height: 80px; }
<?php } ?>
<?php if ($options['mts_bg_pattern_upload'] != '') { ?>
body {background-image: url(<?php echo $options['mts_bg_pattern_upload']; ?>); }
<?php } ?>
<?php if ($options['mts_color_scheme'] != '') { ?>
.form-wrapper button {background-color:<?php echo $options['mts_color_scheme']; ?>; }
.single_post a, a:hover, .textwidget a, #commentform a, .sidebar.c-4-12 a:hover, .copyrights a:hover, a, #commentform input#submit:hover {color:<?php echo $options['mts_color_scheme']; ?>; }
.form-wrapper button:before { border-right-color: <?php echo $options['mts_color_scheme']; ?>; }
<?php } ?>
<?php echo $options['mts_custom_css']; ?>
</style>
<?php echo $options['mts_header_code']; ?>
<?php }
}

/*------------[ footer ]-------------*/
if ( ! function_exists( 'mts_footer' ) ) {
	function mts_footer() { 
	global $options
?>
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
<div class="top"><a href="#top" class="toplink">Back to Top &uarr;</a></div>
</div>
<!--end copyrights-->
<?php }
}
?>