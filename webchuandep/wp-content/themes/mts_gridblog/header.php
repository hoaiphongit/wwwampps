<!DOCTYPE html>
<?php $mts_options = get_option(MTS_THEME_NAME); ?>
<html class="no-js" <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
        <!--[if IE ]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <?php mts_meta(); ?>
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <?php wp_head(); ?>
    </head>
    <body id="blog" <?php body_class('main'); ?> itemscope itemtype="http://schema.org/WebPage">       
        <div class="main-container">
            <header class="main-header" id="site-header" role="banner" itemscope itemtype="http://schema.org/WPHeader">
                <?php if ($mts_options['mts_show_primary_nav'] == '1') { ?>
                    <div class="nav_wrap">
                        <div class="container">
                            <div id="search-5" class="widget widget_search">
                                <?php get_search_form(true); ?>
                            </div>
                            <div id="primary-navigation" class="primary-navigation" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
                                <nav id="navigation" class="navigation clearfix mobile-menu-wrapper">
                                   <a href="#" id="pull" class="toggle-mobile-menu"><?php _e('Menu', 'mythemeshop'); ?></a>
                                    <?php if (has_nav_menu('primary-menu')) { ?>
                                        <?php wp_nav_menu(array('theme_location' => 'primary-menu', 'menu_class' => 'menu clearfix', 'menu_id' => 'menu-primary-menu', 'container' => '', 'walker' => new mts_menu_walker)); ?>
                                    <?php } else { ?>
                                        <ul class="menu clearfix" id="menu-primary-menu">
                                            <?php wp_list_pages('title_li='); ?>
                                        </ul>
                                    <?php } ?>
                                </nav>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                
                <div id="header">
                    <div class="container">
                        <div class="logo-wrap">
                            <?php if ($mts_options['mts_logo'] != '') { ?>
                                <?php if (is_front_page() || is_home() || is_404()) { ?>
                                    <h1 id="logo" class="image-logo" itemprop="headline">
                                        <a href="<?php echo esc_url(home_url()); ?>"><img src="<?php echo esc_attr($mts_options['mts_logo']); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>"></a>
                                    </h1><!-- END #logo -->
                                <?php } else { ?>
                                    <h2 id="logo" class="image-logo" itemprop="headline">
                                        <a href="<?php echo esc_url(home_url()); ?>"><img src="<?php echo esc_attr($mts_options['mts_logo']); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>"></a>
                                    </h2><!-- END #logo -->
                                <?php } ?>
                            <?php } else { ?>
                                <?php if (is_front_page() || is_home() || is_404()) { ?>
                                    <h1 id="logo" class="text-logo" itemprop="headline">
                                        <a href="<?php echo esc_url(home_url()); ?>"><?php bloginfo('name'); ?></a>
                                    </h1><!-- END #logo -->
                                <?php } else { ?>
                                    <h2 id="logo" class="text-logo" itemprop="headline">
                                        <a href="<?php echo esc_url(home_url()); ?>"><?php bloginfo('name'); ?></a>
                                    </h2><!-- END #logo -->
                                <?php } ?>
                            <?php } ?>
                        </div>
                        <?php dynamic_sidebar('Header Ad'); ?>
                    </div><!--#header-->
                </div><!--.container-->
            </header>