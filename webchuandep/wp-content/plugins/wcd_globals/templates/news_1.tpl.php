<style type="text/css" media="screen">
.flexible-template-1{}	
.flexible-template-1 .other-news{}
.flexible-template-1 .other-news .post-item{	
	clear: both;
	overflow: hidden;
	margin-bottom: 15px;
}	
.flexible-template-1 .other-news .post-item .thumbnail{
	width: 100px;
	height: 70px;
	position: relative;
	display: block;
	float: left;
	margin-right: 15px;
	overflow: hidden;
}
.flexible-template-1 .other-news .post-item .thumbnail img{
	display: block;
	float: none;
	width: auto;
	height: 70px;
	margin: 0;
	-ms-transform: translateX(-50%);
	-webkit-transform: translateX(-50%);
	transform: translateX(-50%);
	position: relative;
	left: 50%;
	max-width: none;
	min-width: 100px;
}
.flexible-template-1 .other-news .post-item .title{
	padding: 0;
    font-size: 14px;
    line-height: 20px;
    margin-bottom: 4px;
    font-weight: 500;
}
.flexible-template-1 .other-news .post-item .title a{}	
.flexible-template-1 .other-news .post-item .excerpt{
	display: none;
}	
</style>
<?php
	$row_index = 0;
?>
<div class="block-flexible-posts flexible-template-1">
	<div class="row">
	<?php while ( $posts->have_posts() ) : $posts->the_post(); global $post; ?>
	<?php if($row_index == 0): ?> <div class="col-md-6 featured-news"> <?php endif; ?>
	<?php if($row_index == 1): ?> <div class="col-md-6 other-news"> <?php endif; ?>

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