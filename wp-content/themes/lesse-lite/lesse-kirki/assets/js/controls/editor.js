wp.customize.controlConstructor['lessekirki-editor'] = wp.customize.Control.extend({

	// When we're finished loading continue processing
	ready: function() {

		'use strict';

		var control       = this,
		    element       = control.container.find( 'textarea' ),
		    toggler       = control.container.find( '.toggle-editor' ),
		    editorWrapper = jQuery( '#lessekirki_editor_pane' ),
		    wpEditorArea  = jQuery( '#lessekirki_editor_pane textarea.wp-editor-area' ),
		    setChange,
		    content;

		jQuery( window ).load( function() {

			var editor  = tinyMCE.get( 'lessekirki-editor' );

			// Add the button text
			toggler.html( window.lessekirki.l10n[ control.params.lessekirkiConfig ]['open-editor'] );

			toggler.on( 'click', function() {

				// Toggle the editor.
				control.toggleEditor();

				// Change button.
				control.changeButton();

				// Add the content to the editor.
				control.setEditorContent( editor );

				// Modify the preview-area height.
				control.previewHeight();

			});

			// Update the option from the editor contents on change.
			if ( editor ) {

				editor.onChange.add( function( ed, e ) {

					ed.save();
					content = editor.getContent();
					clearTimeout( setChange );
					setChange = setTimeout( function() {
						element.val( content ).trigger( 'change' );
						wp.customize.instance( control.getEditorWrapperSetting() ).set( content );
					}, 500 );

				});

			}

			// Handle text mode.
			wpEditorArea.on( 'change keyup paste', function() {
				wp.customize.instance( control.getEditorWrapperSetting() ).set( jQuery( this ).val() );
			});

		});

	},

	/**
	 * Modify the button text and classes.
	 */
	changeButton: function() {

		'use strict';

		var control       = this,
			editorWrapper = jQuery( '#lessekirki_editor_pane' );

		// Reset all editor buttons.
		// Necessary if we have multiple editor fields.
		jQuery( '.customize-control-lessekirki-editor .toggle-editor' ).html( window.lessekirki.l10n[ control.params.lessekirkiConfig ]['switch-editor'] );

		// Change the button text & color.
		if ( false !== control.getEditorWrapperSetting() ) {
			jQuery( '.customize-control-lessekirki-editor .toggle-editor' ).html( window.lessekirki.l10n[ control.params.lessekirkiConfig ]['switch-editor'] );
			jQuery( '#customize-control-' + control.getEditorWrapperSetting() + ' .toggle-editor' ).html( window.lessekirki.l10n[ control.params.lessekirkiConfig ]['close-editor'] );
		} else {
			jQuery( '.customize-control-lessekirki-editor .toggle-editor' ).html( window.lessekirki.l10n[ control.params.lessekirkiConfig ]['open-editor'] );
		}

	},

	/**
	 * Toggle the editor.
	 */
	toggleEditor: function() {

		'use strict';

		var control = this,
		    editorWrapper = jQuery( '#lessekirki_editor_pane' );

		if ( ! control.getEditorWrapperSetting() || control.id !== control.getEditorWrapperSetting() ) {
			editorWrapper.removeClass();
			editorWrapper.addClass( control.id );
		} else {
			editorWrapper.removeClass();
			editorWrapper.addClass( 'hide' );
		}

	},

	/**
	 * Set the content.
	 */
	setEditorContent: function( editor ) {

		'use strict';

		var control = this,
		    editorWrapper = jQuery( '#lessekirki_editor_pane' );

		editor.setContent( control.setting._value );

	},

	/**
	 * Gets the setting from the editor wrapper class.
	 */
	getEditorWrapperSetting: function() {

		'use strict';

		if ( jQuery( '#lessekirki_editor_pane' ).hasClass( 'hide' ) ) {
			return false;
		}

		if ( jQuery( '#lessekirki_editor_pane' ).attr( 'class' ) ) {
			return jQuery( '#lessekirki_editor_pane' ).attr( 'class' );
		} else {
			return false;
		}

	},

	/**
	 * Modifies the height of the preview area.
	 */
	previewHeight: function() {
		if ( jQuery( '#lessekirki_editor_pane' ).hasClass( 'hide' ) ) {
			if ( jQuery( '#customize-preview' ).hasClass( 'is-lessekirki-editor-open' ) ) {
				jQuery( '#customize-preview' ).removeClass( 'is-lessekirki-editor-open' );
			}
		} else {
			if ( ! jQuery( '#customize-preview' ).hasClass( 'is-lessekirki-editor-open' ) ) {
				jQuery( '#customize-preview' ).addClass( 'is-lessekirki-editor-open' );
			}
		}
	}

});
