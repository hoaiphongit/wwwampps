<!DOCTYPE html>
<?php $options = get_option('diary'); ?>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<title><?php wp_title(''); ?></title>
	<?php mts_meta(); ?>
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_enqueue_script("jquery"); ?>
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?php mts_head(); ?>
	<?php wp_head(); ?>
</head>

<?php flush(); ?>

<body id ="blog" <?php body_class('main'); ?>>

<div class="main-container">
	<div class="container">
		<header class="main-header">
			<div id="header">
				<?php if( is_front_page() || is_home() || is_404() ) { ?>
						<h1 id="logo">
							<a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a>
						</h1><!-- END #logo -->
				<?php } else { ?>
						<h2 id="logo">
							<a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a>
						</h2><!-- END #logo -->
				<?php } ?>  
              
			</div><!--#header-->
	</header>