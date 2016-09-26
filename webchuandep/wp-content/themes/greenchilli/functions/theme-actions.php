<?php
$options = get_option('greenchilli');	

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
<link href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed:400,700" rel="stylesheet" type="text/css">
<!--end fonts-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/modernizr.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/customscript.js" type="text/javascript"></script>
<style type="text/css">
<?php if ($options['mts_logo'] != '') { ?>
#header h1, #header h2 {text-indent: -999em; min-width:286px; }
#header h1 a, #header h2 a {background: url(<?php echo $options['mts_logo']; ?>) no-repeat; min-width: 188px; display: block; min-height: 70px; line-height: 70px; }
<?php } ?>
<?php if($options['mts_bg_color'] != '') { ?>
body {background-color:<?php echo $options['mts_bg_color']; ?>;}
<?php } ?>
<?php if ($options['mts_bg_pattern_upload'] != '') { ?>
body {background-image: url(<?php echo $options['mts_bg_pattern_upload']; ?>);}
<?php } ?>
<?php if ($options['mts_color_scheme'] != '') { ?>
.nav-previous a, .nav-next a, .comment_cont span, #navigation ul ul a:hover, .flex-control-nav li a:hover, #navigation ul a:hover,.flex-control-nav li .active,#tabber ul.tabs li a.selected,#tabber ul.tabs li.tab-recent-posts a.selected,.readMore a,.currenttext, .pagination a:hover,.mts-subscribe input[type="submit"], .date_container, #commentform input#submit,.comment_cont span {background-color:<?php echo $options['mts_color_scheme']; ?>; }
.tagcloud a {border-color:<?php echo $options['mts_color_scheme']; ?>; }
.single_post a, a:hover, #logo a, .textwidget a, #commentform a, #tabber .inside li a, .copyrights a:hover, a,.f-widget .popular-posts li a:hover, .comment-meta a,.pp_date {color:<?php echo $options['mts_color_scheme']; ?>; }
.comment_cont span:after{border-right-color:<?php echo $options['mts_color_scheme']; ?>;}
<?php } ?>
<?php if ($options['mts_layout'] == 'sclayout') { ?>
.article { float: right; padding-left:0 !important; padding-right: 1.8%;}
.date_container{ right:-61px !important; }
.sidebar.c-4-12 { float: left; padding-left: 1.8%; padding-right: 0; }
@media screen and (max-width:720px) {
.article { padding-right: 0; }
.sidebar.c-4-12 {padding-left: 0}
}
<?php	
}
?>
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
<!--start footer code-->
<?php if ($options['mts_analytics_code'] != '') { ?>
<?php echo $options['mts_analytics_code']; ?>
<?php } ?>
<!--end footer code-->
<script type="text/javascript">
jQuery(document).ready(function(e) {
    (function($){
		$('#searchform input').attr('placeholder','Search this site...');
		$('.comment-author').parent('div').addClass('commentContainer');
	}(jQuery));
});
</script>
<?php }
}

/*------------[ Copyrights ]-------------*/
if ( ! function_exists( 'mts_copyrights_credit' ) ) {
	function mts_copyrights_credit() { 
	global $options
?>
<!--start copyrights-->
<div class="row" id="copyright-note">
<span><a href="<?php echo home_url(); ?>/" title="<?php bloginfo('description'); ?>"><?php bloginfo('name'); ?></a> Copyright &copy; <?php echo date("Y") ?>.</span>
<div class="top"><?php echo $options['mts_copyrights']; ?> <a href="#top" class="toplink">Back to Top &uarr;</a></div>
</div>
<!--end copyrights-->
<?php }
}

?>