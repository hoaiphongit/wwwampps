<?php
/**
 * Flexible Posts Widget: Default widget template
 * 
 * @since 3.4.0
 *
 * This template was added to overcome some often-requested changes
 * to the old default template (widget.php).
 */

// Block direct requests
if ( !defined('ABSPATH') )
	die('-1');

echo $before_widget;

if ( ! empty( $title ) )
	echo $before_title . $title . $after_title;

if ( $flexible_posts->have_posts() ):
	//var_dump($thumbnail);
	wcd_globals_news_template($flexible_posts, 5, $thumbnail, $thumbsize);

endif; // End have_posts()
	
echo $after_widget;