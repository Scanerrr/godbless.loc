<?php

/**
 * Config Theme Options class
 *
 * @package fullscreen
 * @since 1.0
 */

// Require the main plugin class
if( ! class_exists( 'GPPThemeOptions' ) ) {
	require_once( dirname( __FILE__ ) . '/inc/class-theme-options.php' );
}

// Call new class
$theme_options = new GPPThemeOptions;

// True for section tabs, false for no tabs
$theme_options->tabbed = true;

// Sections
$theme_options->sections[ 'default' ] = __( 'General', 'fullscreen' );

// Options
$theme_options->settings[ 'logo' ] = array(
			'section' => 'default',
			'title'   => __( 'Logo', 'fullscreen' ),
			'desc'    => __( 'Upload a logo in PNG or JPG format.', 'fullscreen' ),
			'type'    => 'upload',
			'std'     => ''
		);

$theme_options->settings[ 'favicon' ] = array(
			'section' => 'default',
			'title'   => __( 'Favicon', 'fullscreen' ),
			'desc'    => __( 'Upload a favicon in PNG format sized to 16px by 16px.', 'fullscreen' ),
			'type'    => 'upload',
			'std'     => ''
		);

$theme_options->settings['font'] = array(
			'section' => 'default',
			'title'   => __( 'Headline Font', 'fullscreen' ),
			'desc'    => __( '<a href="' . get_option('siteurl') . '/wp-admin/admin-ajax.php?action=fonts&font=header&height=600&width=640" class="thickbox">Choose a font</a>.', 'fullscreen' ),
			'type'    => 'select',
			'std'     => 'Oswald',
			'choices' => fullscreen_font_array_choices()
		);

$theme_options->settings['font_alt'] = array(
			'section' => 'default',
			'title'   => __( 'Body Font', 'fullscreen' ),
			'desc'    => __( '<a href="' . get_option('siteurl') . '/wp-admin/admin-ajax.php?action=fonts&font=body&height=600&width=640" class="thickbox">Choose a font</a>.', 'fullscreen' ),
			'type'    => 'select',
			'std'     => 'Cardo',
			'choices' => fullscreen_font_array_choices()
		);

$theme_options->settings[ 'slider_category' ] = array(
			'section' => 'default',
			'title'   => __( 'Slider Category', 'fullscreen' ),
			'desc'    => __( 'Select category to pull images from', 'fullscreen' ),
			'std'     => '',
			'type'    => 'select',
			'choices' => $theme_options->getCategories(),
		);
			
$theme_options->settings[ 'slider_posts' ] = array(
			'section' => 'default',
			'title'   => __( 'Slider Number of Posts', 'fullscreen' ),
			'desc'    => __( 'Set the number of posts appearing in the top row', 'fullscreen' ),
			'type'    => 'select',
			'std'     => '5',
			'choices' => array(
				'5' => '5',
				'6' => '6',
				'7' => '7',
				'8' => '8',
				'9' => '9',
				'10' => '10'
				)
		);
			
$theme_options->settings[ 'css' ] = array(
			'section' => 'default',
			'title'   => __( 'Custom CSS', 'fullscreen' ),
			'desc'    => __( 'Add some custom CSS to quickly change the design of your site.', 'fullscreen' ),
			'type'    => 'textarea',
			'std'     => 'my standard stuff'
		);

			

/**
 * Set theme options above to global theme settings
 * @since fullscreen 1.0
 */
global $gpp_settings;
$gpp_settings = $theme_options->settings;


/**
 * Items that need to be ran during "theme activation".
 * @since fullscreen 1.0
 */
add_action( 'load-themes.php', 'gpp_theme_activation' );

function gpp_theme_activation() {

	global $pagenow, $gpp_settings;

	$gpp_theme = new GPPThemeOptions;

	$new_version = $gpp_theme->theme[ 'version' ]; // activating theme version
	$version_var = 'fullscreen_version';
	$version = get_option( $version_var ); // already existing theme version

	update_option( $version_var, $new_version );

	//If the theme option is not already set, then initialize the settings.
	if ( ! get_option( 'fullscreen_options' ) ) {
		$gpp_theme->initializeSettings( $gpp_settings );
	}
}

/**
 * Integrates with the Theme Customizer in WP 3.4
 * @since fullscreen 1.0
 */
add_action( 'customize_register', 'gpp_customize_register' );

function gpp_customize_register( $wp_customize ) {

	// extending the field type to textarea
	class gpp_CSS_Control extends WP_Customize_Control {
		public $type = 'customarea';

		public function render_content() {
			$theme_options = get_option( 'fullscreen_options' );
			$stored = "";
			if( isset( $theme_options[ 'css' ] ) ) { $stored = $theme_options[ 'css' ]; }
			echo '<textarea style="width:100%;height:200px;">' . $stored . '</textarea>';
		}
		public function enqueue() {
			wp_enqueue_script( 'customarea', get_template_directory_uri() . '/lib/theme-options/js/customarea.js', array( 'customize-controls' ), '20120607', true );
		}
	}

	// get our theme options so we can use defaults below
	$theme_options = get_option( 'fullscreen_options' );

	// enables live change support
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	// add a setting to an existing theme option
	$wp_customize->add_setting( 'fullscreen_options[logo]', array(
		'default'        => '',
		'type'           => 'option',
		'capability'     => 'edit_theme_options',
		'transport'      => 'postMessage'
	) );

	// intercept the theme option and control it
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo', array(
		'label'      => __( 'Upload Logo', 'fullscreen' ),
		'section'    => 'title_tagline',
		'settings'   => 'fullscreen_options[logo]'
	) ) );

	// add customizer section
	$wp_customize->add_section( 'fullscreen_fonts', array(
		'title'			=> __( 'Fonts', 'fullscreen' ),
		'priority'		=> 45
	) );

	// add a setting to an existing theme option
	$wp_customize->add_setting( 'fullscreen_options[font]', array(
	'default'        => '',
	'type'           => 'option',
	'capability'     => 'edit_theme_options',
	'transport'      => 'postMessage'
	) );

	// intercept the theme option and control it
	$wp_customize->add_control( 'fullscreen_font_customizer', array(
	'settings'		=> 'fullscreen_options[font]',
	'label'			=> __( 'Headline Font', 'fullscreen' ),
	'section'		=> 'fullscreen_fonts',
	'type'			=> 'select',
	'choices'		=> fullscreen_font_array_choices() // don't call all fonts on public themes. Choose a few.
	) );

	// add a setting to an existing theme option
	$wp_customize->add_setting( 'fullscreen_options[font_alt]', array(
	'default'        => '',
	'type'           => 'option',
	'capability'     => 'edit_theme_options',
	'transport'      => 'postMessage'
	) );

	// intercept the theme option and control it
	$wp_customize->add_control( 'fullscreen_font_alt_customizer', array(
	'settings'		=> 'fullscreen_options[font_alt]',
	'label'			=> __( 'Body Font', 'fullscreen' ),
	'section'		=> 'fullscreen_fonts',
	'type'			=> 'select',
	'choices'		=> fullscreen_font_array_choices() // don't call all fonts on public themes. Choose a few.
	) );


	// add customizer section
	$wp_customize->add_section( 'fullscreen_css', array(
		'title'			=> __( 'Custom CSS', 'fullscreen' ),
		'priority'		=> 60
	) );

	// add a setting to an existing theme option
	$wp_customize->add_setting( 'fullscreen_options[css]', array(
		'default'        => '',
		'type'           => 'option',
		'capability'     => 'edit_theme_options',
		'transport'      => 'postMessage'
	) );

	// intercept the theme option and control it
	$wp_customize->add_control( new gpp_CSS_Control( $wp_customize, 'css', array(
		'settings'		=> 'fullscreen_options[css]',
		'label'			=> __( 'Custom CSS', 'fullscreen' ),
		'section'		=> 'fullscreen_css'
	) ) );


	/**
	 * Bind JS handlers to make Theme Customizer preview reload changes asynchronously.
	 * Used with fonts
	 *
	 * @since fullscreen 1.0
	 */
	function gpp_customize_preview_js() { ?>
		<?php
		$doc_ready_script = '
		<script type="text/javascript">
			(function($){
				$(document).ready( function() {

					wp.customize( "blogname", function( value ) {
						value.bind( function( to ) {
							$( ".site-title a" ).html( to );
						} );
					} );

					wp.customize( "blogdescription", function( value ) {
						value.bind( function( to ) {
							$( ".description" ).html( to );
						} );
					} );

					wp.customize( "header_textcolor", function( value ) {
						value.bind( function( to ) {
							$( ".site-title a, .site-description" ).css( "cssText", "color: " + to + " !important;" );
						} );
					} );


					wp.customize( "fullscreen_options[logo]", function( value ) {
						value.bind( function( to ) {
							$( ".site-title a" ).html( "<img class=\"sitetitle\" alt=\"' . get_bloginfo( 'name' ) . '\" src=\"" + to + "\">" );
						} );
					} );

					wp.customize("fullscreen_options[font]",function(value) {
						value.bind(function(to) {
							$("#fontdiv").remove();
							var googlefont = to.split(",");
							$("body").append("<div id=\"fontdiv\"><link href=\"http://fonts.googleapis.com/css?family="+googlefont[0]+"\" rel=\"stylesheet\" type=\"text/css\" /><style type=\"text/css\">	h1, h2, h3, h4, h5, h6 {font-family: \""+googlefont[0]+"\";}</style></div>");

						});
					});

					wp.customize("fullscreen_options[font_alt]",function(value) {
						value.bind(function(to) {
							$("#fontaltdiv").remove();
							var googlefont = to.split(",");
							$("body").append("<div id=\"fontaltdiv\"><link href=\"http://fonts.googleapis.com/css?family="+googlefont[0]+"\" rel=\"stylesheet\" type=\"text/css\" /><style type=\"text/css\">	body, p, h2.site-description {font-family: \""+googlefont[0]+"\";}</style></div>");

						});
					});

					wp.customize( "fullscreen_options[color]", function( value ) {
						value.bind( function( to ) {
							$( "#alt-style-css" ).attr( "href", "' . get_template_directory_uri() . '/css/" + to + ".css" );
						} );
					} );

					wp.customize( "fullscreen_options[css]", function( value ) {
						value.bind( function( to ) {
							$( "#tempcss" ).remove();
							var googlefont = to.split( "," );
							$( "body" ).append( "<div id=\"tempcss\"><style type=\"text/css\">" + to + "</style></div>" );
						} );
					} );
			} );
		})(jQuery);
		</script>';

		echo $doc_ready_script;
	}
	if ( $wp_customize->is_preview() && ! is_admin() )
		add_action( 'wp_footer', 'gpp_customize_preview_js', 21 );
}