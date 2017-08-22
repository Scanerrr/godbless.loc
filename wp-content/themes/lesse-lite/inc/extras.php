<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Lesse Lite
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function lesse_body_classes( $classes ) {
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
	if ( $is_lynx ) {
		$classes[] = 'lynx';
	} elseif ( $is_gecko ) {
		$classes[] = 'gecko';
	} elseif ( $is_opera ) {
		$classes[] = 'opera';
	} elseif ( $is_NS4 ) {
		$classes[] = 'ns4';
	} elseif ( $is_safari ) {
		$classes[] = 'safari';
	} elseif ( $is_chrome ) {
		$classes[] = 'chrome';
	} elseif ( $is_IE ) {
		$classes[] = 'ie';
		if ( isset( $_SERVER['HTTP_USER_AGENT'] ) && preg_match( '/MSIE ([0-9]+)([a-zA-Z0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $browser_version ) ) {
			$classes[] = 'ie' . $browser_version[1];
		}
	} else {
		$classes[] = 'unknown';
	}
	if ( $is_iphone ) {
		$classes[] = 'iphone';
	}

	if ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Mobile' ) !== false ) {
		$classes[] = 'mobile';
	}

	if ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Android' ) !== false ) {
		$classes[] = 'android';
	}

	if ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Opera Mini' ) !== false ) {
		$classes[] = 'opera-mini';
	}

	if ( strpos( $_SERVER['HTTP_USER_AGENT'], 'BlackBerry' ) !== false ) {
		$classes[] = 'blackberry';
	}

	if ( isset( $_SERVER['HTTP_USER_AGENT'] ) && stristr( $_SERVER['HTTP_USER_AGENT'], 'mac' ) ) {
		$classes[] = 'osx';
	} elseif ( isset( $_SERVER['HTTP_USER_AGENT'] ) && stristr( $_SERVER['HTTP_USER_AGENT'], 'linux' ) ) {
		$classes[] = 'linux';
	} elseif ( isset( $_SERVER['HTTP_USER_AGENT'] ) && stristr( $_SERVER['HTTP_USER_AGENT'], 'windows' ) ) {
		$classes[] = 'windows';
	}
	if ( ! is_multi_author() ) {
		$classes[] = 'lesse-lite-single-author';
	}
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}
	if ( get_header_image() ) {
		$classes[] = 'header-image';
	} else {
		$classes[] = 'masthead-fixed';
	}
	if ( is_archive() || is_search() || is_home() ) {
		$classes[] = 'lesse-lite-list-view';
	}
	if ( is_singular() && ! is_front_page() ) {
		$classes[] = 'singular';
	}

	return $classes;
}

add_filter( 'body_class', 'lesse_body_classes' );

/**
 * Adds no js class in html
 */
function lesse_javascript_detection_class( $output ) {
	return $output . ' class="no-js"';
}

add_filter( 'language_attributes', 'lesse_javascript_detection_class' );

/**
 * Adds no js script
 */
function lesse_javascript_detection() {
	if ( has_filter( 'language_attributes', 'lesse_javascript_detection_class' ) ) {
		echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
	}
}

add_action( 'wp_head', 'lesse_javascript_detection', 0 );

if ( ! function_exists( 'lesse_banner_title' ) ) {
	/**
	 * Decides the tile of the banner
	 *
	 * @param  int $queried_obj_id object id of the current page
	 *
	 * @return string  banner title of the page.
	 */
	function lesse_banner_title( $queried_obj_id ) {

		if ( is_archive() ) {
			$object = get_queried_object();

			if ( is_author() ) {
				return esc_html__( "Posts by: ", "lesse-lite" ) . get_the_author();
			} elseif ( is_object( $object ) && $object->name ) {
				return $object->name;
			} else {
				return esc_html__( 'Archive', 'lesse-lite' );
			}
		} elseif ( is_404() ) {
			return esc_html__( '404 Page', 'lesse-lite' );
		} elseif ( is_search() ) {
			return esc_html__( 'Search Results', 'lesse-lite' );
		} else {
			return get_the_title( $queried_obj_id );
		}
	}
}


if ( ! function_exists( 'lesse_readmore_text' ) ) {
	/**
	 * Changes the read more text
	 */
	function lesse_readmore_text() {
		global $post;

		return sprintf( ' <a class="moretag" href="%s">%s</a>', get_permalink( $post->ID ), esc_html__( 'Read More..', 'lesse-lite' ) );
	}
}

add_filter( 'excerpt_more', 'lesse_readmore_text' );

function lesse_load_extras() {
	$file = LESSE_DIR . '/pro/pro-functions.php';

	if ( file_exists( $file ) ) {
		require_once $file;
	}
}
add_action( 'lesse_end', 'lesse_load_extras' );

//Notice
function lesse_admin_notice() {

	global $current_user ;

	$user_id = $current_user->ID;
	
	if ( isset( $_GET[ 'lesse_pro_nag_ignore' ] ) ) {
	    update_user_meta( $user_id, 'lesse_pro_nag_ignore', 1 );
	} else if ( ! get_user_meta( $user_id, 'lesse_pro_nag_ignore') && ! LESSE_PRO ) {
		echo '<div class="updated"><p>';
		printf( __('Checkout how <b>Lesse Pro</b> looks like. Click <a target="_blank" href="http://supernovathemes.com/lesse-pro-pricing/">here</a> to know more. | <a href="%1$s">Hide</a>', 'lesse-lite'), '?lesse_pro_nag_ignore=0');
		echo "</p></div>";
	}
}

add_action('admin_notices', 'lesse_admin_notice');