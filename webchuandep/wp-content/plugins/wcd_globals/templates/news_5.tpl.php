<style type="text/css" media="screen">
	
	.flexible-template-5 .featured-news .post-item .thumbnail,
	.flexible-template-5 .featured-news .post-item .thumbnail img{
		height: 220px;
	}
	.flexible-template-5 .other-news .post-item .thumbnail{
		float: none;
		width: 100%;
		height: 100px;
		margin-bottom: 10px;
	}
	.flexible-template-5 .other-news .post-item .thumbnail img{
		width: 100%;
		height: 100px;
	}
</style>
<?php
	$row_index = 0;
?>
<div class="block-flexible-posts flexible-template-5">
	<div class="row">
	<?php while ( $posts->have_posts() ) : $posts->the_post(); global $post; ?>
	<?php if($row_index == 0): ?> <div class="col-md-8 featured-news"> <?php endif; ?>
	<?php if($row_index == 1): ?> <div class="col-md-4 other-news"> <?php endif; ?>

		<div id="post-<?php the_ID(); ?>" <?php post_class("post-item row-index-" . $row_index); ?>>
			<div>
				<?php if($row_index <= 1): ?>
				<a href="<?php echo the_permalink(); ?>" class="thumbnail">
					<?php
						if ( $thumbnail == true ) {
							// If the post has a feature image, show it
							if ( has_post_thumbnail() ) {
								the_post_thumbnail( $thumbsize );
							// Else if the post has a mime type that starts with "image/" then show the image directly.
							} elseif ( 'image/' == substr( $post->post_mime_type, 0, 6 ) ) {
								echo wp_get_attachment_image( $post->ID, $thumbsize );
							}
						}
					?>
				</a>
				<?php endif; ?>

				<?php the_title( sprintf( '<h3 class="title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>				
				
				<!-- <div class="meta"><?php wcd_globals_news_entry_meta(); ?></div> -->
				
				<?php if($row_index == 0): ?>
				<div class="excerpt"><?php the_excerpt(); ?></div>				
				<?php endif; ?>
			</div>
		</div>
	<?php if($row_index == 0): ?> </div><!-- .col-md-6 .first-news --> <?php endif; ?>
	<?php $row_index = $row_index + 1; ?>
	<?php endwhile; ?>

	<?php if($row_index > 1): ?> </div><!-- .col-md-6 .other-news --> <?php endif; ?>
	
	</div>
</div><!-- .block-flexible-posts -->