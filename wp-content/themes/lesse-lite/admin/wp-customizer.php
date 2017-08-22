<?php
/**
 * Contains methods for customizing the theme customization screen.
 *
 * @link http://codex.wordpress.org/Theme_Customization_API
 *
 */

if ( ! class_exists( 'Lesse_Customizer' ) ) {

	class Lesse_Customizer {

		public function __construct() {
			add_action( 'customize_register', array( $this, 'register' ) );
			add_action( 'customize_preview_init', array( $this, 'live_preview' ) );
			add_action( 'wp_head', array( $this, 'custom_css' ) );
		}

		public function register( WP_Customize_Manager $wp_customize ) {

			$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
			$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
			$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
			$wp_customize->get_setting( 'custom_logo' )->transport = 'postMessage';

			$this->selective_refresh( $wp_customize );
		}

		public function live_preview() {
			wp_enqueue_script( 'lesse-themecustomizer', LESSE_CUSTOMIZER_JS . '/customizer-live-preview.js', array(
				'jquery',
				'customize-preview',
			), '1.0', true );
		}

		public function selective_refresh( $wp_customize ) {

			// Abort if selective refresh is not available.
			if ( ! isset( $wp_customize->selective_refresh ) ) {
				return;
			}

			$wp_customize->selective_refresh->add_partial( 'custom_logo', array(
				'selector'            => '.site-branding',
				'container_inclusive' => false,
				'render_callback'     => 'lesse_site_branding',
			) );

			$wp_customize->selective_refresh->add_partial( 'lesse_hide_title', array(
				'selector'            => '.site-branding',
				'container_inclusive' => false,
				'render_callback'     => 'lesse_site_branding',
			) );
			
		}

		public function custom_css() {

			echo "<style>/*** Lesse Customizer CSS ***/";

			$color_selectors = apply_filters( 'lesse_color_selectors', array(
				'a',
				'a:hover',
				'.entry-footer .edit-link',
				'.comments-area .comments-title:before',
				'.lesse-scroll-icon:hover',
				'.comment-respond .comment-notes .required',
				'.lesse-hs7-menu li .current',
				'.lesse-hs7-products .lesse-product-description span:hover',
			) );

			$background_selectors = apply_filters( 'lesse_background_selectors', array(
				'button',
				'input[type=button]',
				'input[type=reset]',
				'input[type=submit]',
				'.lesse-main-navigation .sub-menu a:hover',
				'.lesse-main-navigation .flexMenu-popup a:hover',
				'.lesse-progress-bar',
				'.lesse-lite-secondary .widget_calendar #today',
				'.lesse-lite-secondary .widget_tag_cloud a:hover',
				'.site-footer .widget_calendar #today',
				'.site-footer .widget_tag_cloud a:hover',
				'.lesse-hs1-icon-container:hover',
				'.lesse-home-section-3 button',
				'.lesse-no-banner-image',
				'.hvr-sweep-to-right:before',
				'.hvr-overline-reveal:before',
				'.hvr-sweep-to-right:before',
			) );

			$border_color_selectors = apply_filters( 'lesse_border_color_selectors', array(
				'.lesse-hs2-button:hover',
				'.hvr-bubble-float-top:before',
			) );

			$border_top_color_selectors = apply_filters( 'lesse_border_top_color_selectors', array(
				'.lesse-hs4-progress-2',
				'.lesse-hs4-progress-3',
			) );

			$border_bottom_color_selectors = apply_filters( 'lesse_border_bottom_color_selectors', array(
				'.lesse-hs4-progress-3',
			) );

			$border_right_color_selectors = apply_filters( 'lesse_border_right_color_selectors', array(
				'.lesse-hs4-progress-2',
				'.lesse-hs4-progress-3',
				'.hvr-bubble-float-left:before',
				'.hvr-bubble-float-left:before',
			) );

			$color_theme_mod_name = apply_filters( 'lesse_color_theme_mod_name', 'lesse_color_scheme' );
			$color_theme_default  = apply_filters( 'lesse_color_theme_default', 'EB4D5C' );

			// Now generate CSS

			lesse_generate_css( array(
				'selector'     => $border_color_selectors,
				'css_property' => 'border-color',
				'mod_name'     => $color_theme_mod_name,
				'prefix'       => '#',
				'default'      => $color_theme_default,
			) );

			lesse_generate_css( array(
				'selector'     => $border_top_color_selectors,
				'css_property' => 'border-top-color',
				'mod_name'     => $color_theme_mod_name,
				'prefix'       => '#',
				'default'      => $color_theme_default,
			) );

			lesse_generate_css( array(
				'selector'     => $border_bottom_color_selectors,
				'css_property' => 'border-bottom-color',
				'mod_name'     => $color_theme_mod_name,
				'prefix'       => '#',
				'default'      => $color_theme_default,
			) );

			lesse_generate_css( array(
				'selector'     => $border_right_color_selectors,
				'css_property' => 'border-right-color',
				'mod_name'     => $color_theme_mod_name,
				'prefix'       => '#',
				'default'      => $color_theme_default,
			) );

			lesse_generate_css( array(
				'selector'     => $color_selectors,
				'css_property' => 'color',
				'mod_name'     => $color_theme_mod_name,
				'prefix'       => '#',
				'default'      => $color_theme_default,
			) );

			lesse_generate_css( array(
				'selector'     => $background_selectors,
				'css_property' => 'background',
				'mod_name'     => $color_theme_mod_name,
				'prefix'       => '#',
				'default'      => $color_theme_default,
			) );

			do_action( 'lesse_custom_css' );

			echo "</style>";
		}
	}
}

if ( class_exists( 'Lesse_Customizer' ) ) {
	new Lesse_Customizer();
}
