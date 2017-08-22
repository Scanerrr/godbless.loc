<?php
/**
 * Handles CSS output for background-image.
 *
 * @package     Lesse_Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.2.0
 */

if ( ! class_exists( 'Lesse_Kirki_Output_Property_Background_Image' ) ) {

	/**
	 * Output overrides.
	 */
	class Lesse_Kirki_Output_Property_Background_Image extends Lesse_Kirki_Output_Property {

		/**
		 * Modifies the value.
		 *
		 * @access protected
		 */
		protected function process_value() {

			if ( false === strrpos( $this->value, 'url(' ) ) {
				if ( empty( $this->value ) ) {
					return;
				}
				$this->value = 'url("' . $this->value . '")';
			}
		}
	}
}
