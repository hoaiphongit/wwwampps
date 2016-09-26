<?php
$options = get_option('portal');	

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
<style type="text/css">
<?php if($options['mts_bg_color'] != '') { ?>
body {background-color:<?php echo $options['mts_bg_color']; ?>;}
<?php } ?>
<?php if ($options['mts_bg_pattern_upload'] != '') { ?>
body {background-image: url(<?php echo $options['mts_bg_pattern_upload']; ?>);}
<?php } ?>
<?php if ($options['mts_color_scheme'] != '') { ?>
#searchform input[type="submit"], #navigation ul li a:hover, .current-menu-item, .current_page_item, .tagcloud a:hover, .currenttext, .pagination a:hover {background-color:<?php echo $options['mts_color_scheme']; ?>; }
.single_post a, a:hover, .title a:hover, .textwidget a, #commentform a, a,.rthumb_text:hover,.post_date,.breaking_title, #navigation ul ul a:hover, .sidebar.c-4-12 a:hover {color:<?php echo $options['mts_color_scheme']; ?>; }
.reply a:hover,#commentform input#submit:hover, #cancel-comment-reply-link:hover{border:1px solid <?php echo $options['mts_color_scheme']; ?>; background-color:<?php echo $options['mts_color_scheme']; ?>;}
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
<!--Twitter Button Script------>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
<!--Facebook Like Button Script------>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=136911316406581";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script type="text/javascript">
jQuery(document).ready(function(e) {
	(function($){
		$('.ad-300').parent('li').addClass('add_300_cont');
		$('.widget-sidebar h3').append('<span class="title_box"></span>');
		//$('.sf-sub-indicator').text(">>");
	}(jQuery));
});
</script>
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
<span><a href="<?php echo home_url(); ?>/" title="<?php bloginfo('description'); ?>"><?php bloginfo('name'); ?></a> Copyright &copy; <?php echo date("Y") ?>.</span>
<div class="top"><?php echo $options['mts_copyrights']; ?> <a href="#top" class="toplink"><img src="<?php echo get_template_directory_URI(); ?>/images/top.png" alt=""/></a></div>
</div>
<!--end copyrights-->
<?php }
}

?>