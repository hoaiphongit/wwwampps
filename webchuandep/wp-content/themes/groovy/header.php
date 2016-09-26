<!DOCTYPE html>
<?php $options = get_option('groovy'); ?>
<html class="no-js" lang="en" dir="ltr">

<head>
	<meta charset="UTF-8">
	
	<title><?php wp_title(''); ?></title>

	<?php if ($options['mts_favicon'] != '') { ?>
	<link rel="icon" href="<?php echo $options['mts_favicon']; ?>" type="image/x-icon" />
	<?php } ?>
	
	<!--iOS/android/handheld specific -->	
	<link rel="apple-touch-icon" href="apple-touch-icon.png">			
	<meta name="viewport" content="width=device-width, initial-scale=1.0">						
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">

	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

	<?php wp_head(); ?>
	<link href="http://fonts.googleapis.com/css?family=Signika:400,600,700,300" rel="stylesheet" type="text/css">

	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php wp_enqueue_script("jquery"); ?>
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<script src="<?php echo get_template_directory_uri(); ?>/js/modernizr.min.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/customscript.js" type="text/javascript"></script>
	
<style type="text/css">
	<?php if ($options['mts_logo'] != '') { ?>
		#header h1, #header h2 {
		text-indent: -999em;
		min-width:188px;
		}
		#header h1 a, #header h2 a{
		background: url(<?php echo $options['mts_logo']; ?>) no-repeat;
		min-width: 188px;
		display: block;
		min-height: 70px;
		line-height: 70px;
		}
	<?php } ?>
	body {
	<?php if ($options['mts_bg_color'] != '') { ?>
		background-color:<?php echo $options['mts_bg_color']; ?>;
	<?php } ?>
	}
	<?php if ($options['mts_color_scheme'] != '') { ?>
	.mts-subscribe input[type="submit"] {
	background-color:<?php echo $options['mts_color_scheme']; ?>;
	}
	#header, .post.excerpt, #sidebars .widget, .footer-widgets, .tagcloud a, .related-posts, .postauthor, #commentsAdd, #tabber, .pagination, .single_post, .single_page, #comments {
	border-color:<?php echo $options['mts_color_scheme']; ?>;
	}
	.single_post a, a:hover, #logo a, .textwidget a, #commentform a, #tabber .inside li a, .copyrights a:hover, #navigation .menu-item-has-children > a:hover:after {
	color:<?php echo $options['mts_color_scheme']; ?>;
	}
	<?php } ?>
	<?php echo $options['mts_custom_css']; ?>
</style>

<?php echo $options['mts_header_code']; ?>

</head>

<?php flush(); ?>

<body id ="blog" <?php body_class('main'); ?>>

		<header class="main-header">
		<div class="container">
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
                    
			<div class="secondary-navigation">
				<nav id="navigation" >
					<?php if ( has_nav_menu( 'primary-menu' ) ) { ?>
						<?php $walker = new My_Walker; wp_nav_menu( array( 'theme_location' => 'primary-menu', 'menu_class' => 'menu', 'container' => '', 'walker' => $walker ) ); ?>
					<?php } else { ?>
						<ul class="menu">
							<?php wp_list_categories('title_li='); ?>
						</ul>
					<?php } ?>
				</nav>
			</div>              
				</div><!--#header-->
		</div><!--.container-->        
		</header>

<div class="main-container">