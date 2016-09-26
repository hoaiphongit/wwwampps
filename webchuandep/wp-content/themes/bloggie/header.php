<!DOCTYPE html>
<?php $options = get_option('bloggie'); ?>
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

	<?php wp_head(); ?>

	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<style type="text/css">
	<?php if ($options['mts_logo'] != '') { ?>
		#header h1, #header h2 {
		text-indent: -999em;
		min-width: 150px;
		}
		#header h1 a, #header h2 a{
		background: url(<?php echo $options['mts_logo']; ?>) no-repeat;
		min-width: 150px;
		display: block;
		min-height: 50px;
		line-height: 50px;
		}
	<?php } ?>
	body {
	<?php if ($options['mts_bg_color'] != '') { ?>
		background-color:<?php echo $options['mts_bg_color']; ?>;
		background-image: none;
	<?php } ?>
	}
	<?php if ($options['mts_color_scheme'] != '') { ?>
	.mts-subscribe input[type="submit"], #navigation > ul > li > a:hover, #navigation ul li li:hover > a, .sbutton {
	background-color:<?php echo $options['mts_color_scheme']; ?>;
	}
	a, .single_post a, #logo a, .textwidget a, #commentform a, .copyrights a:hover, .readMore a, .authorColumn a, #tabber ul.tabs li a.selected, #tabber ul.tabs li.tab-recent-posts a.selected {
	color:<?php echo $options['mts_color_scheme']; ?>;
	}
	a:hover {
	color:<?php echo $options['mts_color_scheme']; ?>!important;
	}
	<?php } ?>
	<?php echo $options['mts_custom_css']; ?>
	</style>

<?php echo $options['mts_header_code']; ?>

</head>

<?php flush(); ?>

<body id="blog" <?php body_class('main'); ?>>
			<div class="main-navigation">
				<nav id="navigation">
					<?php if ( has_nav_menu( 'primary-menu' ) ) { ?>
						<?php wp_nav_menu( array( 'theme_location' => 'primary-menu', 'menu_class' => 'menu', 'container' => '' ) ); ?>
					<?php } else { ?>
						<ul class="menu">
							<li class="home-tab home-padding"><a href="<?php echo home_url(); ?>">Home</a></li>
							<?php wp_list_pages('title_li='); ?>
						</ul>
					<?php } ?><!--#nav-primary-->
				</nav>
			</div>
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
					<?php if ( ! dynamic_sidebar( 'Header' ) ) : ?>
					<?php endif ?>
				</div><!--#header-->
				<div class="secondary-navigation">
					<nav id="navigation" >
						<?php if ( has_nav_menu( 'secondary-menu' ) ) { ?>
							<?php wp_nav_menu( array( 'theme_location' => 'secondary-menu', 'menu_class' => 'menu', 'container' => '' ) ); ?>
						<?php } else { ?>
							<ul class="menu">
								<?php wp_list_categories('title_li='); ?>
							</ul>
						<?php } ?>
					</nav>
				</div>
			</div><!--.container-->
		</header>
		<div class="main-container">
