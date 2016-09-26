<?php $options = get_option('greenchilli'); ?>
	</div><!--#page-->
</div><!--.container-->
</div>
	<footer>
		<div class="container">
			<div class="footer-widgets">
                <div class="footer-w-container"><?php widgetized_footer(); ?></div>
                <div class="copyrights"><?php mts_copyrights_credit(); ?></div> 
			</div><!--.footer-widgets-->
		</div><!--.container-->
	</footer><!--footer-->
<?php mts_footer(); ?>
<?php wp_footer(); ?>
</body>
</html>