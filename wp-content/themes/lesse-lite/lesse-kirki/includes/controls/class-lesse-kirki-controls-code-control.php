<?php
/**
 * Customizer Control: code.
 *
 * Creates a new custom control.
 * Custom controls accept raw HTML/JS.
 *
 * @package     Lesse_Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Lesse_Kirki_Controls_Code_Control' ) ) {

	/**
	 * Adds a "code" control, using CodeMirror.
	 */
	class Lesse_Kirki_Controls_Code_Control extends Lesse_Kirki_Customize_Control {

		/**
		 * The control type.
		 *
		 * @access public
		 * @var string
		 */
		public $type = 'lessekirki-code';

		/**
		 * Refresh the parameters passed to the JavaScript via JSON.
		 *
		 * @access public
		 */
		public function to_json() {
			if ( ! isset( $this->choices['language'] ) ) {
				$this->choices['language'] = 'css';
			}
			if ( ! isset( $this->choices['theme'] ) ) {
				$this->choices['theme'] = 'monokai';
			}
			parent::to_json();
		}

		/**
		 * Enqueue control related scripts/styles.
		 *
		 * @access public
		 */
		public function enqueue() {

			wp_enqueue_script( 'lessekirki-code' );

			$theme_file = '/codemirror/theme/' . $this->choices['theme'] . '.css';
			wp_enqueue_script( 'lessekirki-code', trailingslashit( Lesse_Kirki::$url ) . 'assets/js/controls/code.js', array( 'jquery', 'codemirror' ), false );

			// If we're using html mode, we'll also need to include the multiplex addon
			// as well as dependencies for XML, JS, CSS languages.
			if ( in_array( $this->choices['language'], array( 'html', 'htmlmixed' ) ) ) {
				wp_enqueue_script( 'codemirror-multiplex', trailingslashit( Lesse_Kirki::$url ) . 'codemirror/addon/mode/multiplex.js', array( 'jquery', 'codemirror' ) );
				wp_enqueue_script( 'codemirror-language-xml', trailingslashit( Lesse_Kirki::$url ) . 'codemirror/mode/xml/xml.js', array( 'jquery', 'codemirror' ) );
				wp_enqueue_script( 'codemirror-language-javascript', trailingslashit( Lesse_Kirki::$url ) . 'codemirror/mode/javascript/javascript.js', array( 'jquery', 'codemirror' ) );
				wp_enqueue_script( 'codemirror-language-css', trailingslashit( Lesse_Kirki::$url ) . 'codemirror/mode/css/css.js', array( 'jquery', 'codemirror' ) );
				wp_enqueue_script( 'codemirror-language-htmlmixed', trailingslashit( Lesse_Kirki::$url ) . 'codemirror/mode/htmlmixed/htmlmixed.js', array( 'jquery', 'codemirror', 'codemirror-multiplex', 'codemirror-language-xml', 'codemirror-language-javascript', 'codemirror-language-css' ) );
			} elseif ( 'php' === $this->choices['language'] ) {
				wp_enqueue_script( 'codemirror-language-xml', trailingslashit( Lesse_Kirki::$url ) . 'codemirror/mode/xml/xml.js', array( 'jquery', 'codemirror' ) );
				wp_enqueue_script( 'codemirror-language-php', trailingslashit( Lesse_Kirki::$url ) . 'codemirror/mode/php/php.js', array( 'jquery', 'codemirror' ) );
			} else {
				// Add language script.
				wp_enqueue_script( 'codemirror-language-' . $this->choices['language'], trailingslashit( Lesse_Kirki::$url ) . 'codemirror/mode/' . $this->choices['language'] . '/' . $this->choices['language'] . '.js', array( 'jquery', 'codemirror' ) );
			}

			// Add theme styles.
			wp_enqueue_style( 'codemirror-theme-' . $this->choices['theme'], trailingslashit( Lesse_Kirki::$url ) . 'codemirror/theme/' . $this->choices['theme'] . '.css' );

		}

		/**
		 * An Underscore (JS) template for this control's content (but not its container).
		 *
		 * Class variables for this control class are available in the `data` JS object;
		 * export custom variables by overriding {@see Lesse_Kirki_Customize_Control::to_json()}.
		 *
		 * @see WP_Customize_Control::print_template()
		 *
		 * @access protected
		 */
		protected function content_template() {
			?>
			<# if ( data.tooltip ) { #>
				<a href="#" class="tooltip hint--left" data-hint="{{ data.tooltip }}"><span class='dashicons dashicons-info'></span></a>
			<# } #>
			<label>
				<# if ( data.label ) { #>
					<span class="customize-control-title">{{{ data.label }}}</span>
				<# } #>
				<# if ( data.description ) { #>
					<span class="description customize-control-description">{{{ data.description }}}</span>
				<# } #>
				<a href="#" class="button edit button-primary">{{ data.choices.label }}</a>
				<textarea class="lessekirki-codemirror-editor collapsed">{{{ data.value }}}</textarea>
				<a href="#" class="close">
					<span class="dashicons dashicons-no"></span>
					<span class="screen-reader-text">{{ data.l10n['close-editor'] }}</span>
				</a>
			</label>
			<?php
		}
	}
}
