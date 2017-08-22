jQuery( document ).ready( function() {

	'use strict';

	if ( '' !== lessekirkiBranding.logoImage ) {
		jQuery( 'div#customize-info .preview-notice' ).replaceWith( '<img src="' + lessekirkiBranding.logoImage + '">' );
	}

	if ( '' !== lessekirkiBranding.description ) {
		jQuery( 'div#customize-info > .customize-panel-description' ).replaceWith( '<div class="customize-panel-description">' + lessekirkiBranding.description + '</div>' );
	}

});
