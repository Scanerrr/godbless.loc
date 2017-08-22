<?php

if ( ! isset( $theme_options ) )
	$theme_options = get_option( 'fullscreen_options' );
global $theme_options;

// Add Max Content Width
if ( ! isset( $content_width ) ) $content_width = 950;

/**
 * Set the theme option variable for use throughout theme.
 *
 * @since fullscreen 1.0
 */
if ( ! isset( $theme_options ) )
	$theme_options = get_option( 'fullscreen_options' );
global $theme_options;

if ( ! function_exists( 'fullscreen_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since fullscreen 1.0
 */
function fullscreen_setup() {
	
	//require( get_template_directory() . '/lib/custom-header.php' );
	require( get_template_directory() . '/lib/filters.php' );
	require( get_template_directory() . '/lib/scripts.php' );
	require( get_template_directory() . '/lib/template-tags.php' );
	require( get_template_directory() . '/lib/updater.php' );
	require( get_template_directory() . '/lib/widgets.php' );

	/* Theme Options */
	require( get_template_directory() . '/lib/theme-options/config.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on fullscreen, use a find and replace
	 * to change 'fullscreen' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'fullscreen', get_template_directory() . '/lang' );

	/**
	 * Add theme support for various features
	 */
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'post-formats', array( 'aside', ) );
	add_theme_support( 'custom-background' );
	add_editor_style();

	/**
	* Set image sizes
	*/

	/* Set & create additional image sizes */
	set_post_thumbnail_size( 160, 160, true ); // 160x160 size
	add_image_size( '200x200', 200, 200, true ); // 200x200 image size
	add_image_size( '320x320', 320, 320, true ); // 320x320 image size
	add_image_size( '160x160', 160, 160, true ); // 160x160 image size
	add_image_size( '590', 590, 9999 ); // 590 image size
	add_image_size( '950', 950, 9999 ); // 950 image size

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus(
		array(
			'main-menu' => __( 'Main Menu', 'fullscreen' )
		)
	);

	$license_manager = new GPP_Updater(
		'fullscreen',      // The "slug" of the theme or plugin. This must match exactly the ZIP download slug.
		'Fullscreen',      // A pretty name for your plugin/theme. Used for settings screens.
		'fullscreen',      // The plugin/theme text domain for localization.
		$type = 'theme',   // "theme" or "plugin" depending on which you are creating.
		$plugin_file = ''  // The main file of your plugin (only needed for plugins).
						   // e.g. __FILE__ if you are creating GPP_Updater from your main plugin file.
	);

}
endif; // fullscreen_setup
add_action( 'after_setup_theme', 'fullscreen_setup' );

// Path constants
define('THEMELIB', TEMPLATEPATH . '/lib');


// Load Post Images
require_once (THEMELIB . '/images.php');

// Get Video
include(THEMELIB . '/video-embed/video-post.php');

// Filter Comments
include(THEMELIB . '/comments-filter.php');


// Produces an avatar image with the hCard-compliant photo class for author info
include(THEMELIB . '/author-info-avatar.php'); 


// Remove the WordPress Generator 
function gpp_remove_generators() { return ''; }  
add_filter('the_generator','gpp_remove_generators');