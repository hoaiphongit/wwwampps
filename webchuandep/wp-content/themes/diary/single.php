<?php get_header(); ?>
<?php $options = get_option('diary'); ?>
<div id="page" class="single">
	<div class="content">
		<article class="article">
			<div id="content_box" >
				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
					<div id="post-<?php the_ID(); ?>" <?php post_class('g post'); ?>>
                    <div class="single_post">
					<header>
						<h1 class="title single-title"><?php the_title(); ?></h1>
					<?php if($options['mts_headline_meta'] == '1') { ?>
                        <span class="single-postmeta"><?php _e('Posted by ','mythemeshop'); the_author_posts_link(); ?><?php _e(' in ', 'mythemeshop'); the_category(', ') ?> <?php _e(' On ','mythemeshop'); the_time('F j, Y'); ?></span>
					<?php } ?>
					</header><!--.headline_area-->
                        
						<div class="post-single-content box mark-links">
						<?php if ($options['mts_posttop_adcode'] != '') { ?>
							<div class="topad">
								<?php echo $options['mts_posttop_adcode']; ?>
							</div>
						<?php } ?>
							<?php the_content(); ?>
							<?php wp_link_pages('before=<div class="pagination2">&after=</div>'); ?>
						<?php if ($options['mts_postend_adcode'] != '') { ?>
							<div class="bottomad">
								<?php echo $options['mts_postend_adcode'];?>
							</div>
						<?php } ?> 
						<?php if($options['mts_tags'] == '1') { ?>
							<div class="tags"><?php the_tags('<span class="tagtext">Tags: </span>',', ') ?></div>
						<?php } ?>
							</div>
						</div><!--.post-content box mark-links-->
					<?php if($options['mts_author_box'] == '1') { ?>
						<div class="postauthor">
                        <h4><?php _e('About Author', 'mythemeshop'); ?></h4>
							<?php if(function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('email'), '75' );  } ?>
                            <h5><?php the_author_meta( 'nickname' ); ?></h5>
							<p><?php the_author_meta('description') ?></p>
						</div>
					<?php }?>  
					</div><!--.g post-->
					<?php comments_template( '', true ); ?>
				<?php endwhile; /* end loop */ ?>
			</div>
</article>
</div>
<?php get_footer(); ?>