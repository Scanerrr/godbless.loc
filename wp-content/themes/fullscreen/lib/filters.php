<?php

/**
 * Extends the body_class function for improved css targeting
 * @package fullscreen
 * @since fullscreen 1.0
 */

/**
 * Filters the body_class and adds the css class
 */
function fullscreen_browser_class( $classes ) {
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
		// Browser detection
		if( $is_lynx ) $classes[] = 'browser-lynx';
		elseif( $is_gecko ) $classes[] = 'browser-gecko';
		elseif( $is_opera ) $classes[] = 'browser-opera';
		elseif( $is_NS4 ) $classes[] = 'browser-ns4';
		elseif( $is_safari ) $classes[] = 'browser-safari';
		elseif( $is_chrome ) $classes[] = 'browser-chrome';
		elseif( $is_IE ) $classes[] = 'browser-ie';
		elseif( $is_iphone ) $classes[] = 'browser-iphone';
		else $classes[] = '';
		// Check for non-multisite installs
		if ( ! is_multi_author() ) $classes[] = 'single-author';
		// Do we have a header image?
		$header_image = get_header_image();
	    if ( $header_image ) $classes[] = 'has-header-image';
	    // Is the sidebar enabled?
	    if ( is_active_sidebar( 'sidebar' ) )
	    	$classes[] = 'has-sidebar';
	    else
	    	$classes[] = 'no-sidebar';

	return $classes;
}
// Filter body_class with the function above
add_filter( 'body_class', 'fullscreen_browser_class' );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @since fullscreen 1.0
 */
function fullscreen_page_menu_args( $args ) {
	$args[ 'show_home' ] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'fullscreen_page_menu_args' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 *
 * @since fullscreen 1.0
 */
function fullscreen_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'fullscreen_enhanced_image_navigation', 10, 2 );