<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package fullscreen
 * @since fullscreen 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged, $theme_options;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'fullscreen' ), max( $paged, $page ) );

	?></title>
<?php if ( isset( $theme_options['favicon'] ) && '' != $theme_options['favicon'] ) : ?>
	<link rel="shortcut icon" href="<?php echo esc_url( $theme_options['favicon'] ); ?>" />
<?php endif; ?>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/print.css" type="text/css" media="print" />
<!--[if IE]><link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/ie.css" type="text/css" media="screen, projection" />
<link rel="stylesheet" href="<<?php echo get_template_directory_uri(); ?>/css/ie-nav.css" type="text/css" media="screen, projection" /><![endif]-->
<?php if ( is_home() ) : ?>
<!--[if IE]><link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/no-scroll.css" type="text/css" media="screen, projection" /><![endif]-->
<?php endif; ?>

<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<!-- Begin Homepage Navigation -->
<?php if ( is_home() ) : ?>
	<div class="home">
		<div id="branding">
			<div class="brand-wrap">

				<h2 class="site-title">
					<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
						<?php if( isset( $theme_options['logo'] ) && '' != $theme_options[ 'logo' ] ) : ?>
							<img class="sitetitle" src="<?php echo esc_url( $theme_options[ 'logo' ] ); ?>" alt="<?php bloginfo( 'name' ); ?>" id="logo-image-home" />
						<?php else : ?>
							<?php bloginfo( 'name' ); ?>
						<?php endif; ?>
					</a>
				</h2>
				<div class="description"><?php bloginfo('description'); ?></div>

				<?php wp_nav_menu( array( 'theme_location' => 'main-menu', 'container_class' => 'menu-main-container', 'container_id'  => 'nav', 'menu_class' => 'sf-menu', ) ); ?>

        <div class="go-left"><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/back.gif" class="go-left" alt="back" /></a></div>
    	<div class="go-right"><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/forward.gif" class="go-right" alt="forward" /></a></div>
	    </div>
	</div>
<?php else: ?>
<!-- Begin Interior Page Navigation -->
    <div class="container">
        <!-- Begin Masthead -->
        <div id="masthead">
            <h2 class="site-title">
				<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			    	<?php if( isset( $theme_options['logo'] ) && '' != $theme_options[ 'logo' ] ) : ?>
			    	<img class="sitetitle" src="<?php echo esc_url( $theme_options[ 'logo' ] ); ?>" alt="<?php bloginfo( 'name' ); ?>" id="logo-image" />
			    	<?php else : ?>
			    		<?php bloginfo( 'name' ); ?>
			    	<?php endif; ?>
		    	</a>
		    </h2>
        <div class="description"><?php bloginfo('description'); ?></div> 
        	<?php wp_nav_menu( array( 'theme_location' => 'main-menu', 'container_class' => 'menu-main-container', 'container_id'  => 'nav', 'menu_class' => 'sf-menu', ) ); ?>
        </div>
<?php endif; ?>