<?php
/**
 * Contains functions for full slider
 *
 * @package Lesse Lite
 */

if ( ! function_exists( 'lesse_get_default_slide' ) ) {
	/**
	 * Gives the random default image url.
	 *
	 * @return string image.
	 */
	function lesse_get_default_slide( $key = false ) {
		$default_slides = array(
			'coral.jpg',
			'green.jpg',
			'red.jpg',
			'yellow.jpg',
		);

		if ( $key ) {
			if ( isset( $default_slides[ $key ] ) ) {
				$default_slide = $default_slides[ $key ];
			} else {
				shuffle( $default_slides );
				$default_slide = $default_slides[0];
			}
		} else {
			shuffle( $default_slides );
			$default_slide = $default_slides[0];
		}

		return LESSE_IMG_URI . '/' . $default_slide;
	}
}

if ( ! function_exists( 'lesse_generate_slide_content' ) ) {
	/**
	 * Generate the title of the slide.
	 *
	 * @param string $title
	 * @param string $description
	 *
	 * @return string markup.
	 */
	function lesse_generate_slide_content( $title, $description, $permalink ) {

		if ( trim( $title ) || trim( $description ) ) {
			$escaped_content = '<div class="lesse-slide-content">';
			$escaped_content .= '<div class="row-container">';
			if ( trim( $title ) ) {
				$escaped_content .= sprintf( '<h2 class="lesse-slide-title" ><a href="%s">%s</a></h2>', esc_url( $permalink ), esc_html( $title ) );
			}
			if ( trim( $description ) ) {
				$escaped_content .= sprintf( '<p class="lesse-slide-description"><a href="%s">%s</a></p>', esc_url( $permalink ), esc_html( $description ) );
			}
			$escaped_content .= '</div>';
			$escaped_content .= '</div>';

			return $escaped_content;
		} else {
			return false;
		}
	}
}

if ( ! function_exists( 'lesse_get_latest_post_ids' ) ) {
	/**
	 * Gets latest post slides.
	 *
	 * @return {array} post ids.
	 */
	function lesse_get_latest_post_ids() {

		$post_ids = array();

		$args = array(
			'posts_per_page'         => 3,
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'fields'                 => 'ids',
			'post_type'              => 'post',
			'orderby'                => 'post_date',
			'order'                  => 'DESC',
			'post_status'            => 'publish',
		);

		$query = new WP_Query( $args );

		if ( $query->have_posts() ) {
			$post_ids = $query->posts;
		}

		wp_reset_postdata();

		return $post_ids;

	}
}

if ( ! function_exists( 'lesse_post_slides' ) ) {
	/**
	 * Create slides array for the home page slides.
	 *
	 * @return array $safe_slides
	 */
	function lesse_post_slides() {
		$show_default_slides = 1;
		$slides = get_theme_mod( 'lesse_post_slides', $show_default_slides );

		$post_ids = array();
		$safe_slides = array();

		if ( is_array( $slides ) && ! empty( $slides ) ) {
			foreach ( (array) $slides as $key => $slide ) {
				if ( lesse_isset( $slide, 'post_id' ) ) {
					array_push( $post_ids, lesse_isset( $slide, 'post_id' ) );
				}
			}
		} else {
			if ( 1 === $slides ) {
				$post_ids = lesse_get_latest_post_ids();
			}
		}

		if ( ! empty( $post_ids ) ) {

			$slide_query = new WP_Query( apply_filters( 'lesse_post_slide_query_args', array(
				'posts_per_page'         => 20,
				'no_found_rows'          => true,
				'update_post_meta_cache' => false,
				'update_post_term_cache' => false,
				'post_type'              => array( 'post', 'page' ),
				'post__in'               => $post_ids,
				'orderby'                => 'post__in',
				'ignore_sticky_posts'    => true,
				'post_status'            => 'publish',
			) ) );

			$count = 0;
			if ( $slide_query->have_posts() ) : while ( $slide_query->have_posts() ) : $slide_query->the_post();

				$description = wp_html_excerpt( get_the_excerpt(), 120, '…' );
				$image_url   = get_the_post_thumbnail_url( get_the_ID(), 'full' );
				$image_url   = $image_url ? $image_url : lesse_get_default_slide( $count );

				$current_slide = array(
					'image' => esc_url( $image_url ),
					'title' => lesse_generate_slide_content( get_the_title(), esc_html( $description ), get_permalink() ),
					'url'   => get_the_permalink(),
				);

				array_push( $safe_slides, $current_slide );

			$count++;

			endwhile; endif;

			wp_reset_postdata();
		}

		return $safe_slides;
	}
}

if ( ! function_exists( 'lesse_is_full_slider_page' ) ) {
	/**
	 * Checks if its a full slider page or not
	 *
	 * @return boolean
	 */
	function lesse_is_full_slider_page() {
		return is_home() || is_page_template( 'pro/home.php' );
	}
}

if ( ! function_exists( 'lesse_has_full_page_slider' ) ) {
	/**
	 * Checks to see if its a slider page.
	 *
	 * @return boolean
	 */
	function lesse_has_full_page_slider() {
		$is_slider_page = false;

		if ( is_home() ) {
			$post_slides = lesse_post_slides();
			if ( ! empty( $post_slides ) ) {
				$is_slider_page = true;
			}
		} else if ( is_page_template( 'pro/home.php' ) ) {
			if ( function_exists( 'lesse_home_page_template_slides' ) ) {
				$home_page_template_slides = lesse_home_page_template_slides();
				if ( ! empty( $home_page_template_slides ) ) {
					$is_slider_page = true;
				}
			}
		}

		return $is_slider_page;
	}
}

if ( ! function_exists( 'lesse_page_classes' ) ) {
	/**
	 * Is applied to div#page in header.php
	 */
	function lesse_page_classes() {
		$classes = lesse_has_full_page_slider() ? 'lesse-full-slider-page' : '';
		echo apply_filters( 'lesse_page_classes', $classes );
	}
}

if ( ! function_exists( 'lesse_content_classes' ) ) {
	/**
	 * Is applied to div#content in header.php
	 */
	function lesse_content_classes() {
		$classes = is_page_template( 'pro/home.php' ) ? 'clearfix' : 'row';
		echo apply_filters( 'lesse_content_classes', $classes );
	}
}

/**
 * Adds post sliders in header.
 */
function lesse_add_post_slider() {
	if ( ! lesse_has_full_page_slider() ) {
		return false;
	}
	if ( is_home() ) {
		get_template_part( 'template-parts/post-slider' );
	} else if ( is_page_template( 'pro/home.php' ) ) {
		get_template_part( 'pro/template-parts/slider' );
	}
}
add_action( 'lesse_before_header', 'lesse_add_post_slider' );
