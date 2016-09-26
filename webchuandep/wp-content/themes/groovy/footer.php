<?php $options = get_option('groovy'); ?>
	</div><!--#page-->
</div><!--.container-->
</div>
	<footer>
		<div class="container">
			<div class="footer-widgets">
				<?php widgetized_footer(); ?>                
               	<div class="copyrights">
					<div class="row" id="copyright-note">
	                 	<span><a href="<?php echo home_url(); ?>/" title="<?php bloginfo('description'); ?>"><?php bloginfo('name'); ?></a> Copyright &copy; <?php echo date("Y") ?>.</span><div class="top"><?php echo $options['mts_copyrights']; ?> <a href="#top" class="toplink">Back to Top ↑</a></div>
					</div>
				</div> 
			</div><!--.footer-widgets-->
		</div><!--.container-->
	</footer><!--footer-->
<?php wp_footer(); ?>
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

<?php if ($options['mts_analytics_code'] != '') { ?>
<?php echo $options['mts_analytics_code']; ?>
<?php } ?>
</body>
</html>