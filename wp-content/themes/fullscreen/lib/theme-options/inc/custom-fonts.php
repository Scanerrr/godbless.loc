<?php
/**
 * Google Font Integration
 * @package fullscreen
 * @since fullscreen 1.0
 * @author Thad Allender
 */

// Recommended Google Fonts
function fullscreen_font_array() {
    $fonts = array(
        'Allan' => array(
            'parameter' => '400,700',
            'font-family' => 'cursive'
        ),
        'Allerta' => array(
            'parameter' => '',
            'font-family' => 'sans-serif'
        ),
        'Anton' => array(
            'parameter' => '',
            'font-family' => 'sans-serif'
        ),
        'Arvo' => array(
            'parameter' => '400,700',
            'font-family' => 'serif'
        ),
        'Bevan' => array(
            'parameter' => '',
            'font-family' => 'cursive'
        ),
        'Bitter' => array(
            'parameter' => '400,700,400italic',
            'font-family' => 'serif'
        ),
        'Cabin' => array(
            'parameter' => '400,700,400italic',
            'font-family' => 'sans-serif'
        ),
        'Cardo' => array(
            'parameter' => '400,400italic,700',
            'font-family' => 'serif'
        ),
        'Crimson Text' => array(
            'parameter' => '400,400italic,700',
            'font-family' => 'serif'
        ),
        'Dancing Script' => array(
            'parameter' => '400,700',
            'font-family' => 'cursive'
        ),
        'Droid Serif' => array(
            'parameter' => '400,700,400italic,700italic',
            'font-family' => 'serif'
        ),
        'Goudy Bookletter 1911' => array(
            'parameter' => '',
            'font-family' => 'serif'
        ),
        'Junge' => array(
            'parameter' => '',
            'font-family' => 'serif'
        ),
        'Josefin Sans' => array(
            'parameter' => '100,300,400,700,400italic',
            'font-family' => 'sans-serif'
        ),
        'Lekton' => array(
            'parameter' => '400,700,400italic',
            'font-family' => 'sans-serif'
        ),
        'Molengo' => array(
            'parameter' => '',
            'font-family' => 'sans-serif'
        ),
        'Lora' => array(
            'parameter' => '400,700,400italic',
            'font-family' => 'serif'
        ),
        'Lobster' => array(
            'parameter' => '',
            'font-family' => 'cursive'
        ),
        'News Cycle' => array(
            'parameter' => '400,700',
            'font-family' => 'sans-serif'
            ),
        'Open Sans' => array(
            'parameter' => '400italic,400,300,700,800',
            'font-family' => 'sans-serif'
        ),
        'Oswald' => array(
            'parameter' => '400,300,700italic',
            'font-family' => 'sans-serif'
        ),
        'PT Sans' => array(
            'parameter' => '400,700,400italic',
            'font-family' => 'sans-serif'
        ),
        'Prociono' => array(
            'parameter' => '',
            'font-family' => 'serif'
        ),
        'Raleway' => array(
            'parameter' => '400,200,300,100',
            'font-family' => 'sans-serif'
        ),
        'Rokkitt' => array(
            'parameter' => '400,700',
            'font-family' => 'serif'
        ),
        'Shadows Into Light Two' => array(
            'parameter' => '',
            'font-family' => 'cursive'
        )
    );

    return $fonts;
}

function fullscreen_font_array_choices(){
    $fonts = fullscreen_font_array();
    $tmp = array();

    foreach( $fonts as $font => $attributes ){
        $tmp[$font] = $font;
    }
    // 'Cabin:400,700,400italic:sans-serif'
// print_r( $tmp );
    return $tmp;
}