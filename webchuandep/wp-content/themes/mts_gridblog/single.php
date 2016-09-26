<?php get_header(); ?>
<?php $mts_options = get_option(MTS_THEME_NAME); ?>
<div id="page" class="<?php mts_single_page_class(); ?>">
    <article class="<?php mts_article_class(); ?>" itemscope itemtype="http://schema.org/BlogPosting">
        <div id="content_box" >
            <?php if (have_posts()) while (have_posts()) : the_post(); ?>
                <div id="post-<?php the_ID(); ?>" <?php post_class('g post'); ?>>
                    <div class="single_post">
                        <header>
                            <h1 class="title single-title entry-title" itemprop="headline"><?php the_title(); ?></h1>
                            <?php mts_the_postinfo('single'); ?>
                        </header><!--.headline_area-->
                        <div class="post-single-content box mark-links entry-content">
                            <div class="thecontent" itemprop="articleBody">
                                <?php the_content(); ?>
                            </div>
                            <?php wp_link_pages(array('before' => '<div class="pagination">', 'after' => '</div>', 'link_before' => '<span class="current"><span class="currenttext">', 'link_after' => '</span></span>', 'next_or_number' => 'next_and_number', 'nextpagelink' => __('Next', 'mythemeshop'), 'previouspagelink' => __('Previous', 'mythemeshop'), 'pagelink' => '%', 'echo' => 1)); ?>    
                            
                            <?php mts_the_tags('<span class="tagtext">' . __('Tags', 'mythemeshop') . ':</span>', ', '); ?>
                        </div><!--.post-single-content-->
                    </div><!--.single_post-->
                    
                    <?php mts_related_posts(); ?>

                    <div class="postauthor">
                        <h4><?php _e('About The Author', 'mythemeshop'); ?></h4>
                        <div class="author_wrap">
                            <?php if (function_exists('get_avatar')) {
                                echo get_avatar(get_the_author_meta('email'), '100');
                            } ?>
                            <h5 class="vcard"><a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" rel="nofollow" class="fn"><?php the_author_meta('nickname'); ?></a></h5>
                            <p><?php the_author_meta('description') ?></p>
                        </div>
                    </div>
                </div><!--.g post-->
                <?php comments_template('', true); ?>
            <?php endwhile; /* end loop */ ?>
        </div>
    </article>
<?php get_sidebar(); ?>
<?php get_footer(); ?>