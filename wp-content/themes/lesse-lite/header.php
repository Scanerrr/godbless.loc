<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Lesse Lite
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed lesse-loading site <?php lesse_page_classes(); ?>">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'lesse-lite' ); ?></a>

	<?php do_action( 'lesse_before_header' ); ?>

	<header id="masthead" class="site-header" role="banner">
		<div class="row">
			<div class="site-branding large-5 medium-5 small-5 column">
				<?php lesse_site_branding(); ?>
			</div><!-- .site-branding -->
			<nav id="site-navigation" class="lesse-main-navigation loading clearfix large-7 medium-7 small-7 column" role="navigation">
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' , 'depth' => 3 ) ); ?>
			</nav><!-- #site-navigation -->
		</div>
	</header><!-- #masthead -->

	<?php get_template_part( 'template-parts/banner' ); ?>

	<?php do_action( 'lesse_after_header' ); ?>

	<div id="content" class="site-content <?php lesse_content_classes(); ?>">
