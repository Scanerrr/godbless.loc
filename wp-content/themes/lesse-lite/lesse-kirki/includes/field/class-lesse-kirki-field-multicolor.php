<?php
/**
 * Override field methods
 *
 * @package     Lesse_Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.2.7
 */

if ( ! class_exists( 'Lesse_Kirki_Field_Multicolor' ) ) {

	/**
	 * Field overrides.
	 */
	class Lesse_Kirki_Field_Multicolor extends Lesse_Kirki_Field {

		/**
		 * Sets the control type.
		 *
		 * @access protected
		 */
		protected function set_type() {

			$this->type = 'lessekirki-multicolor';

		}

		/**
		 * Sets the $choices
		 *
		 * @access protected
		 */
		protected function set_choices() {

			// Make sure choices are defined as an array.
			if ( ! is_array( $this->choices ) ) {
				$this->choices = array();
			}

		}

		/**
		 * Sets the $sanitize_callback
		 *
		 * @access protected
		 */
		protected function set_sanitize_callback() {

			// If a custom sanitize_callback has been defined,
			// then we don't need to proceed any further.
			if ( ! empty( $this->sanitize_callback ) ) {
				return;
			}
			$this->sanitize_callback = array( $this, 'sanitize' );

		}

		/**
		 * The method that will be used as a `sanitize_callback`.
		 *
		 * @param array $value The value to be sanitized.
		 * @return array The value.
		 */
		public function sanitize( $value ) {

			return $value;

		}
	}
}
