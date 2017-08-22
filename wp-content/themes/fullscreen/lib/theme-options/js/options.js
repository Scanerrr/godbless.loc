/*
 *
 * Theme Option JS
 *
 */

 jQuery( document ).ready( function($) {

 	// Uploader
 	// upload button triggers thickbox
	$( '.upload_button' ).click( function() {
		formfield = $( this ).attr( 'rel-id' );
		preview = $( this ).prev( 'div.imgpreview' );
		tb_show( '', 'media-upload.php?type=image&amp;post_id=0&amp;TB_iframe=true' );
		window.tbframe_interval = setInterval( function() {
			jQuery( 'iframe#TB_iframeContent' ).contents().find( '.savesend .button' ).val( 'Use This Image' ).end().find( '#insert-gallery, .wp-post-thumbnail, tr.align' ).hide();
		}, 200 );

		return false;
	});

	// Uploader
	// send to editor sends to form field
	window.send_to_editor = function( html ) {
		imgurl = $( 'img', html ).attr( 'src' );
		$( '#' + formfield ).val( imgurl );
		$( '#' + formfield ).next().fadeIn( 'slow' );
		$( '#' + formfield ).next().next().fadeOut( 'slow' );
		$( '#' + formfield ).next().next().next().fadeIn( 'slow' );
		$( preview ).html( '<img class="gpp-screenshot" src="' + imgurl + '" style="max-width:200px;height:auto;"/>' );
		tb_remove();
	}

	// Uploader
	// Browse and Remove toggle
	$( '.upload_button_remove' ).click( function() {
		relid = $( this ).attr( 'rel-id' );
		$( '#'+relid ).val( '' );
		$( this ).prev().fadeIn();
		$( this ).prev().prev().fadeOut( 'slow', function() {
			$( this ).attr( "src", '' );
		});
		$( this ).fadeOut();
	} );

	// Slider Uploader
	uploadid = "";
	$( "#slideshow_list" ).on( "click", ".upbutton", function () {

		uploadid = $( this ).prev();
		id = $( this ).prev().attr( "id" );

		window.send_to_editor = function ( html ) {
			imgurl = $( "img", html ).attr( "src" );
			$( uploadid ).parent().find( ".src" ).val( imgurl );
			$( uploadid ).parent().find( ".previewimg" ).css( { "display" : "block" } ).html( "<img width=\"275\" class=\"uploadedimg\" id=\"image_" + uploadid + "\" src=" + imgurl + ">" );
			tb_remove();
		}

		tb_show( '', 'media-upload.php?type=image&amp;post_id=0&amp;TB_iframe=true' );
		return false;
	} );

	// Dependent Options
	// hide all the options with dependencies
	$( '.pid' ).parent().parent().hide();

	// Dependent Options
	// when checkbox is clicked
	$( '.checkbox' ).click( function() {
		var pidclass = $( this ).attr( "id" );
		if( $( this ).is( ":checked" ) ) {
			$( "." + pidclass ).each( function() {
				$( this ).parent().parent().slideDown( 'fast' );
			} );
		} else {
			$( "." + pidclass ).each( function() {
				$( this ).parent().parent().slideUp( 'fast' );
			} );
		}
	} );

	// Dependent Options
	// onload
	$( '.checkbox' ).each( function() {
		var pidclass = $( this ).attr( "id" );
		if( $( this ).is( ":checked" ) ) {
			$( "." + pidclass ).each( function() {
				$( this ).parent().parent().show();
			} );
		} else {
			$( "." + pidclass ).each( function() {
				$( this ).parent().parent().hide();
			} );
		}
	} );

	// Colorpicker
	$colorpicker_inputs = $( 'input.popup-colorpicker' );

	$colorpicker_inputs.each( function() {
		var $input = $( this );
		var sIdSelector = "#" + $( this ).attr( 'id' ) + "picker";
		var oFarb = $.farbtastic( sIdSelector, function( color ) {
			$input.css( {
				backgroundColor: color,
				color: oFarb.hsl[2] > 0.5 ? '#000' : '#fff'
			} ).val( color );

			if( oFarb.bound == true ) {
				$input.change();
			} else {
			oFarb.bound = true;
			}
		} );

		oFarb.setColor( $input.val() );

	} );

	$colorpicker_inputs.each( function( e ) {
		$( this ).next( '.farb-popup' ).hide();
	} );


	$colorpicker_inputs.live( 'focus', function( e ) {
		$( this ).next( '.farb-popup' ).show();
		$( this ).parents( 'li' ).css( {
			position : 'relative',
			zIndex : '9999'
		} );
		$( '#tabber' ).css( { overflow : 'visible' } );
	} );

	$colorpicker_inputs.live( 'blur', function( e ) {
		$( this ).next( '.farb-popup' ).hide();
		$( this ).parents( 'li' ).css( {
			zIndex : '0'
		} );
	} );

	// Radio Images
	// Changes the radio select option, and changes class on images
	gpp_radio_img_select = function( relid, labelclass ) {
		var rid = relid.substring( 0, relid.length - 1 );
		$( this ).prev( 'input[type="radio"]' ).prop( 'checked' );
		//$('.gpp-radio-img-'+labelclass).removeClass('gpp-radio-img-selected');
		$( "#" + rid + labelclass ).parent().parent().find( 'label' ).each( function() {
			$( this ).removeClass( 'gpp-radio-img-selected' );
		} );
		$( 'label[for="' + relid + '"]' ).addClass( 'gpp-radio-img-selected' );
	}


	/**
	 * Surpress the submission of the form during "reset defaults"
	 * and display a confirmation prompt. Will submit the form
	 * when the user clicks "ok"
	 */
	$( '.reset-handle' ).on( 'click', function() {
		var r = confirm( "Are you sure?" );
		if ( r == true ) {
			var $form = $( '#gpp_form' );
			$form.append( "<input type='hidden' name='reset' value='1' />" );
  			$form.submit();
  		}
	} );
	
	/**
	 * Font Preview
	 * when the user clicks "Use Font", it adds the font name to the input field
	 */
	$( '#gpp-font-preview .box button' ).live('click', function(){
		$( this ).each(function(){
 
			var header = $(this).attr('data-font-header');
			if ( typeof( header ) !== "undefined" ){
				$("select[name='fullscreen_options[font]'] option[value='"+header+"']:first").attr("selected", true);
			}
 
			var body = $(this).attr('data-font-body');
			if ( typeof( body ) !== "undefined" ){
				$("select[name='fullscreen_options[font_alt]'] option[value='"+body+"']:first").attr("selected", true);
			}
 
			tb_remove();
		});
	});
	

} ); // End 'document ready'