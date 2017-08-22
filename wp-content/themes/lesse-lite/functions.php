<?php
/**
 * Lesse Lite functions and definitions
 *
 * @package Lesse Lite
 */

$lesse_theme = wp_get_theme();

if ( ! defined( 'LESSE_VERSION' ) ) {
	define( 'LESSE_VERSION', $lesse_theme->Version );
}
if ( ! defined( 'LESSE_DIR_URI' ) ) {
	define( 'LESSE_DIR_URI', get_template_directory_uri() );
}
if ( ! defined( 'LESSE_DIR' ) ) {
	define( 'LESSE_DIR', get_template_directory() );
}
if ( ! defined( 'LESSE_CSS_URI' ) ) {
	define( 'LESSE_CSS_URI', LESSE_DIR_URI . '/css' );
}
if ( ! defined( 'LESSE_JS_URI' ) ) {
	define( 'LESSE_JS_URI', LESSE_DIR_URI . '/js' );
}
if ( ! defined( 'LESSE_IMG_URI' ) ) {
	define( 'LESSE_IMG_URI', LESSE_DIR_URI . '/images' );
}
if ( ! defined( 'LESSE_IS_DEV' ) ) {
	define( 'LESSE_IS_DEV', true );
}
if ( ! defined( 'LESSE_PRO' ) ) {
	define( 'LESSE_PRO', file_exists( LESSE_DIR . '/pro/pro-functions.php' ) );
}

if ( ! function_exists( 'lesse_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function lesse_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Lesse Lite, use a find and replace
	 * to change 'lesse-lite' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'lesse-lite', LESSE_DIR . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	add_theme_support( 'custom-logo', array(
		'height' => 32,
		'width' => 150,
		'flex-height' => true,
		'flex-width' => true,
	) );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'lesse-lite' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'lesse_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	add_editor_style( array( 'editor-style.css', lesse_main_font_url() ) );
}
endif; // lesse_setup
add_action( 'after_setup_theme', 'lesse_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function lesse_content_width() {
	global $content_width;
	$content_width = apply_filters( 'lesse_content_width', 640 );
}
add_action( 'after_setup_theme', 'lesse_content_width', 0 );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function lesse_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'lesse-lite' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget widget-sidebar large-12 medium-12 column %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title widget-title-sidebar">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'lesse-lite' ),
		'id'            => 'sidebar-2',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget widget-footer small-12 medium-4 large-3 column %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title widget-title-footer">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'lesse_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function lesse_scripts()
{
	/*==============================
	          GOOGLE FONTS
	===============================*/

	wp_enqueue_style( 'google-font-opensanscondensed', lesse_main_font_url() );

	/*==============================
	          STYLES
	===============================*/

	wp_enqueue_style( 'lesse-fontello', LESSE_DIR_URI . '/lib/fontello/css/fontello.css' );
	wp_enqueue_style( 'lesse-lite-style', get_stylesheet_uri() );

	/*==============================
	          SCRIPTS
	===============================*/

	if ( LESSE_IS_DEV || ( defined( SCRIPT_DEBUG ) && SCRIPT_DEBUG ) ) {
		wp_register_script( 'sticky', LESSE_JS_URI . '/vendor/jquery.sticky.js', array( 'jquery' ), LESSE_VERSION, true );
		wp_register_script( 'flexmenu', LESSE_JS_URI . '/vendor/flexmenu.js', array( 'jquery' ), LESSE_VERSION, true );
		wp_register_script( 'supersized', LESSE_JS_URI . '/vendor/supersized.js', array( 'jquery' ), LESSE_VERSION, true );
		wp_register_script( 'supersized-shutter', LESSE_JS_URI . '/vendor/supersized.shutter.js', array( 'jquery', 'supersized'  ), LESSE_VERSION, true );

		$dependencies = array(
			'jquery',
			'sticky',
			'flexmenu',
			'supersized-shutter'
		);

		wp_register_script( 'lesse-lite-main', LESSE_JS_URI . '/main.js', $dependencies , LESSE_VERSION, true );

	} else {
		wp_register_script( 'lesse-lite-main', LESSE_JS_URI . '/lesse-lite-package.min.js', array( 'jquery' ), LESSE_VERSION, true );
	}

	// Loading imagesloaded separately for backward compatibility.
	wp_enqueue_script( 'imagesloaded' );
	wp_enqueue_script( 'lesse-lite-main' );

	wp_localize_script( 'lesse-lite-main', 'lesseVars', apply_filters( 'lesse_lite_main_vars', array(
		'slides' => lesse_post_slides()
	) ));

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'lesse_scripts' );


/*==============================
          FILE INCLUDES
===============================*/

$lesse_dependencies = apply_filters( 'lesse_dependencies', array(
	LESSE_DIR . '/inc/*.php',
	LESSE_DIR . '/admin/admin.php',
));

foreach ( $lesse_dependencies as $path ) {
	foreach ( glob( $path ) as $filename ) {
		include $filename;
	}
}

do_action( 'lesse_end' );
