<?php get_header(); ?>
<div id="page">
	<div class="content">
		<article class="article">
			<div id="content_box">
					<h1 class="postsby">
						<?php if (is_category()) { ?>
							<span><?php single_cat_title(); ?><?php _e(" Archive", "mythemeshop"); ?></span>
						<?php } elseif (is_tag()) { ?> 
							<span><?php single_tag_title(); ?><?php _e(" Archive", "mythemeshop"); ?></span>
						<?php } elseif (is_search()) { ?> 
							<span><?php _e("Search Results for:", "mythemeshop"); ?></span> <?php the_search_query(); ?>
						<?php } elseif (is_author()) { ?>
							<span><?php _e("Author Archive", "mythemeshop"); ?></span> 
						<?php } elseif (is_day()) { ?>
							<span><?php _e("Daily Archive:", "mythemeshop"); ?></span> <?php the_time('l, F j, Y'); ?>
						<?php } elseif (is_month()) { ?>
							<span><?php _e("Monthly Archive:", "mythemeshop"); ?>:</span> <?php the_time('F Y'); ?>
						<?php } elseif (is_year()) { ?>
							<span><?php _e("Yearly Archive:", "mythemeshop"); ?>:</span> <?php the_time('Y'); ?>
						<?php } ?>
					</h1>
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						<div class="post excerpt <?php echo (++$j % 2 == 0) ? 'last' : ''; ?>">
							<header>
								<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="nofollow" id="featured-thumbnail">
								<?php if ( has_post_thumbnail() ) { ?> 
								<?php echo '<div class="featured-thumbnail">'; the_post_thumbnail('featured',array('title' => '')); echo '</div>'; ?>
								<?php } else { ?>
								<div class="featured-thumbnail">
								<img width="200" height="200" src="<?php echo get_template_directory_uri(); ?>/images/nothumb.png" class="attachment-featured wp-post-image" alt="<?php the_title(); ?>">
								</div>
								<?php } ?>
								</a>
						
								<h2 class="title">
									<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a>
								</h2>
								<div class="post-info">
								<span class="theauthor">Posted in <?php $category = get_the_category(); echo '<a href="'.get_category_link($category[0]->cat_ID).'">'.$category[0]->cat_name.'</a>';?> by <?php the_author_posts_link(); ?></span>
								</div>
							</header><!--.header-->
							
							<div class="post-content image-caption-format-1">
								<?php echo excerpt(38);?>
							</div>
                            <div class="readMore"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark">Read More</a></div>
						</div><!--.post excerpt-->
					<?php endwhile; else: ?>
						<div class="post excerpt">
							<div class="no-results">
								<p><strong><?php _e('There has been an error.', 'mythemeshop'); ?></strong></p>
								<p><?php _e('We apologize for any inconvenience, please hit back on your browser or use the search form below.', 'mythemeshop'); ?></p>
								<?php get_search_form(); ?>
							</div><!--noResults-->
						</div>
					<?php endif; ?>
						
							<?php pagination();?>
							
			</div>
		</article>
<?php get_sidebar(); ?>
<?php get_footer(); ?>