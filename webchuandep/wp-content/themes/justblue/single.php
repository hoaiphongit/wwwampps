<?php get_header(); ?>
<?php $options = get_option('justblue'); ?>
<div id="page" class="single">
	<div class="content">
		<article class="article">
			<div id="content_box" >
				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
					<div id="post-<?php the_ID(); ?>" <?php post_class('g post'); ?>>
                    <div class="single_post">
						<header>
						<h1 class="title single-title"><?php the_title(); ?></h1>
						</header><!--.headline_area-->
						<?php if($options['mts_headline_meta'] == '1') { ?>
                            <div class="post-info">
                            <?php _e('Posted in ','mythemeshop'); the_category(', ') ?><?php _e(' by ','mythemeshop'); the_author_posts_link(); ?> <?php _e(' On ','mythemeshop'); the_time('F j, Y'); ?><span class="thecomment"><a href="<?php comments_link(); ?>"><?php comments_number('. No comments','. 1 Comment','. % Comments'); ?></a></span>
                            </div>
						<?php } ?>
						<div class="post-single-content box mark-links">
							<?php the_content(); ?>
							<?php wp_link_pages('before=<div class="pagination2">&after=</div>'); ?>
						<?php if($options['mts_tags'] == '1') { ?>
							<div class="tags"><?php the_tags('<span class="tagtext">Tags:</span>',',') ?></div>
						<?php } ?>
							</div>
						</div><!--.post-content box mark-links-->
						<?php if($options['mts_related_posts'] == '1') { ?>	
							<?php
							$categories = get_the_category($post->ID);
							if ($categories) {
							$category_ids = array();
							foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;

							$args=array(
							'category__in' => $category_ids,
							'post__not_in' => array($post->ID),
							'orderby'=> 'rand',
							'showposts'=>3, // Number of related posts that will be shown.
							'ignore_sticky_posts'=>1
							);
							$my_query = new wp_query( $args );
							if( $my_query->have_posts() ) {
								echo '<div class="related-posts"><div class="postauthor-top"><h3>'.__('Related Posts','mythemeshop').'</h3></div><ul>';
									$counter = 0;
									while( $my_query->have_posts() ) {
										++$counter;
										if($counter == 3) {
										$postclass = 'last';
										$counter = 0;
							} else { $postclass = ''; }
							$my_query->the_post();?>
							<li class="<?php echo $postclass; ?>">
								<a rel="nofollow" class="relatedthumb" href="<?php the_permalink()?>" rel="bookmark" title="<?php the_title(); ?>">
									<span class="rthumb">
										<?php if(has_post_thumbnail()): ?>
											<?php the_post_thumbnail('related', 'title='); ?>
										<?php else: ?>
											<img src="<?php echo get_template_directory_uri(); ?>/images/relthumb.png" alt="<?php the_title(); ?>"  width='175' height='125' class="wp-post-image" />									
										<?php endif; ?>
									</span>
	                                <span><?php the_title(); ?></span>
                                </a>
                                <p>
                                    <?php echo excerpt(10);?>
                                </p>    
							</li>
						<?php
						}
						echo '</ul></div>';
						} } wp_reset_query(); ?>
							<!-- .related-posts -->
                    <?php }?>
		</div><!--.g post-->
		<?php comments_template( '', true ); ?>
		<?php endwhile; /* end loop */ ?>
	</div>
</article>
<?php get_sidebar(); ?>
<?php get_footer(); ?>