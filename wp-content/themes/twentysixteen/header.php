<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png" type="image/png">
    <?php if (is_singular() && pings_open(get_queried_object())) : ?>
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php endif; ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
    <div class="site-inner">
        <a class="skip-link screen-reader-text" href="#content"><?php _e('Skip to content', 'twentysixteen'); ?></a>
        <header id="masthead" class="site-header" role="banner">

            <div class="site-header-main">


                <div class="games-site-branding">

                    <div class="games-top-header">
                        <div class="site-branding">
                            <div class="unfreeze-logo">

                                <!--<img src="<?php echo get_template_directory_uri(); ?>/logo.png" /> -->
                            </div>
                            <?php twentysixteen_the_custom_logo(); ?>

                            <?php if (is_front_page() && is_home()) : ?>
                                <h1 class="site-title"><?php bloginfo('name'); ?></h1>
                            <?php else : ?>
                                <p class="site-title"><?php bloginfo('name'); ?></p>
                            <?php endif;


                            $description = get_bloginfo('description', 'display');
                            if ($description || is_customize_preview()) : ?>
                                <p class="site-description"> <?php echo $description; ?></p>
                            <?php endif; ?>
                            </a>
                        </div>
                        <!-- .site-branding -->


                    <?php
                    if (has_nav_menu('primary') || has_nav_menu('social')) : ?>
                        <button id="menu-toggle" class="menu-toggle"><?php _e('Menu', 'twentysixteen'); ?></button>

                        <div id="site-header-menu" class="site-header-menu">

                            <?php if (has_nav_menu('primary')) : ?>
                                <nav id="site-navigation" class="main-navigation" role="navigation"
                                     aria-label="<?php esc_attr_e('Primary Menu', 'twentysixteen'); ?>">
                                    <?php
                                    wp_nav_menu(array(
                                        'theme_location' => 'primary',
                                        'menu_class' => 'primary-menu',
                                        'container_class' => 'primary-menu-container',
                                        'container_id' => 'primary-menu-container',
                                        'menu_id' => 'primary-menu'
                                    ));
                                    ?>
                                </nav><!-- .main-navigation -->

                            <?php endif; ?>





                        </div><!-- .site-header-menu -->
                    <?php endif;
                    ?>

                    </div>
                    <!-- .game-top-header -->

                    <!-- <div class="unfreeze-slogan"><h1>Мониторинг обменных пунктов Unfreeze</h1>
                        <div class="unfreeze-details"><button><a href="/beta"> Подробнее</a></button></div>
                    </div> -->

                </div>

                    <?php echo do_shortcode('[URIS id=383]'); ?>
                

                <div class="headerslider2" style="background-color: #000000; height: 50%;">
                    <?php
                    if (is_home()) {
                        //echo do_shortcode('[sp_responsiveslider cat_id="10"  speed="1000" autoplay_interval="10000" height="220" ]');
                       // echo do_shortcode('[URIS id=383]');

                    }
                       else  {
                           //echo do_shortcode('[sp_responsiveslider cat_id="10"  speed="1000" autoplay_interval="10000" height="220" ]');
                          // echo do_shortcode('[URIS id=383]');
                       }
                    ?>
                </div>

            </div>
            <!-- .site-header-main -->

            <?php if (get_header_image()) : ?>
                <?php
                /**
                 * Filter the default twentysixteen custom header sizes attribute.
                 *
                 * @since Twenty Sixteen 1.0
                 *
                 * @param string $custom_header_sizes sizes attribute
                 * for Custom Header. Default '(max-width: 709px) 85vw,
                 * (max-width: 909px) 81vw, (max-width: 1362px) 88vw, 1200px'.
                 */
                $custom_header_sizes = apply_filters('twentysixteen_custom_header_sizes', '(max-width: 709px) 85vw, (max-width: 909px) 81vw, (max-width: 1362px) 88vw, 1200px');
                ?>
                <div class="header-image">
                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                        <img src="<?php header_image(); ?>"
                             srcset="<?php echo esc_attr(wp_get_attachment_image_srcset(get_custom_header()->attachment_id)); ?>"
                             sizes="<?php echo esc_attr($custom_header_sizes); ?>"
                             width="<?php echo esc_attr(get_custom_header()->width); ?>"
                             height="<?php echo esc_attr(get_custom_header()->height); ?>"
                             alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>">
                    </a>
                </div><!-- .header-image -->
            <?php endif; // End header image check. ?>
        </header>

        <!-- .site-header -->

        <div id="content" class="site-content">

            <div class="games-nav-branding">
                <div id="site-games-list-menu" class="site-games-menu-list">
                    <?php

                    if (has_nav_menu('games_list')) : ?>
                        <nav id="site-games-navigation-list" class="games-navigation-list" role="navigation"
                             aria-label="Главное меню игр (список)">
                            <div id="toggle_menu_to_list" class=" " >
                                <button><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></button>
                            </div>
                            <?php
                            wp_nav_menu(array(
                                'theme_location' => 'games_list',
                                'menu_class' => 'games-menu-list',
                                'container_class' => 'games-menu-list-container',
                                'container_id' => 'games-menu-list-container',
                                'menu_id' => 'games-menu-list'
                            ));

                            ?>
                        </nav><!-- .main-navigation -->
                    <?php endif;

                    ?>
                </div>

                <div id="site-games-menu" class="site-games-menu">
                    <?php if (has_nav_menu('games')) : ?>
                        <nav id="site-games-navigation" class="games-navigation" role="navigation"
                             aria-label="Главное меню игр (алфавит)">
                            <div id="toggle_menu_to_alphabet" class=" " >
                                <button><i class="fa fa-list-ul" aria-hidden="true"></i></button>
                            </div>
                            <?php
                            wp_nav_menu(array(
                                'theme_location' => 'games',
                                'menu_class' => 'games-menu',
                                'container_class' => 'games-menu-container',
                                'container_id' => 'games-menu-container',
                                'menu_id' => 'games-menu'
                            ));

                            ?>
                        </nav><!-- .main-navigation -->
                    <?php endif; ?>
                </div>


            </div>
