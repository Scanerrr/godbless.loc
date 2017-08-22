<?php
/**
 * Handles CSS output for background-position.
 *
 * @package     Lesse_Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.2.0
 */

if ( ! class_exists( 'Lesse_Kirki_Output_Property_Background_Position' ) ) {

	/**
	 * Output overrides.
	 */
	class Lesse_Kirki_Output_Property_Background_Position extends Lesse_Kirki_Output_Property {

		/**
		 * Modifies the value.
		 *
		 * @access protected
		 */
		protected function process_value() {

			$this->value = trim( $this->value );

			// If you use calc() there, I suppose you know what you're doing.
			// No need to process this any further, just exit.
			if ( false !== strpos( $this->value, 'calc' ) ) {
				return;
			}

			// If the value is initial or inherit, we don't need to do anything.
			// Just exit.
			if ( 'initial' == $this->value || 'inherit' == $this->value ) {
				return;
			}

			$x_dimensions = array( 'left', 'center', 'right' );
			$y_dimensions = array( 'top', 'center', 'bottom' );

			// If there's a space, we have an X and a Y value.
			if ( false !== strpos( $this->value, ' ' ) ) {
				$xy = explode( ' ', $this->value );

				$x = trim( $xy[0] );
				$y = trim( $xy[1] );

				// If x is not left/center/right, we need to sanitize it.
				if ( ! in_array( $x, $x_dimensions ) ) {
					$x = Lesse_Kirki_Sanitize_Values::css_dimension( $x );
				}
				if ( ! in_array( $y, $y_dimensions ) ) {
					$y = Lesse_Kirki_Sanitize_Values::css_dimension( $y );
				}
				$this->value = $x . ' ' . $y;
				return;
			}
			$x = 'center';
			foreach ( $x_dimensions as $x_dimension ) {
				if ( false !== strpos( $this->value, $x_dimension ) ) {
					$x = $x_dimension;
				}
			}
			$y = 'center';
			foreach ( $y_dimensions as $y_dimension ) {
				if ( false !== strpos( $this->value, $y_dimension ) ) {
					$y = $y_dimension;
				}
			}
			$this->value = $x . ' ' . $y;
		}
	}
}
