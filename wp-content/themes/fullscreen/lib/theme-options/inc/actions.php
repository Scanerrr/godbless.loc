<?php
/**
 * fullscreen Actions
 * @package fullscreen
 * @author Thad Allender
 */

/**
 * fullscreen Custom CSS
 * @since fullscreen 1.0
 */
function fullscreen_css() {

    $theme_options = get_option( 'fullscreen_options' );

    if ( isset( $theme_options[ 'css' ] ) && '' != $theme_options[ 'css' ] ) {

        echo '<style type="text/css">';
        echo sanitize_text_field( $theme_options[ 'css' ] );
        echo '</style>';

    }
}

add_action( 'wp_head', 'fullscreen_css' );

/**
 * fullscreen Google Font Integration
 * @since fullscreen 1.0
 */
/**
 * fullscreen Google Font Integration
 * @since fullscreen 1.0
 */
function fullscreen_include_font() {

    $theme_options = get_option( 'fullscreen_options' );
    $css = null;
    $font_family = null;
    $font_alt_family = null;

    if ( ! empty( $theme_options['font'] ) ) {
        $font = explode(':',$theme_options['font']);
        $font_name = str_replace('+', ' ', $font[0] );
        $font_name = "'" . $font_name . "'";
        if ( ! empty( $font[2] ) ){
            $font_family = ' ' . $font[2];
        }
        $css = 'h1, h2, h3, h4, h5, h6, #header ul.menu li a, .slide-button, .button { font-family: ' . $font_name .$font_family.'; }';
    }

    if ( ! empty( $theme_options['font_alt'] ) ) {
        $font_alt = explode(':',$theme_options['font_alt']);
        $font_alt_name = str_replace( '+', ' ', $font_alt[0] );
        $font_alt_name = "'" . $font_alt_name . "'";
        if ( ! empty( $font_alt[2] ) ){
            $font_alt_family = ' ' . $font_alt[2];
        }
        $css .= 'body, p, textarea, input, h2.site-description { font-family: ' . $font_alt_name .$font_alt_family.'; }';
    }

    print '<!-- BeginHeader --><style type="text/css">' . $css . '</style><!-- EndHeader -->';

}

add_action( 'wp_head', 'fullscreen_include_font' );

/**
 * fullscreen alternative styles
 * @since fullscreen 1.0
 */

function  fullscreen_alt_styles() {
	$theme_options = get_option( 'fullscreen_options' );
	
	if( isset ( $theme_options['color'] ) && '' != $theme_options[ 'color' ] ) {
        wp_enqueue_style( 'alt-style', get_template_directory_uri() . '/css/' . $theme_options['color'] . '.css', array( 'style' ) );
    }
}
add_action( 'wp_enqueue_scripts', 'fullscreen_alt_styles' );