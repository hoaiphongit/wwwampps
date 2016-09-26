<?php get_header(); ?>
<?php $mts_options = get_option('dualshock'); ?>
<div id="page" class="single">
	<div class="content">
		<article class="article">
			<div id="content_box" >
				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
					<div id="post-<?php the_ID(); ?>" <?php post_class('g post'); ?>>
						<div class="single_post">
							<?php if ($mts_options['mts_breadcrumb'] == '1') { ?>
								<div class="breadcrumb"><?php the_breadcrumb(); ?></div>
							<?php } ?>
							<header>
								<h1 class="title single-title"><?php the_title(); ?></h1>
								<?php if($mts_options['mts_headline_meta'] == '1') { ?>
									<div class="post-info">
                                        <span class="theauthor"><?php _e('Author: ','mythemeshop'); the_author_posts_link(); ?></span>
                                        <span class="thecategory"><?php _e(' Category: ','mythemeshop'); the_category(', ') ?></span>
                                        <span class="thetime"><?php the_time('j M y'); ?></span>
                    				</div>
								<?php } ?>
							</header><!--.headline_area-->
							<div class="post-single-content box mark-links">
								<?php the_content(); ?>
								<?php wp_link_pages(array('before' => '<div class="pagination">', 'after' => '</div>', 'link_before'  => '<span class="current"><span class="currenttext">', 'link_after' => '</span></span>', 'next_or_number' => 'next_and_number', 'nextpagelink' => __('Next','mythemeshop'), 'previouspagelink' => __('Previous','mythemeshop'), 'pagelink' => '%','echo' => 1 )); ?>
								<?php if($mts_options['mts_tags'] == '1') { ?>
									<div class="tags"><?php the_tags('<span class="tagtext">'.__('Tags','mythemeshop').':</span>',', ') ?></div>
								<?php } ?>
							</div>
						</div><!--.post-content box mark-links-->
						<?php if($mts_options['mts_related_posts'] == '1') { ?>	
							<?php $categories = get_the_category($post->ID); if ($categories) { $category_ids = array(); foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id; $args=array( 'category__in' => $category_ids, 'post__not_in' => array($post->ID), 'showposts'=>2, 'ignore_sticky_posts'=>1, 'orderby' => 'rand' );
							$my_query = new wp_query( $args ); if( $my_query->have_posts() ) { $counter = 0; 
								echo '<div class="related-posts"><div class="postauthor-top"><h3>'.__('Related Posts','mythemeshop').'</h3></div><ul>';
								while( $my_query->have_posts() ) { ++$counter; if($counter == 2) { $postclass = 'last'; $counter = 0; } else { $postclass = ''; } $my_query->the_post();?>
								<li class="<?php echo $postclass; ?>">
									<a rel="nofollow" class="relatedthumb" href="<?php the_permalink()?>" rel="bookmark" title="<?php the_title(); ?>">
										<span class="rthumb">
											<?php if(has_post_thumbnail()): ?>
												<?php the_post_thumbnail('widgetthumb', 'title='); ?>
											<?php else: ?>
												<img src="<?php echo get_template_directory_uri(); ?>/images/smallthumb.png" alt="<?php the_title(); ?>"  width='85' height='65' class="wp-post-image" />
											<?php endif; ?>
										</span>
										<span class="related_title">
											<?php the_title(); ?>
										</span>
									</a>
                                    <span class="related_theauthor"><?php _e('by ','mythemeshop'); the_author_posts_link(); ?></span>
								</li>
								<?php } echo '</ul></div>'; }} wp_reset_query(); ?>
							<!-- .related-posts -->
                        <?php }?>  
						<?php if($mts_options['mts_author_box'] == '1') { ?>
							<div class="postauthor">
								<h4><?php _e('About the Author', 'mythemeshop'); ?></h4>
								<?php if(function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('email'), '100' );  } ?>
								<h5><?php the_author_meta( 'nickname' ); ?></h5>
								<p><?php the_author_meta('description') ?></p>
							</div>
						<?php }?>  
					</div>
					<?php comments_template( '', true ); ?>
				<?php endwhile; ?>
			</div>
		</article>
		<?php get_sidebar(); ?>
<?php get_footer(); ?>