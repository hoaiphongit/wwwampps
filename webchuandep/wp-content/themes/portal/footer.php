<?php $options = get_option('portal'); ?>
	</div><!--#page-->
</div><!--.container-->
</div>
	<footer>
		<div class="container">
			<div class="footer-widgets">
				<?php widgetized_footer(); ?>
			</div><!--.footer-widgets-->
            <div class="copyrights">
				<?php mts_copyrights_credit(); ?>
			</div>
		</div><!--.container-->
	</footer><!--footer-->
</div><!--.main-container-->	
<?php mts_footer(); ?>
<?php wp_footer(); ?>
</body>
</html>