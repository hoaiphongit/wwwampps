<?php $mts_options = get_option(MTS_THEME_NAME); ?>
<?php get_header(); ?>
<div id="page">
	<div class="article">
		<div id="content_box">
            <?php if ( !is_paged() ) {
                $featured_categories = array();
                if ( !empty( $mts_options['mts_featured_categories'] ) ) {
                    foreach ( $mts_options['mts_featured_categories'] as $section ) {
                        $category_id = $section['mts_featured_category'];
                        $featured_categories[] = $category_id;
                        $posts_num = $section['mts_featured_category_postsnum'];
                        if ( 'latest' == $category_id ) { ?>
                            <?php $j = 0; if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                                <article class="latestPost excerpt <?php echo (++$j % 3 == 0) ? 'last' : ''; ?>" itemscope itemtype="http://schema.org/BlogPosting">
                				    <?php mts_archive_post(); ?>
                                </article>
                			<?php endwhile; endif; ?>
                			
                            <?php if ( $j !== 0 ) { // No pagination if there is no posts ?>
                                <?php mts_pagination(); ?>
                            <?php } ?>
                            
                        <?php } else { // if $category_id != 'latest': ?>
                            <h3 class="featured-category-title"><a href="<?php echo esc_url( get_category_link( $category_id ) ); ?>" title="<?php echo esc_attr( get_cat_name( $category_id ) ); ?>"><?php echo esc_html( get_cat_name( $category_id ) ); ?></a></h3>
                            <?php
                            $j = 0;
                            $cat_query = new WP_Query('cat='.$category_id.'&posts_per_page='.$posts_num);
                            if ( $cat_query->have_posts() ) : while ( $cat_query->have_posts() ) : $cat_query->the_post(); ?>
                            <article id="featuredCategoryPost" class="latestPost excerpt <?php echo (++$j % 3 == 0) ? 'last' : ''; ?>" itemscope itemtype="http://schema.org/BlogPosting">
                				    <?php mts_archive_post(); ?>
                                </article>
                			<?php
                            endwhile; endif; wp_reset_postdata();
                        }
                    }
                }

            } else { //Paged
                $j = 0; if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <article class="latestPost excerpt <?php echo (++$j % 3 == 0) ? 'last' : ''; ?>" itemscope itemtype="http://schema.org/BlogPosting">
				    <?php mts_archive_post(); ?>
                </article>
                <?php endwhile; endif; ?>

                <?php if ( $j !== 0 ) { // No pagination if there is no posts ?>
                    <?php mts_pagination(); ?>
                <?php } 
            } ?>
		</div>
	</div>
	<?php get_sidebar(); ?>
<?php get_footer(); ?>