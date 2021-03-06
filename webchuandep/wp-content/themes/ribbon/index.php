<?php $options = get_option('ribbon'); ?>
<?php get_header(); ?>
<div id="page">
	<div class="content">
		<article class="article">
			<div id="content_box" class="home_page">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<div class="post excerpt <?php echo (++$j % 2 == 0) ? 'last' : ''; ?>">
						<div class="post-date-ribbon"><div class="corner"></div><?php the_time('d M Y'); ?></div>
						<header>
							<h2 class="title">
								<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a>
							</h2>
							<div class="post-info">
								<div class="author_mt hp_meta"><span class="mt_icon"> </span><?php _e('By ','mythemeshop'); ?><?php the_author_posts_link(); ?></div>
								<div class="cat_mt hp_meta"><span class="mt_icon"> </span><?php the_category(', '); ?></div>
								<div class="comment_mt hp_meta"><span class="mt_icon"> </span> <a href="<?php comments_link(); ?>"><?php comments_number(' 0 Comments',' 1 Comment',' % Comments'); ?></a></div>
							</div>
						</header><!--.header-->
						<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="nofollow" id="featured-thumbnail">
							<?php if ( has_post_thumbnail() ) { ?> 
								<?php echo '<div class="featured-thumbnail">'; the_post_thumbnail('featured',array('title' => '')); echo '</div>'; ?>
							<?php } ?>
						</a>
						<div class="post-content image-caption-format-1">
							<?php echo excerpt(56);?>
						</div>
						<div class="readMore"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php _e('Read More','mythemeshop'); ?></a></div>
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
				<?php if ($options['mts_pagenavigation'] == '1') { ?>
					<?php pagination($additional_loop->max_num_pages);?>
				<?php } else { ?>
					<div class="pnavigation2">
						<div class="nav-previous"><?php next_posts_link( __( '&larr; '.'Older posts', 'mythemeshop' ) ); ?></div>
						<div class="nav-next"><?php previous_posts_link( __( 'Newer posts'.' &rarr;', 'mythemeshop' ) ); ?></div>
					</div>
				<?php } ?>		
			</div>
		</article>
		<?php get_sidebar(); ?>
<?php get_footer(); ?>