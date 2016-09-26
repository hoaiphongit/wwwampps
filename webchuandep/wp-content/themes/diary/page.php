<?php get_header(); ?>
<?php $options = get_option('diary'); ?>
<div class="single">
	<div class="content">
		<article class="article">
			<div id="content_box" >
				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
					<div id="post-<?php the_ID(); ?>" <?php post_class('g post'); ?>>
                    <div class="single_post">
					<header>
						<h1 class="title single-title"><?php the_title(); ?></h1>
					</header><!--.headline_area-->
						<div class="post-single-content box mark-links">
							<?php the_content(); ?>
							<?php wp_link_pages('before=<div class="pagination2">&after=</div>'); ?>
						<?php if($options['mts_tags'] == '1') { ?>
							<div class="tags"><?php the_tags('<span class="tagtext">Tags: </span>',', ') ?></div>
						<?php } ?>
							</div>
						</div><!--.post-content box mark-links-->
					</div><!--.g post-->
					<?php comments_template( '', true ); ?>
				<?php endwhile; /* end loop */ ?>
			</div>
</article>
</div>
<?php get_footer(); ?>