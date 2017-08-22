<?php
/**
 * Lesse Lite Admin loads from here.
 * @package Lesse Lite
 */

define( 'LESSE_ADMIN_DIR', LESSE_DIR . '/admin' );
define( 'LESSE_ADMIN_URI', LESSE_DIR_URI . '/admin' );
define( 'LESSE_CUSTOMIZER_JS', LESSE_ADMIN_URI . '/js' );
define( 'LESSE_KIRKI_DIR', LESSE_DIR . '/lesse-kirki' );

/**
 * Add kirki configurations.
 */
function lesse_theme_url( $config ) {
	$config['url_path'] = get_template_directory_uri() . '/lesse-kirki/';

	return $config;
}
add_action( 'lessekirki/config', 'lesse_theme_url' );

$files_to_include = array(
	LESSE_KIRKI_DIR . '/lesse-kirki.php',
	LESSE_ADMIN_DIR . '/lesse-customizer-settings.php',
	LESSE_ADMIN_DIR . '/wp-customizer.php',
);

// Loading Files.
foreach ( $files_to_include as $file_path ) {
	if ( file_exists( $file_path ) ) {
		include_once $file_path;
	}
}
