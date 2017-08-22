<?php
/**
 * Contains custom functions used for the theme
 *
 * @package Lesse Lite
 */


if ( ! function_exists( 'lesse_primary_classes' ) ) {
	/**
	 * Adds Foundation classes to #primary section of all templates
	 *
	 * @return string classes
	 */
	function lesse_primary_classes( $more_classes = false, $override_foundation_classes = false ) {
		$sidebar_position = get_theme_mod( 'lesse_sidebar_position' );

		$foundation_classes = $override_foundation_classes ? $override_foundation_classes : 'large-8 medium-8 small-12 column';

		if ( 'left' === $sidebar_position ) {
			$foundation_classes .= ' lesse-lite-right';
		} else if ( 'no_sidebar' === $sidebar_position ) {
			$foundation_classes = 'large-12 medium-12 small-12 column';
		}

		// If user selects the page/post to be displayed full width from post editor screen.
		if ( is_single() || is_page() ) {
			$show_full_width = apply_filters( 'lesse_show_full_width_page', false );
			if ( $show_full_width ) {
				$foundation_classes = 'large-12 medium-12 small-12 column';
			}
		}

		echo apply_filters( 'lesse_primary_classes', "lesse-primary {$foundation_classes} {$more_classes} clearfix", $more_classes, $foundation_classes );
	}
}

if ( ! function_exists( 'lesse_secondary_classes' ) ) {
	/**
	 * Adds Foundation classes to #primary seciton of all templates
	 *
	 * @return string classes
	 */
	function lesse_secondary_classes( $more_classes = false, $override_foundation_classes = false ) {
		//Override will be useful in page-templates
		$sidebar_position   = get_theme_mod( 'lesse_sidebar_position' );
		$foundation_classes = $override_foundation_classes ? $override_foundation_classes : 'large-4 medium-4 small-12 column';
		$foundation_classes .= $sidebar_position == 'left' ? ' lesse-lite-left' : false;

		echo apply_filters( 'lesse_secondary_classes', "lesse-lite-secondary widget-area {$foundation_classes} {$more_classes} clearfix", $more_classes, $foundation_classes );
	}
}

if ( ! function_exists( 'lesse_main_font_url' ) ) {
	/**
	 * Returns the main font url of the theme, we are returning it from a function to handle two things
	 * one is to handle the http problems and the other is so that we can also load it to post editor.
	 *
	 * @return string font url
	 */
	function lesse_main_font_url() {
		/**
		 * Use font url without http://, we do this because google font without https have
		 * problem loading on websites with https.
		 * @var $font_url
		 * <link href='https://fonts.googleapis.com/css?family=Bitter:400,700' rel='stylesheet' type='text/css'>
		 */
		$font_url = 'fonts.googleapis.com/css?family=Bitter:400,700';

		return ( substr( site_url(), 0, 8 ) == 'https://' ) ? 'https://' . $font_url : 'http://' . $font_url;
	}
}

if ( ! function_exists( 'lesse_copyright_text' ) ) {
	/**
	 * Get the copy right text, is wrapped in a function because it is used
	 * at multiple places.
	 *
	 * @return {string} copyright text.
	 */
	function lesse_copyright_text() {
		$copyright_text = get_theme_mod( 'lesse_copyright_text' );

		return $copyright_text;
	}
}

if ( ! function_exists( 'lesse_site_branding' ) ) {
	/**
	 * Generate site logo, title and tagline
	 *
	 * @return void
	 */
	function lesse_site_branding() {
		$site_title   = get_bloginfo( 'name' );
		$hide_tagline = get_theme_mod( 'lesse_hide_tagline' );
		$hide_title   = get_theme_mod( 'lesse_hide_title' );
		$title_class  = $hide_title ? ' screen-reader-text' : '';
		$desc_class   = $hide_tagline ? ' screen-reader-text' : '';
		$desc_class .= $hide_title ? ' lesse-desc-no-bar' : '';

		if ( function_exists( 'has_custom_logo' ) && has_custom_logo() ) {
			the_custom_logo();
		}

		if ( is_front_page() ) { ?>
			<h1 class="site-title<?php echo esc_attr( $title_class ); ?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<?php echo esc_html( $site_title ); ?>
				</a>
			</h1>
		<?php } else { ?>
			<h2 class="site-title<?php echo esc_attr( $title_class ); ?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<?php echo esc_html( $site_title ); ?>
				</a>
			</h2>
		<?php } ?>

		<p class="site-description<?php echo esc_attr( $desc_class ); ?>"><?php bloginfo( 'description' ); ?></p>

		<?php
	}
}

if ( ! function_exists( 'lesse_pagination' ) ) {
	/**
	 * Generate lesse pagination
	 */
	function lesse_pagination() {
		if ( ! paginate_links() ) {
			return;
		}

		echo "<nav class='lesse-lite-pagination clearfix' >";
		do_action( 'lesse_before_pagination' );
		echo paginate_links();
		echo "</nav>";
	}
}

if ( ! function_exists( 'lesse_thumbnail' ) ) {
	/**
	 * Creates custom thumbnail for the theme.
	 * If thumbnail is not found, we can find the first attachment.
	 */
	function lesse_thumbnail( $size = 'thumbnail', $before = false, $after = false, $show_attachment = false ) {

		$is_individual_post          = is_single() || is_page();
		$show_full_content           = get_theme_mod( 'lesse_content_or_excerpt', 'excerpt' ) === 'full' ? true : false;
		$is_listing_and_full_content = ! $is_individual_post && 'excerpt' !== $show_full_content;

		$can_show_thumbnail = (
			is_home()
			||
			is_archive()
			||
			is_search()
			||
			lesse_is_full_slider_page()
		);

		if ( $can_show_thumbnail ) {

			$size = $size ? $size : 'thumbnail';

			$extra_classes = "";

			// If it is not listing.
			if ( $is_individual_post ) {
				$extra_classes .= 'lesse-lite-single-page-featured';
			} else { // if its listing.
				$size = get_theme_mod( 'lesse_list_thumbnail_width', $size );
				if ( $show_full_content ) {
					return;
				}
			}

			$attr = array( 'class' => "attachment-{$size} lesse-lite-featured-image {$extra_classes}" );

			if ( has_post_thumbnail() ) {
				echo $before;
					the_post_thumbnail( $size, $attr );
				echo $after;
			} else {
				if ( ! $is_listing_and_full_content ) {
					$attachments = get_children( array(
							'post_parent'    => get_the_ID(),
							'post_status'    => 'inherit',
							'post_type'      => 'attachment',
							'post_mime_type' => 'image',
							'order'          => 'ASC',
							'orderby'        => 'menu_order ID',
							'numberposts'    => 1,
						)
					);

					if ( ! empty( $attachments ) ) {
						if ( $show_attachment || ! $is_individual_post ) {
							foreach ( $attachments as $thumb_id => $attachment ) {
								echo $before;
								echo wp_get_attachment_image( $thumb_id, $size, false, $attr );
								echo $after;
							}
						}
					}
				}
			}

		}

	}
}


if ( ! function_exists( 'lesse_set_tag_cloud_sizes' ) ) {
	/**
	 * Changes the tag cloud font sizes, so it better fits with the theme.
	 *
	 * @return array $args
	 */
	function lesse_set_tag_cloud_sizes( $args ) {
		$args['smallest'] = 8;
		$args['largest']  = 8;

		return $args;
	}
}

add_filter( 'widget_tag_cloud_args', 'lesse_set_tag_cloud_sizes' );


if ( ! function_exists( 'lesse_generate_css' ) ) {
	/**
	 * This will generate a line of CSS for use in header output. If the setting
	 * ($mod_name) has no defined value, the CSS will not be output.
	 * Contains Custom functions for Customizer.
	 *
	 * @uses get_theme_mod()
	 *
	 * @param string $selector CSS selector
	 * @param string /array $style The name of the CSS *property* to modify
	 * @param string /array $mod_name The name of the 'theme_mod' option to fetch
	 * @param string /array $prefix Optional. Anything that needs to be output before the CSS property
	 * @param string /array $suffix Optional. Anything that needs to be output after the CSS property
	 *
	 * @return string Returns a single line of CSS with selectors and a property.
	 * @since Lesse Lite 1.0
	 */

	function lesse_generate_css( $args ) {
		$default_args = array(
			'selector'     => '',
			'css_property' => '',
			'mod_name'     => '',
			'prefix'       => '',
			'suffix'       => '',
			'default'      => '',
			'echo'         => true,
		);

		$args = wp_parse_args( $args, $default_args );

		$css = '';

		$selector = is_array( $args['selector'] ) ? join( ',', $args['selector'] ) : $args['selector'];

		if ( is_array( $args['css_property'] ) && is_array( $args['mod_name'] ) ) {
			$css .= $selector . '{';
			foreach ( $args['css_property'] as $key => $property ) {
				$mod         = is_array( $args['default'] ) ? get_theme_mod( $args['mod_name'][ $key ], $args['default'][ $key ] ) : get_theme_mod( $args['mod_name'][ $key ], $args['default'] );
				$this_prefix = is_array( $args['prefix'] ) ? $args['prefix'][ $key ] : $args['prefix'];

				$this_prefix = $this_prefix === '#' && strpos( $mod, '#' ) !== false ? '' : $this_prefix;

				$this_suffix = is_array( $args['suffix'] ) ? $args['suffix'][ $key ] : $args['suffix'];
				$css .= ( isset( $mod ) && ! empty( $mod ) ) ?
					sprintf( '%s:%s;', esc_attr( $property ), esc_attr( $this_prefix . $mod . $this_suffix ) ) :
					false;
			}
			$css .= "}";
		} else {
			$mod    = get_theme_mod( $args['mod_name'], $args['default'] );
			$prefix = $args['prefix'] === '#' && strpos( $mod, '#' ) !== false ? '' : $args['prefix'];
			$css    = ( isset( $mod ) && ! empty( $mod ) ) ?
				sprintf( '%s { %s:%s; }', esc_attr( $selector ), esc_attr( $args['css_property'] ), esc_attr( $prefix . $mod . $args['suffix'] ) ) :
				false;
		}

		if ( $args['echo'] ) {
			echo $css;
		} else {
			return $css;
		}

		return false;
	}
}

if ( ! function_exists( 'lesse_isset' ) ) {
	/**
	 * Used for avoiding the use of isset each time we get a value from array.
	 *
	 * @param array $array Array.
	 * @param string $key1 first key.
	 * @param string $key2 section key.
	 *
	 * @return mixed value if exists.
	 */
	function lesse_isset( $array, $key1, $key2 = false ) {
		if ( $key2 ) {
			return isset( $array[ $key1 ][ $key2 ] ) && trim( $array[ $key1 ][ $key2 ] ) ? trim( $array[ $key1 ][ $key2 ] ) : '';
		} else {
			return isset( $array[ $key1 ] ) && trim( $array[ $key1 ] ) ? trim( $array[ $key1 ] ) : '';
		}
	}
}

if ( ! function_exists( 'lesse_preview_message' ) ) {
	/**
	 * Used for showing the preview message for customizer.
	 * @todo need to use it for slider.
	 *
	 * @param string $message .
	 * @param string $auto_focus .
	 * @param string $type .
	 */
	function lesse_preview_message( $message, $auto_focus, $type = 'section' ) {
		if ( current_user_can( 'manage_options' ) && ! is_customize_preview() ) { ?>
			<div class="lesse-customizer-preview-message"
			     data-customizer-setting-link="<?php echo esc_attr( $auto_focus ); ?>">
				<?php
				$stylesheet_name    = get_stylesheet();
				$safe_customize_url = sprintf( '%s&autofocus[%s]=%s', wp_customize_url( $stylesheet_name ), esc_attr( $type ), esc_attr( $auto_focus ) );
				printf( '<a href="%s">%s</a>', $safe_customize_url, esc_html( $message ) );
				?>
			</div>
		<?php }
	}
}

if ( ! function_exists( 'lesse_content' ) ) {
	/**
	 * Show content in full length or excerpt depending upon where its called from.
	 * Is called using a function so we have more control over it from pro theme.
	 */
	function lesse_content() {
		$content_type = apply_filters( 'leese_content_type', 'full' );

		$can_show_full_content = (
			is_page()
			||
			is_single()
			||
			'full' === $content_type
		);

		if ( $can_show_full_content ) {
			the_content();
		} else {
			the_excerpt();
		}
	}
}

if ( ! function_exists( 'lesse_pro_features_template' ) ) {
	function lesse_pro_features_template() {
		ob_start();
		get_template_part( 'admin/lesse-pro-features-template' );
		$ob_render = ob_get_clean();

		return $ob_render;
	}
}
