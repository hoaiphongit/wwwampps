<style type="text/css" media="screen">
	.header-template-1{}
	.header-template-1 .post-item{}
	.header-template-1 .post-item.featured-post{}
	.header-template-1 .post-item.featured-post .thumbnail{
		display: block;
	}
	.header-template-1 .post-item.featured-post .thumbnail img{
		width: 100%;
	}
	.header-template-1 .post-item.featured-post .title{}
</style>

<?php
	$row_index = 0;
	$open_tag = false;
?>
<div class="block-header-posts header-template-1">
	<div class="row">
	<?php while ( $posts->have_posts() ) : $posts->the_post(); global $post; ?>			
		<?php
			switch ($row_index) {
				case 0:
					$thumbnail = true;
					print '<div class="col-md-8">';
					break;
				case 1:					
					$thumbnail = false;
					print '</div><div class="col-md-4">';
					break;
				case 10:					
					$thumbnail = true;
					print '</div><div class="col-md-12"><div class="row">';
					break;
				
				default:
					# code...
					break;
			}

			$pclass = "post-item row-index-".$row_index;
			if($row_index==0){
				$pclass .= " featured-post";
			}
			else if($row_index < 10){
				$pclass .= " list-item-post";
			}
			else{
				$pclass .= " grid-item-post col-md-3";
			}
		?>

		<div id="post-<?php the_ID(); ?>" <?php post_class($pclass); ?>>
			<div>
				<?php if($thumbnail == true): ?>	
				<a href="<?php echo the_permalink(); ?>" class="thumbnail">
					<?php						
						// If the post has a feature image, show it
						if ( has_post_thumbnail() ) {
							the_post_thumbnail( $thumbsize );
						// Else if the post has a mime type that starts with "image/" then show the image directly.
						} elseif ( 'image/' == substr( $post->post_mime_type, 0, 6 ) ) {
							echo wp_get_attachment_image( $post->ID, $thumbsize );
						}						
					?>
				</a>
				<?php endif; ?>
				
				<?php the_title( sprintf( '<h3 class="title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>			
								
			</div>
		</div>	
	<?php $row_index = $row_index + 1; ?>
	<?php endwhile; ?>		
	</div></div></div>
</div><!-- .block-flexible-posts -->