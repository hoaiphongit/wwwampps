<?php
$mts_options = get_option(MTS_THEME_NAME);
/*------------[ Meta ]-------------*/
if ( ! function_exists( 'mts_meta' ) ) {
	function mts_meta(){
	global $mts_options, $post;
?>
<?php if ( !empty( $mts_options['mts_favicon'] ) ) { ?>
<link rel="icon" href="<?php echo esc_url( $mts_options['mts_favicon'] ); ?>" type="image/x-icon" />
<?php } ?>
<?php if ( !empty( $mts_options['mts_metro_icon'] ) ) { ?>
    <!-- IE10 Tile.-->
    <meta name="msapplication-TileColor" content="#FFFFFF">
    <meta name="msapplication-TileImage" content="<?php echo esc_attr( $mts_options['mts_metro_icon'] ); ?>">
<?php } ?>
<!--iOS/android/handheld specific -->
<?php if ( !empty( $mts_options['mts_touch_icon'] ) ) { ?>
    <link rel="apple-touch-icon-precomposed" href="<?php echo esc_url( $mts_options['mts_touch_icon'] ); ?>" />
<?php } ?>
<?php if ( ! empty( $mts_options['mts_responsive'] ) ) { ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
<?php } ?>
<?php if($mts_options['mts_prefetching'] == '1') { ?>
<?php if (is_front_page()) { ?>
	<?php $my_query = new WP_Query('posts_per_page=1'); while ($my_query->have_posts()) : $my_query->the_post(); ?>
	<link rel="prefetch" href="<?php the_permalink(); ?>">
	<link rel="prerender" href="<?php the_permalink(); ?>">
	<?php endwhile; wp_reset_postdata(); ?>
<?php } elseif (is_singular()) { ?>
	<link rel="prefetch" href="<?php echo esc_url( home_url() ); ?>">
	<link rel="prerender" href="<?php echo esc_url( home_url() ); ?>">
<?php } ?>
<?php } ?>
    <meta itemprop="name" content="<?php bloginfo( 'name' ); ?>" />
    <meta itemprop="url" content="<?php echo esc_attr( site_url() ); ?>" />
    <?php if ( is_singular() ) { ?>
    <meta itemprop="creator accountablePerson" content="<?php $user_info = get_userdata($post->post_author); echo $user_info->first_name.' '.$user_info->last_name; ?>" />
    <?php } ?>
<?php }
}

/*------------[ Head ]-------------*/
if ( ! function_exists( 'mts_head' ) ){
	function mts_head() {
	global $mts_options;
?>
<?php echo $mts_options['mts_header_code']; ?>
<?php }
}
add_action('wp_head', 'mts_head');

/*------------[ Copyrights ]-------------*/
if ( ! function_exists( 'mts_copyrights_credit' ) ) {
	function mts_copyrights_credit() { 
	global $mts_options
?>
<!--start copyrights-->
<div class="container">
<div class="row" id="copyright-note">
<div class="row_left"><a href="<?php echo esc_url( trailingslashit( home_url() ) ); ?>" title="<?php bloginfo('description'); ?>" rel="nofollow"><?php bloginfo('name'); ?></a> Copyright &copy; <?php echo date("Y") ?>. All Rights Reserved</div>
<div class="top"><?php echo $mts_options['mts_copyrights']; ?></div>
</div>
</div>
<!--end copyrights-->
<?php }
}

/*------------[ schema.org-enabled the_category() and the_tags() ]-------------*/
function mts_the_category( $separator = ', ' ) {
    $categories = get_the_category();
    $count = count($categories);
    foreach ( $categories as $i => $category ) {
        echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . sprintf( __( "View all posts in %s", 'mythemeshop' ), esc_attr( $category->name ) ) . '" ' . ' itemprop="articleSection">' . esc_html( $category->name ).'</a>';
        if ( $i < $count - 1 )
            echo $separator;
    }
}
function mts_the_tags($before = '', $sep = ', ', $after = '') {
    $before = '<div class="tags border-bottom">'.__('Tags: ', 'mythemeshop');
    $after = '</div>';

    $tags = get_the_tags();
    if (empty( $tags ) || is_wp_error( $tags ) ) {
        return;
    }
    $tag_links = array();
    foreach ($tags as $tag) {
        $link = get_tag_link($tag->term_id);
        $tag_links[] = '<a href="' . esc_url( $link ) . '" rel="tag" itemprop="keywords">' . $tag->name . '</a>';
    }
    echo $before.join($sep, $tag_links).$after;
}

/*------------[ pagination ]-------------*/
if (!function_exists('mts_pagination')) {
    function mts_pagination($pages = '', $range = 3) {
        $mts_options = get_option(MTS_THEME_NAME);
        if (isset($mts_options['mts_pagenavigation_type']) && $mts_options['mts_pagenavigation_type'] == '1' ) { // numeric pagination
            $showitems = ($range * 3)+1;
            global $paged; if(empty($paged)) $paged = 1;
            if($pages == '') {
                global $wp_query; $pages = $wp_query->max_num_pages; 
                if(!$pages){ $pages = 1; } 
            }
            if(1 != $pages) { 
                echo '<div class="pagination pagination-numeric"><ul>';
                
                if($paged > 2 && $paged > $range+1 && $showitems < $pages) 
                    echo "<li><a rel='nofollow' href='".esc_url( get_pagenum_link(1) )."'><i class='fa fa-angle-double-left'></i> ".__('First','mythemeshop')."</a></li>";
                if($paged > 1 && $showitems < $pages) 
                    echo "<li><a rel='nofollow' href='".esc_url( get_pagenum_link($paged - 1) )."' class='inactive'><i class='fa fa-angle-left'></i> ".__('Previous','mythemeshop')."</a></li>";
                for ($i=1; $i <= $pages; $i++){ 
                    if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) { 
                        echo ($paged == $i)? "<li class='current'><span class='currenttext'>".$i."</span></li>":"<li><a rel='nofollow' href='".esc_url( get_pagenum_link($i) )."' class='inactive'>".$i."</a></li>";
                    } 
                } 
                if ($paged < $pages && $showitems < $pages) 
                    echo "<li><a rel='nofollow' href='".esc_url( get_pagenum_link($paged + 1) )."' class='inactive'>".__('Next','mythemeshop')." <i class='fa fa-angle-right'></i></a></li>";
                if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) 
                    echo "<li><a rel='nofollow' class='inactive' href='".esc_url( get_pagenum_link($pages) )."'>".__('Last','mythemeshop')." <i class='fa fa-angle-double-right'></i></a></li>";
                
                echo '</ul></div>';
            }
        } else { // traditional or ajax pagination
            ?>
            <div class="pagination pagination-previous-next">
            <ul>
                <li class="nav-previous"><?php next_posts_link( '<i class="fa fa-angle-left"></i> '. __( 'Previous', 'mythemeshop' ) ); ?></li>
                <li class="nav-next"><?php previous_posts_link( __( 'Next', 'mythemeshop' ).' <i class="fa fa-angle-right"></i>' ); ?></li>
            </ul>
            </div>
            <?php
        }
    }
}

/*------------[ Related Posts ]-------------*/
if (!function_exists('mts_related_posts')) {
    function mts_related_posts() {
        global $post;
        $mts_options = get_option(MTS_THEME_NAME);
        //if(!empty($mts_options['mts_related_posts'])) { ?>	
    		<!-- Start Related Posts -->
    		<?php 
            $empty_taxonomy = false;
            if (empty($mts_options['mts_related_posts_taxonomy']) || $mts_options['mts_related_posts_taxonomy'] == 'tags') {
                // related posts based on tags
                $tags = get_the_tags($post->ID); 
                if (empty($tags)) { 
                    $empty_taxonomy = true;
                } else {
                    $tag_ids = array(); 
                    foreach($tags as $individual_tag) {
                        $tag_ids[] = $individual_tag->term_id; 
                    }
                    $args = array( 'tag__in' => $tag_ids, 
                        'post__not_in' => array($post->ID), 
                        'posts_per_page' => $mts_options['mts_related_postsnum'], 
                        'ignore_sticky_posts' => 1, 
                        'orderby' => 'rand' 
                    );
                }
             } else {
                // related posts based on categories
                $categories = get_the_category($post->ID); 
                if (empty($categories)) { 
                    $empty_taxonomy = true;
                } else {
                    $category_ids = array(); 
                    foreach($categories as $individual_category) 
                        $category_ids[] = $individual_category->term_id; 
                    $args = array( 'category__in' => $category_ids, 
                        'post__not_in' => array($post->ID), 
                        'posts_per_page' => $mts_options['mts_related_postsnum'],  
                        'ignore_sticky_posts' => 1, 
                        'orderby' => 'rand' 
                    );
                }
             }
            if (!$empty_taxonomy) {
    		$my_query = new WP_Query( $args ); if( $my_query->have_posts() ) {
    			echo '<div class="related-posts">';
                echo '<h4>'.__('Related Posts','mythemeshop').'</h4>';
                echo '<div class="clear">';
                $posts_per_row = 3;
                $j = 0;
    			while( $my_query->have_posts() ) { $my_query->the_post(); ?>
    			<article class="latestPost excerpt  <?php echo (++$j % $posts_per_row == 0) ? 'last' : ''; ?>">
                    <a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="nofollow" id="featured-thumbnail">
					    <?php echo '<div class="featured-thumbnail">'; the_post_thumbnail('widgetthumb',array('title' => '')); echo '</div>'; ?>
                    </a>
                    <header>
                        <h2 id="recent_posts_title" class="title front-view-title"><a href="<?php echo esc_url(get_the_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>"><?php the_title(); ?></a></h2>
                        <div class="post-info">
                            <?php mts_the_postinfo_item( 'author' ) ?>
                        </div>
                    </header>
                </article><!--.post.excerpt-->
    			<?php } echo '</div></div>'; }} wp_reset_postdata(); ?>
    		<!-- .related-posts -->
    	<?php //}
    }
}

/*------------[ Post Meta Info ]-------------*/
if ( ! function_exists('mts_the_postinfo' ) ) {
    function mts_the_postinfo( $section = 'home' ) {
        $mts_options = get_option( MTS_THEME_NAME );
        $opt_key = 'mts_'.$section.'_headline_meta_info';
        
        if ( isset( $mts_options[ $opt_key ] ) && is_array( $mts_options[ $opt_key ] ) && array_key_exists( 'enabled', $mts_options[ $opt_key ] ) ) {
            $headline_meta_info = $mts_options[ $opt_key ]['enabled'];
        } else {
            $headline_meta_info = array();
        }
        if ( ! empty( $headline_meta_info ) ) { ?>
			<div class="post-info">
                <?php foreach( $headline_meta_info as $key => $meta ) { mts_the_postinfo_item( $key ); } ?>
			</div>
		<?php }
    }
}
if ( ! function_exists('mts_the_postinfo_item' ) ) {
    function mts_the_postinfo_item( $item ) {
        switch ( $item ) {
            case 'author':
            ?>
                <span class="theauthor"><?php _e('By','mythemeshop'); ?> <span itemprop="author"><?php the_author_posts_link(); ?></span></span>
            <?php
            break;
            case 'date':
            ?>
                <span class="thetime updated"><i class="fa fa-calendar"></i> <span itemprop="datePublished"><?php the_time( get_option( 'date_format' ) ); ?></span></span>
            <?php
            break;
            case 'category':
            ?>
                <span class="thecategory"><?php mts_the_category(', ') ?></span>
            <?php
            break;
            case 'comment':
            ?>
                <span class="thecomment"><a rel="nofollow" href="<?php echo esc_url( get_comments_link() ); ?>" itemprop="interactionCount"><?php comments_number();?></a></span>
            <?php
            break;
        }
    }
}

/*------------[ Class attribute for <article> element ]-------------*/
if ( ! function_exists( 'mts_article_class' ) ) {
    function mts_article_class() {
        $mts_options = get_option( MTS_THEME_NAME );
        $class = '';
        
        // sidebar or full width
        if ( mts_custom_sidebar() == 'mts_nosidebar' ) {
            $class = 'ss-full-width';
        } else {
            $class = 'article';
        }
        
        echo $class;
    }
}

/*------------[ Class attribute for #page element ]-------------*/
if ( ! function_exists( 'mts_single_page_class' ) ) {
    function mts_single_page_class() {
        $class = '';

        if ( is_single() || is_page() ) {

            $class = 'single';
        }

        echo $class;
    }
}

/*------------[ Archive Posts ]-------------*/
if ( ! function_exists( 'mts_archive_post' ) ) {
    function mts_archive_post( $layout = '' ) {

        $mts_options = get_option(MTS_THEME_NAME);
        ?>
        <a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="nofollow" id="featured-thumbnail">
            <?php echo '<div class="featured-thumbnail">'; the_post_thumbnail('featured',array('title' => '')); echo '</div>'; ?>
            <div class="featured-hover">
                 <span>+</span>
			</div>
            <?php if (function_exists('wp_review_show_total')) wp_review_show_total(true, 'latestPost-review-wrapper'); ?>
        </a>
        <header>
            <h2 class="title front-view-title" itemprop="headline"><a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>"><?php the_title(); ?></a></h2>
        </header>
        <div class="thecategory"><?php mts_the_category() ?></div>
        <?php if (empty($mts_options['mts_full_posts'])) : ?>
            <div class="front-view-content">
                <?php echo mts_excerpt(26); ?>
            </div>
                <?php mts_the_postinfo(); ?>
            <?php mts_readmore(); ?>
        <?php else : ?>
            <div class="front-view-content full-post">
                <?php the_content(); ?>
            </div>
            <?php if (mts_post_has_moretag()) : ?>
                <?php mts_readmore(); ?>
            <?php endif; ?>
        <?php endif;
    }
}