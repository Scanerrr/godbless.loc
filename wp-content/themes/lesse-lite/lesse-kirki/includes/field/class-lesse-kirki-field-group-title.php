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

if ( ! class_exists( 'Lesse_Kirki_Field_Group_Title' ) ) {

	/**
	 * Prior to version 0.8 there was a separate 'group-title' field.
	 * This exists here just for backwards-compatibility purposes.
	 */
	class Lesse_Kirki_Field_Group_Title extends Lesse_Kirki_Field_Custom {}

}
