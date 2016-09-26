<?php $mts_options = get_option(MTS_THEME_NAME); ?>
<?php get_header(); ?>
<div id="page">
	<div class="<?php mts_article_class(); ?>">
		<div id="content_box">
			<h1 class="postsby">
				<?php if (is_category()) { ?>
					<span><?php single_cat_title(); ?><?php _e(" Archive", "mythemeshop"); ?></span>
				<?php } elseif (is_tag()) { ?> 
					<span><?php single_tag_title(); ?><?php _e(" Archive", "mythemeshop"); ?></span>
				<?php } elseif (is_author()) { ?>
					<span><?php  $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); echo esc_html( $curauth->nickname ); _e(" Archive", "mythemeshop"); ?></span> 
				<?php } elseif (is_day()) { ?>
					<span><?php _e("Daily Archive:", "mythemeshop"); ?></span> <?php the_time('l, F j, Y'); ?>
				<?php } elseif (is_month()) { ?>
					<span><?php _e("Monthly Archive:", "mythemeshop"); ?></span> <?php the_time('F Y'); ?>
				<?php } elseif (is_year()) { ?>
					<span><?php _e("Yearly Archive:", "mythemeshop"); ?></span> <?php the_time('Y'); ?>
				<?php } ?>
			</h1>
			<?php $j = 0; if (have_posts()) : while (have_posts()) : the_post(); ?>
				<article class="latestPost excerpt  <?php echo (++$j % 3 == 0) ? 'last' : ''; ?>" itemscope itemtype="http://schema.org/BlogPosting">
					<?php mts_archive_post(); ?>
				</article><!--.post excerpt-->
			<?php endwhile; endif; ?>

			<?php if ( $j !== 0 ) { // No pagination if there is no posts ?>
				<?php mts_pagination(); ?>
			<?php } ?>
		</div>
	</div>
	<?php get_sidebar(); ?>
<?php get_footer(); ?>