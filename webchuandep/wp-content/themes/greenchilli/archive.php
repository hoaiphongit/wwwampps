<?php $options = get_option('greenchilli'); ?>
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
					<div class="post excerpt <?php echo (++$j % 2 == 0) ? 'last' : ''; ?> date_con_handler">
		            	<div class="date_container">
		                	<?php the_time('j M Y'); ?>
		                </div>
						<?php if ( has_post_thumbnail() ) { ?> 
						<header>
		                	<div class="featured-thumbnail">
							<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="nofollow" class="homepageimg" id="featured-thumbnail"><?php the_post_thumbnail('home_img',array('title' => '')); ?></a>
		                    </div>
						</header><!--.header-->
						<?php } ?>
		                <div class="home_post_container">                                  
		                    <h2 class="title"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		                    <div class="post-info">
		                    	<?php _e('By ','mythemeshop'); the_author_posts_link(); ?><?php _e(' On ','mythemeshop'); the_time('j F Y'); ?><?php _e(' In ','mythemeshop'); the_category(', ') ?>  
		                    </div>
		                    <div class="post-content image-caption-format-1"><?php echo excerpt(38);?></div>
							<div class="post_meta_custom">
							    <div class="comment_cont"><a class="comment-icon" href="<?php comments_link(); ?>" rel="nofollow">
								        <span class="commentnumber"><?php comments_number('0 Comments','1 Comment','% Comments'); ?></span>
							        </a> 
							    </div>
							    <div class="readMore"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark">Read More</a></div>
							</div>
		                </div>
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
				<?php if ( isset($options['mts_pagenavigation']) && $options['mts_pagenavigation'] == '1' ) { ?>
					<?php pagination();?>
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