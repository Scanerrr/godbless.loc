<?php

if ( ! class_exists( 'Lesse_Customizer_Settings' ) ) {

	/**
	 * Register settings for Less Customizer using Kirki
	 */
	class Lesse_Customizer_Settings {

		/**
		 * Configuration Id for lesse
		 *
		 * @var String
		 */
		public $config_id = "lesse";

		/**
		 * Lesse_Customizer_Settings constructor.
		 */
		public function __construct() {
			$this->add_config();
			$this->create_copyright_control();
			$this->show_lesse_pro_features();
			$this->create_wp_default_controls();
			$this->create_front_page_slider_section_and_controls();
		}

		/**
		 * Add the configuration.
		 * This way all the fields using the $this->config_id ID
		 * will inherit these options
		 */
		public function add_config() {
			Lesse_Kirki::add_config( $this->config_id, array(
				'capability'  => 'edit_theme_options',
				'option_type' => 'theme_mod',
			) );
		}

		public function create_copyright_control() {

			Lesse_Kirki::add_field( $this->config_id, array(
				'type'        => 'text',
				'settings'    => 'lesse_copyright_text',
				'label'       => esc_attr__( 'Copyright Text', 'lesse-lite' ),
				'description' => esc_attr__( 'Year will automatically change every year.', 'lesse-lite' ),
				'section'     => 'title_tagline',
				'default'     => '',
				'transport'   => 'postMessage',
				'priority'    => 100,
			) );
		}

		public function show_lesse_pro_features() {
			if (LESSE_PRO) {
				return false;
			}

			Lesse_Kirki::add_section('lesse_pro_features', array(
				'title' => esc_attr__("What's in Pro?", 'lesse-lite'),
				'capability' => 'edit_theme_options',
				'priority' => 80,
				'icon' => 'dashicons dashicons-lock'
			) );

			Lesse_Kirki::add_field($this->config_id, array(
				'type' => 'custom',
				'settings' => 'lesse_pro_features',
				'label' => esc_attr__('Lesse Pro Features', 'lesse-lite'),
				'section' => 'lesse_pro_features',
				'default' => lesse_pro_features_template(),
			) );

		}

		public function create_front_page_slider_section_and_controls() {

			Lesse_Kirki::add_section( 'lesse_post_slider', array(
				'title'      => esc_attr__( 'Slider Settings', 'lesse-lite' ),
				'capability' => 'edit_theme_options',
				'priority'    => 31,
			) );

			Lesse_Kirki::add_field( $this->config_id, array(
				'type'        => 'repeater',
				'settings'    => 'lesse_post_slides',
				'label'       => esc_attr__( 'Add Slides', 'lesse-lite' ),
				'description' => esc_attr__( 'Featured images, titles and contents will be used from these post/pages for the slides.', 'lesse-lite' ),
				'section'     => 'lesse_post_slider',
				'transport'   => 'refresh',
				'default'     => $this->get_default_post_slides(),
				'fields'      => array(
					'post_title' => array(
						'type'    => 'autocomplete',
						'label'   => esc_attr__( 'Start Typing Post Name', 'lesse-lite' ),
						'default' => '',
					),
					'post_id'    => array(
						'type'  => 'hidden',
						'label' => esc_attr__( 'Post Id', 'lesse-lite' ),
					),
				),
			) );
		}

		public function create_wp_default_controls() {

			Lesse_Kirki::add_field( $this->config_id, array(
				'type'      => 'checkbox',
				'settings'  => 'lesse_hide_title',
				'label'     => esc_attr__( 'Hide Title', 'lesse-lite' ),
				'section'   => 'title_tagline',
				'tooltip'   => esc_attr__( 'Only hides the title, however keeps it available for search engines.', 'lesse-lite' ),
				'default'   => false,
				'transport' => 'postMessage',
			) );

			Lesse_Kirki::add_field( $this->config_id, array(
				'type'      => 'checkbox',
				'settings'  => 'lesse_hide_tagline',
				'label'     => esc_attr__( 'Hide Tagline', 'lesse-lite' ),
				'tooltip'   => esc_attr__( 'Only hides the tag line, however keeps it available for search engines.', 'lesse-lite' ),
				'section'   => 'title_tagline',
				'default'   => false,
				'transport' => 'postMessage',
			) );

			/*==============================
						  Colors
			===============================*/

			$palettes = apply_filters( 'lesse_color_palettes', array(
				'EB4D5C' => array( '#EB4D5C' ),
				'F34235' => array( '#F34235' ),
				'E81D62' => array( '#E81D62' ),
				'9B26AF' => array( '#9B26AF' ),
				'6639B6' => array( '#6639B6' ),
				'3E50B4' => array( '#3E50B4' ),
				'2196F3' => array( '#2196F3' ),
				'02A8F3' => array( '#02A8F3' ),
				'00BBD3' => array( '#00BBD3' ),
				'B0E0E6' => array( '#B0E0E6' ),
				'009587' => array( '#009587' ),
				'4BAE4F' => array( '#4BAE4F' ),
				'8AC249' => array( '#8AC249' ),
				'CCDB38' => array( '#CCDB38' ),
				'FEEA3A' => array( '#FEEA3A' ),
				'FEC006' => array( '#FEC006' ),
				'FE9700' => array( '#FE9700' ),
				'FE5621' => array( '#FE5621' ),
				'F79F79' => array( '#F79F79' ),
				'785447' => array( '#785447' ),
				'5B5941' => array( '#5B5941' ),
				'9D9D9D' => array( '#9D9D9D' ),
				'5F7C8A' => array( '#5F7C8A' ),
				'87B6A7' => array( '#87B6A7' ),
			) );

			//Color Schemes
			Lesse_Kirki::add_field( $this->config_id, array(
				'type'        => 'palette',
				'settings'    => 'lesse_color_scheme',
				'label'       => esc_attr__( 'Theme Skin', 'lesse-lite' ),
				'description' => esc_attr__( 'Change color scheme.', 'lesse-lite' ),
				'section'     => 'colors',
				'default'     => 'EB4D5C',
				'choices'     => $palettes,
			) );
		}

		/**
		 * Gets default slides.
		 *
		 * @return {array} $default_slides.
		 */
		public function get_default_post_slides() {
			$post_ids = lesse_get_latest_post_ids();
			$default_slides = array();

			if ( ! empty( $post_ids ) ) {
			    foreach ( $post_ids as $post_id ) {
			    	array_push( $default_slides, array(
						'post_title' => get_the_title( $post_id ),
						'post_id' => intval( $post_id ),
				    ) );
			    }
			}

			return $default_slides;
		}
	}
}

if ( class_exists( 'Lesse_Kirki' ) ) {
	new Lesse_Customizer_Settings();
}