<?php
/**
 * Jetpack Compatibility File
 * See: https://jetpack.me/
 * See: https://jetpack.me/support/infinite-scroll/
 * See: https://jetpack.me/support/responsive-videos/
 *
 * @package Lesse Lite
 */

/**
 * Add theme support for Infinite Scroll.
 * See: https://jetpack.me/support/infinite-scroll/
 */
function lesse_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'lesse_infinite_scroll_render',
		'footer'    => 'page',
	) );
	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );

} // end function lesse_jetpack_setup
add_action( 'after_setup_theme', 'lesse_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function lesse_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		if ( is_search() ) :
		    get_template_part( 'template-parts/content', 'search' );
		else :
		    get_template_part( 'template-parts/content', get_post_format() );
		endif;
	}
} // end function lesse_infinite_scroll_render
