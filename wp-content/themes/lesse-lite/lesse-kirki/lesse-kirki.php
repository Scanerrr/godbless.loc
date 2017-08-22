<?php
/**
 *
 * GitHub Plugin URI: aristath/lessekirki
 * GitHub Plugin URI: https://github.com/aristath/kirki
 *
 *
 * @package     Lesse_Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// No need to proceed if Lesse_Kirki already exists
if ( class_exists( 'Lesse_Kirki' ) ) {
	return;
}

// Include the autoloader
include_once( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'autoloader.php' );

// Gets an instance of the main Lesse_Kirki object.
if ( ! function_exists( 'Lesse_Kirki' ) ) {
	function Lesse_Kirki() {
		$lessekirki = Lesse_Kirki_Toolkit::get_instance();
		return $lessekirki;
	}
}
// Start Lesse_Kirki
global $lessekirki;
$lessekirki = Lesse_Kirki();

// Make sure the path is properly set
Lesse_Kirki::$path = wp_normalize_path( dirname( __FILE__ ) );

// Instantiate 2ndary classes
new Lesse_Kirki_l10n();
new Lesse_Kirki_Scripts_Registry();
new Lesse_Kirki_Styles_Customizer();
new Lesse_Kirki_Styles_Frontend();
new Lesse_Kirki_Selective_Refresh();
new Lesse_Kirki();

// Include deprecated functions & methods
include_once wp_normalize_path( dirname( __FILE__ ) . '/includes/deprecated.php' );

// Include the ariColor library
include_once wp_normalize_path( dirname( __FILE__ ) . '/includes/lib/class-aricolor.php' );

// Add an empty config for global fields
Lesse_Kirki::add_config( '' );
