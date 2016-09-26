<?php get_header(); ?>
<div id="page">
	<article class="article">
		<div id="content_box" class="single_post">
			<header>
				<div>
					<h1 class="single-title"><?php _e('Error 404 Not Found', 'mythemeshop'); ?></h1>
				</div>
			</header>
			<div class="post-content">
				<p><?php _e('Oops! We couldn\'t find this Page.', 'mythemeshop'); ?></p>
				<p><?php _e('Please check your URL or use the search form below.', 'mythemeshop'); ?></p>
				<?php get_search_form();?>
			</div><!--.post-content--><!--#error404 .post-->
		</div><!--#content-->
	</article>
	<?php get_sidebar(); ?>
<?php get_footer(); ?>