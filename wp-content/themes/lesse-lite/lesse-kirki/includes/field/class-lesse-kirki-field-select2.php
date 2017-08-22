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

if ( ! class_exists( 'Lesse_Kirki_Field_Select2' ) ) {
	/**
	 * This is nothing more than an alias for the Lesse_Kirki_Field_Select class.
	 * In older versions of Lesse_Kirki there was a separate 'select2' field.
	 * This exists here just for compatibility purposes.
	 */
	class Lesse_Kirki_Field_Select2 extends Lesse_Kirki_Field_Select {}

}
