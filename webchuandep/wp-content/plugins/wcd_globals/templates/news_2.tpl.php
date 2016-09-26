<?php
	$row_index = 0;
?>
<style type="text/css" media="screen">
	.flexible-template-2{}	
	.flexible-template-2 .other-news:nth-child(2n+1){
		clear: both;
	}	
</style>
<div class="block-flexible-posts flexible-template-2">
	<div class="row">
	<?php while ( $posts->have_posts() ) : $posts->the_post(); global $post; ?>	
		<?php $pclass = ($row_index <= 1) ? "featured-news" : "other-news"; ?>
		<div class="col-md-6 <?php print $pclass; ?>"> 
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
					
					<div class="meta"><?php wcd_globals_news_entry_meta(); ?></div>
					
					<?php if($row_index <= 1): ?>
					<div class="excerpt"><?php the_excerpt(); ?></div>				
					<?php endif; ?>
				</div>
			</div>	
		</div>	
	<?php $row_index = $row_index + 1; ?>
	<?php endwhile; ?>		
	</div>
</div><!-- .block-flexible-posts -->