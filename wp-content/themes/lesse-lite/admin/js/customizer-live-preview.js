/*global jQuery, wp, window, Lesse*/

/**
 * Handles live preview ajax calls
 * This file is cached by WordPress customizer, so either change the version number dynamically
 * or hard refresh each time to make changes to this file
 * @package Lesse Lite
 */

( function( api, $ ) {
	'use strict';

	// Site title and description.
	api( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );

	api( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	api( 'lesse_hide_tagline', function( value ) {
		value.bind( function( to ) {
			if ( true === to ) {
				$( '.site-description' ).addClass( 'screen-reader-text' );
			} else {
				$( '.site-description' ).removeClass( 'screen-reader-text' );
			}
		} );
	} );

	api( 'lesse_copyright_text', function( value ) {
		value.bind( function( to ) {
			$( '.lesse-copyright-customizer' ).text( to );
		} );
	} );

	$( window ).on( 'load', function() {
		if ( 'undefined' !== api.selectiveRefresh ) {
			api.selectiveRefresh.bind( 'partial-content-rendered', function( placement ) {
				if ( placement.partial.id.indexOf( 'nav_menu_instance' ) > -1 ) {
					Lesse.createFlexMenu();
				}
			} );
		}
	});

} ( wp.customize, jQuery ) );
