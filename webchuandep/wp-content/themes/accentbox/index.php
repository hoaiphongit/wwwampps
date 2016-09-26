<?php get_header(); ?>
<div id="page">
	<div class="content">
	<?php if ( is_active_sidebar( 'wcd_globals_before_front' ) ) : ?>
		<div class="globals-before-front">
			<?php dynamic_sidebar( 'wcd_globals_before_front' ); ?>
		</div>
	<?php endif; ?>
	
		<article class="article">
			<div id="content_box">
				
				<?php if ( is_active_sidebar( 'wcd_globals_front' ) ) : ?>
						<?php dynamic_sidebar( 'wcd_globals_front' ); ?>
				<?php endif; ?>

			</div>
		</article>
		<?php get_sidebar(); ?>
	
	<?php if ( is_active_sidebar( 'wcd_globals_after_front' ) ) : ?>
		<?php dynamic_sidebar( 'wcd_globals_after_front' ); ?>
	<?php endif; ?>
<?php get_footer(); ?>