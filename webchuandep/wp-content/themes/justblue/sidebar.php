<aside class="sidebar c-4-12">
<div id="sidebars" class="g">
	<div class="sidebar">
	<ul class="sidebar_list">
		<?php if ( ! dynamic_sidebar( 'Sidebar' )) : ?>
	
			<li id="sidebar-search" class="widget">
				<h3><?php _e('Search', 'mythemeshop'); ?></h3>
				<?php get_search_form(); ?>
			</li>
				
			<li id="sidebar-archives" class="widget">
				<h3><?php _e('Archives', 'mythemeshop') ?></h3>
				<ul>
					<?php wp_get_archives( 'type=monthly' ); ?>
				</ul>
			</li>
	
			<li id="sidebar-meta" class="widget">
				<h3><?php _e('Meta', 'mythemeshop') ?></h3>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</li>
	
		<?php endif; ?>
	</ul>
    <ul class="sidebar_rows">
    <div class="sb_left"><?php dynamic_sidebar('sidebar_2'); ?></div>
    <div class="sb_right"><?php dynamic_sidebar('sidebar_3'); ?></div>    
    </ul>
    <?php if ( ! dynamic_sidebar( 'sidebar_4' )) : ?>
    <ul class="sidebar_list">
    <?php dynamic_sidebar('sidebar_4'); ?>
    <?php endif; ?>
    </ul>
	</div>
</div><!--sidebars-->
</aside>