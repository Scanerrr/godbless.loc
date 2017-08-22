<?php
/**
 * Internationalization helper.
 *
 * @package     Lesse_Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

if ( ! class_exists( 'Lesse_Kirki_l10n' ) ) {

	/**
	 * Handles translations
	 */
	class Lesse_Kirki_l10n {

		/**
		 * The plugin textdomain
		 *
		 * @access protected
		 * @var string
		 */
		protected $textdomain = 'lessekirki';

		/**
		 * The class constructor.
		 * Adds actions & filters to handle the rest of the methods.
		 *
		 * @access public
		 */
		public function __construct() {

			add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );

		}

		/**
		 * Load the plugin textdomain
		 *
		 * @access public
		 */
		public function load_textdomain() {

			if ( null !== $this->get_path() ) {
				load_textdomain( $this->textdomain, $this->get_path() );
			}
			load_plugin_textdomain( $this->textdomain, false, Lesse_Kirki::$path . '/languages' );

		}

		/**
		 * Gets the path to a translation file.
		 *
		 * @access protected
		 * @return string Absolute path to the translation file.
		 */
		protected function get_path() {
			$path_found = false;
			$found_path = null;
			foreach ( $this->get_paths() as $path ) {
				if ( $path_found ) {
					continue;
				}
				$path = wp_normalize_path( $path );
				if ( file_exists( $path ) ) {
					$path_found = true;
					$found_path = $path;
				}
			}

			return $found_path;

		}

		/**
		 * Returns an array of paths where translation files may be located.
		 *
		 * @access protected
		 * @return array
		 */
		protected function get_paths() {

			return array(
				WP_LANG_DIR . '/' . $this->textdomain . '-' . get_locale() . '.mo',
				Lesse_Kirki::$path . '/languages/' . $this->textdomain . '-' . get_locale() . '.mo',
			);

		}

		/**
		 * Shortcut method to get the translation strings
		 *
		 * @static
		 * @access public
		 * @param string $config_id The config ID. See Lesse_Kirki_Config.
		 * @return array
		 */
		public static function get_strings( $config_id = 'global' ) {

			$translation_strings = array(
				'background-color'      => esc_attr__( 'Background Color', 'lesse-lite' ),
				'background-image'      => esc_attr__( 'Background Image', 'lesse-lite' ),
				'no-repeat'             => esc_attr__( 'No Repeat', 'lesse-lite' ),
				'repeat-all'            => esc_attr__( 'Repeat All', 'lesse-lite' ),
				'repeat-x'              => esc_attr__( 'Repeat Horizontally', 'lesse-lite' ),
				'repeat-y'              => esc_attr__( 'Repeat Vertically', 'lesse-lite' ),
				'inherit'               => esc_attr__( 'Inherit', 'lesse-lite' ),
				'background-repeat'     => esc_attr__( 'Background Repeat', 'lesse-lite' ),
				'cover'                 => esc_attr__( 'Cover', 'lesse-lite' ),
				'contain'               => esc_attr__( 'Contain', 'lesse-lite' ),
				'background-size'       => esc_attr__( 'Background Size', 'lesse-lite' ),
				'fixed'                 => esc_attr__( 'Fixed', 'lesse-lite' ),
				'scroll'                => esc_attr__( 'Scroll', 'lesse-lite' ),
				'background-attachment' => esc_attr__( 'Background Attachment', 'lesse-lite' ),
				'left-top'              => esc_attr__( 'Left Top', 'lesse-lite' ),
				'left-center'           => esc_attr__( 'Left Center', 'lesse-lite' ),
				'left-bottom'           => esc_attr__( 'Left Bottom', 'lesse-lite' ),
				'right-top'             => esc_attr__( 'Right Top', 'lesse-lite' ),
				'right-center'          => esc_attr__( 'Right Center', 'lesse-lite' ),
				'right-bottom'          => esc_attr__( 'Right Bottom', 'lesse-lite' ),
				'center-top'            => esc_attr__( 'Center Top', 'lesse-lite' ),
				'center-center'         => esc_attr__( 'Center Center', 'lesse-lite' ),
				'center-bottom'         => esc_attr__( 'Center Bottom', 'lesse-lite' ),
				'background-position'   => esc_attr__( 'Background Position', 'lesse-lite' ),
				'background-opacity'    => esc_attr__( 'Background Opacity', 'lesse-lite' ),
				'on'                    => esc_attr__( 'ON', 'lesse-lite' ),
				'off'                   => esc_attr__( 'OFF', 'lesse-lite' ),
				'all'                   => esc_attr__( 'All', 'lesse-lite' ),
				'cyrillic'              => esc_attr__( 'Cyrillic', 'lesse-lite' ),
				'cyrillic-ext'          => esc_attr__( 'Cyrillic Extended', 'lesse-lite' ),
				'devanagari'            => esc_attr__( 'Devanagari', 'lesse-lite' ),
				'greek'                 => esc_attr__( 'Greek', 'lesse-lite' ),
				'greek-ext'             => esc_attr__( 'Greek Extended', 'lesse-lite' ),
				'khmer'                 => esc_attr__( 'Khmer', 'lesse-lite' ),
				'latin'                 => esc_attr__( 'Latin', 'lesse-lite' ),
				'latin-ext'             => esc_attr__( 'Latin Extended', 'lesse-lite' ),
				'vietnamese'            => esc_attr__( 'Vietnamese', 'lesse-lite' ),
				'hebrew'                => esc_attr__( 'Hebrew', 'lesse-lite' ),
				'arabic'                => esc_attr__( 'Arabic', 'lesse-lite' ),
				'bengali'               => esc_attr__( 'Bengali', 'lesse-lite' ),
				'gujarati'              => esc_attr__( 'Gujarati', 'lesse-lite' ),
				'tamil'                 => esc_attr__( 'Tamil', 'lesse-lite' ),
				'telugu'                => esc_attr__( 'Telugu', 'lesse-lite' ),
				'thai'                  => esc_attr__( 'Thai', 'lesse-lite' ),
				'serif'                 => _x( 'Serif', 'font style', 'lesse-lite' ),
				'sans-serif'            => _x( 'Sans Serif', 'font style', 'lesse-lite' ),
				'monospace'             => _x( 'Monospace', 'font style', 'lesse-lite' ),
				'font-family'           => esc_attr__( 'Font Family', 'lesse-lite' ),
				'font-size'             => esc_attr__( 'Font Size', 'lesse-lite' ),
				'font-weight'           => esc_attr__( 'Font Weight', 'lesse-lite' ),
				'line-height'           => esc_attr__( 'Line Height', 'lesse-lite' ),
				'font-style'            => esc_attr__( 'Font Style', 'lesse-lite' ),
				'letter-spacing'        => esc_attr__( 'Letter Spacing', 'lesse-lite' ),
				'top'                   => esc_attr__( 'Top', 'lesse-lite' ),
				'bottom'                => esc_attr__( 'Bottom', 'lesse-lite' ),
				'left'                  => esc_attr__( 'Left', 'lesse-lite' ),
				'right'                 => esc_attr__( 'Right', 'lesse-lite' ),
				'center'                => esc_attr__( 'Center', 'lesse-lite' ),
				'justify'               => esc_attr__( 'Justify', 'lesse-lite' ),
				'color'                 => esc_attr__( 'Color', 'lesse-lite' ),
				'add-image'             => esc_attr__( 'Add Image', 'lesse-lite' ),
				'change-image'          => esc_attr__( 'Change Image', 'lesse-lite' ),
				'no-image-selected'     => esc_attr__( 'No Image Selected', 'lesse-lite' ),
				'add-file'              => esc_attr__( 'Add File', 'lesse-lite' ),
				'change-file'           => esc_attr__( 'Change File', 'lesse-lite' ),
				'no-file-selected'      => esc_attr__( 'No File Selected', 'lesse-lite' ),
				'remove'                => esc_attr__( 'Remove', 'lesse-lite' ),
				'select-font-family'    => esc_attr__( 'Select a font-family', 'lesse-lite' ),
				'variant'               => esc_attr__( 'Variant', 'lesse-lite' ),
				'subsets'               => esc_attr__( 'Subset', 'lesse-lite' ),
				'size'                  => esc_attr__( 'Size', 'lesse-lite' ),
				'height'                => esc_attr__( 'Height', 'lesse-lite' ),
				'spacing'               => esc_attr__( 'Spacing', 'lesse-lite' ),
				'ultra-light'           => esc_attr__( 'Ultra-Light 100', 'lesse-lite' ),
				'ultra-light-italic'    => esc_attr__( 'Ultra-Light 100 Italic', 'lesse-lite' ),
				'light'                 => esc_attr__( 'Light 200', 'lesse-lite' ),
				'light-italic'          => esc_attr__( 'Light 200 Italic', 'lesse-lite' ),
				'book'                  => esc_attr__( 'Book 300', 'lesse-lite' ),
				'book-italic'           => esc_attr__( 'Book 300 Italic', 'lesse-lite' ),
				'regular'               => esc_attr__( 'Normal 400', 'lesse-lite' ),
				'italic'                => esc_attr__( 'Normal 400 Italic', 'lesse-lite' ),
				'medium'                => esc_attr__( 'Medium 500', 'lesse-lite' ),
				'medium-italic'         => esc_attr__( 'Medium 500 Italic', 'lesse-lite' ),
				'semi-bold'             => esc_attr__( 'Semi-Bold 600', 'lesse-lite' ),
				'semi-bold-italic'      => esc_attr__( 'Semi-Bold 600 Italic', 'lesse-lite' ),
				'bold'                  => esc_attr__( 'Bold 700', 'lesse-lite' ),
				'bold-italic'           => esc_attr__( 'Bold 700 Italic', 'lesse-lite' ),
				'extra-bold'            => esc_attr__( 'Extra-Bold 800', 'lesse-lite' ),
				'extra-bold-italic'     => esc_attr__( 'Extra-Bold 800 Italic', 'lesse-lite' ),
				'ultra-bold'            => esc_attr__( 'Ultra-Bold 900', 'lesse-lite' ),
				'ultra-bold-italic'     => esc_attr__( 'Ultra-Bold 900 Italic', 'lesse-lite' ),
				'invalid-value'         => esc_attr__( 'Invalid Value', 'lesse-lite' ),
				'add-new'           	=> esc_attr__( 'Add new', 'lesse-lite' ),
				'row'           		=> esc_attr__( 'row', 'lesse-lite' ),
				'limit-rows'            => esc_attr__( 'Limit: %s rows', 'lesse-lite' ),
				'open-section'          => esc_attr__( 'Press return or enter to open this section', 'lesse-lite' ),
				'back'                  => esc_attr__( 'Back', 'lesse-lite' ),
				'reset-with-icon'       => sprintf( esc_attr__( '%s Reset', 'lesse-lite' ), '<span class="dashicons dashicons-image-rotate"></span>' ),
				'text-align'            => esc_attr__( 'Text Align', 'lesse-lite' ),
				'text-transform'        => esc_attr__( 'Text Transform', 'lesse-lite' ),
				'none'                  => esc_attr__( 'None', 'lesse-lite' ),
				'capitalize'            => esc_attr__( 'Capitalize', 'lesse-lite' ),
				'uppercase'             => esc_attr__( 'Uppercase', 'lesse-lite' ),
				'lowercase'             => esc_attr__( 'Lowercase', 'lesse-lite' ),
				'initial'               => esc_attr__( 'Initial', 'lesse-lite' ),
				'select-page'           => esc_attr__( 'Select a Page', 'lesse-lite' ),
				'open-editor'           => esc_attr__( 'Open Editor', 'lesse-lite' ),
				'close-editor'          => esc_attr__( 'Close Editor', 'lesse-lite' ),
				'switch-editor'         => esc_attr__( 'Switch Editor', 'lesse-lite' ),
				'hex-value'             => esc_attr__( 'Hex Value', 'lesse-lite' ),
			);

			// Apply global changes from the lessekirki/config filter.
			// This is generally to be avoided.
			// It is ONLY provided here for backwards-compatibility reasons.
			// Please use the lessekirki/{$config_id}/l10n filter instead.
			$config = apply_filters( 'lessekirki/config', array() );
			if ( isset( $config['i18n'] ) ) {
				$translation_strings = wp_parse_args( $config['i18n'], $translation_strings );
			}

			// Apply l10n changes using the lessekirki/{$config_id}/l10n filter.
			return apply_filters( 'lessekirki/' . $config_id . '/l10n', $translation_strings );

		}
	}
}
