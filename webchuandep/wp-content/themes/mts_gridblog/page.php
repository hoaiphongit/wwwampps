<?php $mts_options = get_option(MTS_THEME_NAME); ?>
<?php get_header(); ?>
<div id="page" class="<?php mts_single_page_class(); ?>">
    <article class="<?php mts_article_class(); ?>">
        <div id="content_box" >
            <?php if (have_posts()) while (have_posts()) : the_post(); ?>
                <div id="post-<?php the_ID(); ?>" <?php post_class('g post'); ?>>
                    <div class="single_post">
                        <header>
                            <h1 class="title single-title" itemprop="headline"><?php the_title(); ?></h1>
                        </header><!--.headline_area-->
                        <div class="post-single-content box mark-links entry-content">
                            <div class="thecontent" itemprop="articleBody">
                                <?php the_content(); ?>
                                <?php wp_link_pages(array('before' => '<div class="pagination">', 'after' => '</div>', 'link_before' => '<span class="current"><span class="currenttext">', 'link_after' => '</span></span>', 'next_or_number' => 'next_and_number', 'nextpagelink' => __('Next', 'mythemeshop'), 'previouspagelink' => __('Previous', 'mythemeshop'), 'pagelink' => '%', 'echo' => 1)); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php comments_template('', true); ?>
            <?php endwhile; ?>
        </div>
    </article>
    <?php get_sidebar(); ?>
    <?php get_footer(); ?>