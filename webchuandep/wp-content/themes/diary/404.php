<?php get_header(); ?>
<div class="single">
	<div class="content">
		<article class="article">
			<div id="content_box" >
                    <div class="single_post">
					<header>
						<div class="title">
							<h1><?php _e('Error 404 Not Found', 'mythemeshop'); ?></h1>
						</div>
					</header>
					<div class="post-single-content box mark-links">
						<div class="post-content">
						<p><?php _e('Oops! We couldn\'t Found this Page.', 'mythemeshop'); ?></p>
						<p><?php _e('Please check your URL or use the search form below.', 'mythemeshop'); ?></p>
						<?php get_search_form();?>
						</div>
					</div><!--.post-content box mark-links-->
					</div><!--.g post-->
			</div>
</article>
</div>
<?php get_footer(); ?>