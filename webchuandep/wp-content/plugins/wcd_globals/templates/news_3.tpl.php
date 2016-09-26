<?php
	$row_index = 0;
?>
<div class="block-flexible-posts flexible-template-3">
	<div class="row grid-news">
	<?php while ( $posts->have_posts() ) : $posts->the_post(); global $post; ?>			
		<div class="col-md-4"> 
			<div id="post-<?php the_ID(); ?>" <?php post_class("post-item row-index-".$row_index); ?>>
				<div>
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
					<?php the_title( sprintf( '<h3 class="title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>			
				</div>
			</div>	
		</div>	
	<?php $row_index = $row_index + 1; ?>
	<?php endwhile; ?>		
	</div>
</div><!-- .block-flexible-posts -->