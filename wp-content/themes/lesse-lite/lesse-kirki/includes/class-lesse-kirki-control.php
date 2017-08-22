<?php
/**
 * Controls handler
 *
 * @package     Lesse_Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 */

if ( ! class_exists( 'Lesse_Kirki_Control' ) ) {

	/**
	 * Our main Lesse_Kirki_Control object
	 */
	class Lesse_Kirki_Control {

		/**
		 * The $wp_customize WordPress global.
		 *
		 * @access protected
		 * @var WP_Customize_Manager
		 */
		protected $wp_customize;

		/**
		 * An array of all available control types.
		 *
		 * @access protected
		 * @var array
		 */
		protected $control_types = array();

		/**
		 * The class constructor.
		 * Creates the actual controls in the customizer.
		 *
		 * @access public
		 * @param array $args The field definition as sanitized in Lesse_Kirki_Field.
		 */
		public function __construct( $args ) {

			// Set the $wp_customize property.
			global $wp_customize;
			if ( ! $wp_customize ) {
				return;
			}
			$this->wp_customize = $wp_customize;

			// Set the control types.
			$this->set_control_types();
			// Add the control.
			$this->add_control( $args );

		}

		/**
		 * Get the class name of the class needed to create tis control.
		 *
		 * @access private
		 * @param array $args The field definition as sanitized in Lesse_Kirki_Field.
		 *
		 * @return         string   the name of the class that will be used to create this control.
		 */
		final private function get_control_class_name( $args ) {

			// Set a default class name.
			$class_name = 'WP_Customize_Control';
			// Get the classname from the array of control classnames.
			if ( array_key_exists( $args['type'], $this->control_types ) ) {
				$class_name = $this->control_types[ $args['type'] ];
			}
			return $class_name;

		}

		/**
		 * Adds the control.
		 *
		 * @access protected
		 * @param array $args The field definition as sanitized in Lesse_Kirki_Field.
		 */
		final protected function add_control( $args ) {

			// Get the name of the class we're going to use.
			$class_name = $this->get_control_class_name( $args );
			// Add the control.
			$this->wp_customize->add_control( new $class_name( $this->wp_customize, $args['settings'], $args ) );

		}

		/**
		 * Sets the $this->control_types property.
		 * Makes sure the lessekirki/control_types filter is applied
		 * and that the defined classes actually exist.
		 * If a defined class does not exist, it is removed.
		 */
		final private function set_control_types() {

			$this->control_types = apply_filters( 'lessekirki/control_types', array(
				'lessekirki-checkbox'        => 'Lesse_Kirki_Controls_Checkbox_Control',
				'lessekirki-code'            => 'Lesse_Kirki_Controls_Code_Control',
				'lessekirki-color'           => 'Lesse_Kirki_Controls_Color_Control',
				'lessekirki-color-palette'   => 'Lesse_Kirki_Controls_Color_Palette_Control',
				'lessekirki-custom'          => 'Lesse_Kirki_Controls_Custom_Control',
				'lessekirki-date'            => 'Lesse_Kirki_Controls_Date_Control',
				'lessekirki-dashicons'       => 'Lesse_Kirki_Controls_Dashicons_Control',
				'lessekirki-dimension'       => 'Lesse_Kirki_Controls_Dimension_Control',
				'lessekirki-editor'          => 'Lesse_Kirki_Controls_Editor_Control',
				'lessekirki-multicolor'      => 'Lesse_Kirki_Controls_Multicolor_Control',
				'lessekirki-multicheck'      => 'Lesse_Kirki_Controls_MultiCheck_Control',
				'lessekirki-number'          => 'Lesse_Kirki_Controls_Number_Control',
				'lessekirki-palette'         => 'Lesse_Kirki_Controls_Palette_Control',
				'lessekirki-preset'          => 'Lesse_Kirki_Controls_Preset_Control',
				'lessekirki-radio'           => 'Lesse_Kirki_Controls_Radio_Control',
				'lessekirki-radio-buttonset' => 'Lesse_Kirki_Controls_Radio_ButtonSet_Control',
				'lessekirki-radio-image'     => 'Lesse_Kirki_Controls_Radio_Image_Control',
				'repeater'              => 'Lesse_Kirki_Controls_Repeater_Control',
				'lessekirki-select'          => 'Lesse_Kirki_Controls_Select_Control',
				'lessekirki-slider'          => 'Lesse_Kirki_Controls_Slider_Control',
				'lessekirki-sortable'        => 'Lesse_Kirki_Controls_Sortable_Control',
				'lessekirki-spacing'         => 'Lesse_Kirki_Controls_Spacing_Control',
				'lessekirki-switch'          => 'Lesse_Kirki_Controls_Switch_Control',
				'lessekirki-generic'         => 'Lesse_Kirki_Controls_Generic_Control',
				'lessekirki-toggle'          => 'Lesse_Kirki_Controls_Toggle_Control',
				'lessekirki-typography'      => 'Lesse_Kirki_Controls_Typography_Control',
				'lessekirki-dropdown-pages'  => 'Lesse_Kirki_Controls_Dropdown_Pages_Control',
				'image'                 => 'WP_Customize_Image_Control',
				'cropped_image'         => 'WP_Customize_Cropped_Image_Control',
				'upload'                => 'WP_Customize_Upload_Control',
			) );

			// Make sure the defined classes actually exist.
			foreach ( $this->control_types as $key => $classname ) {

				if ( ! class_exists( $classname ) ) {
					unset( $this->control_types[ $key ] );
				}
			}
		}
	}
}
