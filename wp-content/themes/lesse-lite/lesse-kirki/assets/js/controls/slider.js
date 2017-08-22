wp.customize.controlConstructor['lessekirki-slider'] = wp.customize.Control.extend({

	ready: function() {

		'use strict';

		var control = this,
			value,
			thisInput,
			inputDefault;

		// Update the text value
		jQuery( 'input[type=range]' ).on( 'mousedown', function() {
			value = jQuery( this ).attr( 'value' );
			jQuery( this ).mousemove( function() {
				value = jQuery( this ).attr( 'value' );
				jQuery( this ).closest( 'label' ).find( '.lessekirki_range_value .value' ).text( value );
			});
		});

		// Handle the reset button
		jQuery( '.lessekirki-slider-reset' ).click( function() {
			thisInput    = jQuery( this ).closest( 'label' ).find( 'input' );
			inputDefault = thisInput.data( 'reset_value' );
			thisInput.val( inputDefault );
			thisInput.change();
			jQuery( this ).closest( 'label' ).find( '.lessekirki_range_value .value' ).text( inputDefault );
		});

		// Save changes.
		this.container.on( 'change', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});
	}

});
