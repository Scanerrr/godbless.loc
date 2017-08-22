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

if ( ! class_exists( 'Lesse_Kirki_Field_Switch' ) ) {

	/**
	 * Field overrides.
	 */
	class Lesse_Kirki_Field_Switch extends Lesse_Kirki_Field_Checkbox {

		/**
		 * Sets the control type.
		 *
		 * @access protected
		 */
		protected function set_type() {

			$this->type = 'lessekirki-switch';

		}

		/**
		 * Sets the control choices.
		 *
		 * @access protected
		 */
		protected function set_choices() {

			if ( ! is_array( $this->choices ) ) {
				$this->choices = array();
			}

			$l10n = Lesse_Kirki_l10n::get_strings( $this->lessekirki_config );

			if ( ! isset( $this->choices['on'] ) ) {
				$this->choices['on'] = $l10n['on'];
			}

			if ( ! isset( $this->choices['off'] ) ) {
				$this->choices['off'] = $l10n['off'];
			}

			if ( ! isset( $this->choices['round'] ) ) {
				$this->choices['round'] = false;
			}

		}
	}
}
