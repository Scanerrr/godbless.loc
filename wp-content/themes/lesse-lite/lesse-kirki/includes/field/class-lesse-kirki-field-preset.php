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

if ( ! class_exists( 'Lesse_Kirki_Field_Preset' ) ) {

	/**
	 * Field overrides.
	 */
	class Lesse_Kirki_Field_Preset extends Lesse_Kirki_Field_Select {

		/**
		 * Sets the control type.
		 *
		 * @access protected
		 */
		protected function set_type() {

			$this->type = 'lessekirki-preset';

		}

		/**
		 * Sets the $multiple
		 *
		 * @access protected
		 */
		protected function set_multiple() {

			$this->multiple = '1';

		}
	}
}
