<?php

/**
 * Enqueue scripts and styles
 * @since 1.0
 */

function  fullscreen_scripts() {

    global $post, $theme_options;

    wp_enqueue_style( 'style', get_stylesheet_uri() );

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'jquery-ui-dialog' );
	wp_enqueue_script( 'fullscreen_scripts', get_template_directory_uri() .'/js/fullscreen.js', array( 'jquery', 'mousewheel' ), '1.0' );
	
	if ( ! empty( $theme_options['font'] ) || ! empty( $theme_options['font_alt'] ) ) {
        $protocol = is_ssl() ? 'https' : 'http';

        $fonts = fullscreen_font_array();

        // Font from our DB
        $header = explode( ':', $theme_options['font'] );
        $header_name = $header[0];

        if ( ! empty( $header[1] ) ){
            $header_params = ':'.$header[1];
        } else {
            $header_params = null;
        }

        $body = explode( ':', $theme_options['font_alt'] );
        $body_name = $body[0];

        if ( ! empty( $body[1] ) ){
            $body_params = ':'.$body[1];
        } else {
            $body_params = null;
        }

        $final_fonts = $header_name . $header_params . '|' . $body_name . $body_params;

        wp_enqueue_style( 'fullscreen-google-fonts', "$protocol://fonts.googleapis.com/css?family={$final_fonts}" );
    }
	

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    if ( is_singular() && wp_attachment_is_image( $post->ID ) ) {
        wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
    }

    wp_enqueue_script('superfish', get_template_directory_uri() .'/js/nav/superfish.js', array( 'jquery' ) );
    wp_enqueue_script('bgi-frame', get_template_directory_uri() .'/js/nav/jquery.bgiframe.min.js', array( 'jquery' ) );
    wp_enqueue_script('nav', get_template_directory_uri() .'/js/nav/hoverintent.js', array( 'jquery' ) );
    wp_enqueue_script('supersubs', get_template_directory_uri() .'/js/nav/supersubs.js', array( 'jquery' ) );
	
	//if ( is_home() ) {
		wp_enqueue_script('mousewheel', get_template_directory_uri() . '/js/jquery.mousewheel.js', array('jquery'));
    	//wp_enqueue_script('fullscreen', get_template_directory_uri() .'/js/fullscreen.js', array('jquery'));  
	//}
	
}
add_action( 'wp_enqueue_scripts', 'fullscreen_scripts' );