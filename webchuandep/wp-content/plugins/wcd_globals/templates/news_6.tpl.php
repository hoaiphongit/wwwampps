<?php
	$row_index = 0;
?>
<div class="block-flexible-posts flexible-template-6">
	<div class="list-news">
	<?php while ( $posts->have_posts() ) : $posts->the_post(); global $post; ?>			
		<div id="post-<?php the_ID(); ?>" <?php post_class("post-item row-index-".$row_index); ?>>
			<div>
				<?php if($row_index == 0): ?>	
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
				
				<?php if($row_index == 0): ?>	
					<div class="meta"><?php wcd_globals_news_entry_meta(); ?></div>
					<div class="excerpt"><?php the_excerpt(); ?></div>				
				<?php endif; ?>
			</div>
		</div>	
	<?php $row_index = $row_index + 1; ?>
	<?php endwhile; ?>		
	</div>
</div><!-- .block-flexible-posts -->