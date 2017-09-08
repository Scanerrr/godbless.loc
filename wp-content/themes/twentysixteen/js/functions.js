/* global screenReaderText */
/**
 * Theme functions file.
 *
 * Contains handlers for navigation and widget area.
 */

( function( $ ) {
	var body, masthead, menuToggle, siteNavigation, socialNavigation, siteHeaderMenu, resizeTimer;

	// глобальная переменная offer_id
	var offer_id;

	function initMainNavigation( container ) {

		// Add dropdown toggle that displays child menu items.
		var dropdownToggle = $( '<button />', {
			'class': 'dropdown-toggle',
			'aria-expanded': false
		} ).append( $( '<span />', {
			'class': 'screen-reader-text',
			text: screenReaderText.expand
		} ) );

		container.find( '.menu-item-has-children > a' ).after( dropdownToggle );

		// Toggle buttons and submenu items with active children menu items.
		container.find( '.current-menu-ancestor > button' ).addClass( 'toggled-on' );
		container.find( '.current-menu-ancestor > .sub-menu' ).addClass( 'toggled-on' );

		// Add menu items with submenus to aria-haspopup="true".
		container.find( '.menu-item-has-children' ).attr( 'aria-haspopup', 'true' );

		container.find( '.dropdown-toggle' ).click( function( e ) {
			var _this            = $( this ),
				screenReaderSpan = _this.find( '.screen-reader-text' );

			e.preventDefault();
			_this.toggleClass( 'toggled-on' );
			_this.next( '.children, .sub-menu' ).toggleClass( 'toggled-on' );

			// jscs:disable
			_this.attr( 'aria-expanded', _this.attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
			// jscs:enable
			screenReaderSpan.text( screenReaderSpan.text() === screenReaderText.expand ? screenReaderText.collapse : screenReaderText.expand );
		} );
	}
	initMainNavigation( $( '.main-navigation' ) );

	masthead         = $( '#masthead' );
	menuToggle       = masthead.find( '#menu-toggle' );
	siteHeaderMenu   = masthead.find( '#site-header-menu' );
	siteNavigation   = masthead.find( '#site-navigation' );
	socialNavigation = masthead.find( '#social-navigation' );

	// Enable menuToggle.
	( function() {

		// Return early if menuToggle is missing.
		if ( ! menuToggle.length ) {
			return;
		}

		// Add an initial values for the attribute.
		menuToggle.add( siteNavigation ).add( socialNavigation ).attr( 'aria-expanded', 'false' );

		menuToggle.on( 'click.twentysixteen', function() {
			$( this ).add( siteHeaderMenu ).toggleClass( 'toggled-on' );

			// jscs:disable
			$( this ).add( siteNavigation ).add( socialNavigation ).attr( 'aria-expanded', $( this ).add( siteNavigation ).add( socialNavigation ).attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
			// jscs:enable
		} );
	} )();

	// Fix sub-menus for touch devices and better focus for hidden submenu items for accessibility.
	( function() {
		if ( ! siteNavigation.length || ! siteNavigation.children().length ) {
			return;
		}

		// Toggle `focus` class to allow submenu access on tablets.
		function toggleFocusClassTouchScreen() {
			if ( window.innerWidth >= 910 ) {
				$( document.body ).on( 'touchstart.twentysixteen', function( e ) {
					if ( ! $( e.target ).closest( '.main-navigation li' ).length ) {
						$( '.main-navigation li' ).removeClass( 'focus' );
					}
				} );
				siteNavigation.find( '.menu-item-has-children > a' ).on( 'touchstart.twentysixteen', function( e ) {
					var el = $( this ).parent( 'li' );

					if ( ! el.hasClass( 'focus' ) ) {
						e.preventDefault();
						el.toggleClass( 'focus' );
						el.siblings( '.focus' ).removeClass( 'focus' );
					}
				} );
			} else {
				siteNavigation.find( '.menu-item-has-children > a' ).unbind( 'touchstart.twentysixteen' );
			}
		}

		if ( 'ontouchstart' in window ) {
			$( window ).on( 'resize.twentysixteen', toggleFocusClassTouchScreen );
			toggleFocusClassTouchScreen();
		}

		siteNavigation.find( 'a' ).on( 'focus.twentysixteen blur.twentysixteen', function() {
			$( this ).parents( '.menu-item' ).toggleClass( 'focus' );
		} );
	} )();

	// Add the default ARIA attributes for the menu toggle and the navigations.
	function onResizeARIA() {
		if ( window.innerWidth < 910 ) {
			if ( menuToggle.hasClass( 'toggled-on' ) ) {
				menuToggle.attr( 'aria-expanded', 'true' );
			} else {
				menuToggle.attr( 'aria-expanded', 'false' );
			}

			if ( siteHeaderMenu.hasClass( 'toggled-on' ) ) {
				siteNavigation.attr( 'aria-expanded', 'true' );
				socialNavigation.attr( 'aria-expanded', 'true' );
			} else {
				siteNavigation.attr( 'aria-expanded', 'false' );
				socialNavigation.attr( 'aria-expanded', 'false' );
			}

			menuToggle.attr( 'aria-controls', 'site-navigation social-navigation' );
		} else {
			menuToggle.removeAttr( 'aria-expanded' );
			siteNavigation.removeAttr( 'aria-expanded' );
			socialNavigation.removeAttr( 'aria-expanded' );
			menuToggle.removeAttr( 'aria-controls' );
		}
	}

	// Add 'below-entry-meta' class to elements.
	function belowEntryMetaClass( param ) {
		if ( body.hasClass( 'page' ) || body.hasClass( 'search' ) || body.hasClass( 'single-attachment' ) || body.hasClass( 'error404' ) ) {
			return;
		}

		$( '.entry-content' ).find( param ).each( function() {
			var element              = $( this ),
				elementPos           = element.offset(),
				elementPosTop        = elementPos.top,
				entryFooter          = element.closest( 'article' ).find( '.entry-footer' ),
				entryFooterPos       = entryFooter.offset(),
				entryFooterPosBottom = entryFooterPos.top + ( entryFooter.height() + 28 ),
				caption              = element.closest( 'figure' ),
				newImg;

			// Add 'below-entry-meta' to elements below the entry meta.
			if ( elementPosTop > entryFooterPosBottom ) {

				// Check if full-size images and captions are larger than or equal to 840px.
				if ( 'img.size-full' === param ) {

					// Create an image to find native image width of resized images (i.e. max-width: 100%).
					newImg = new Image();
					newImg.src = element.attr( 'src' );

					$( newImg ).on( 'load.twentysixteen', function() {
						if ( newImg.width >= 840  ) {
							element.addClass( 'below-entry-meta' );

							if ( caption.hasClass( 'wp-caption' ) ) {
								caption.addClass( 'below-entry-meta' );
								caption.removeAttr( 'style' );
							}
						}
					} );
				} else {
					element.addClass( 'below-entry-meta' );
				}
			} else {
				element.removeClass( 'below-entry-meta' );
				caption.removeClass( 'below-entry-meta' );
			}
		} );
	}

	$( document ).ready( function() {

		$( "#accordion3" ).accordion();

		$('#site-games-menu').hide();
		
		$('#toggle_menu_to_list').click(function() {
			$('#site-games-list-menu').hide();
			$('#site-games-menu').show();
		});

		$('#toggle_menu_to_alphabet').click(function() {
			$('#site-games-menu').hide();
			$('#site-games-list-menu').show();
		});


		$( "#delete_dialog" ).dialog({
			open: function() {
				$(this).closest(".ui-dialog")
					.find(".ui-dialog-titlebar-close")
					.removeClass("ui-dialog-titlebar-close")
					.html("<span class='ui-button-icon-primary ui-icon ui-icon-closethick'></span>");

				$(this).closest(".ui-dialog").find(".ui-dialog-title").width( '80%' );


			},
			height: "auto",
			autoOpen: false,
			modal: true,
			width:400,
			buttons: {
				"Удалить": function() {
					location.href = "?action=delete&offer_id=" + offer_id;
				},
				"Скрыть": function() {
					location.href = "?action=hide&offer_id=" + offer_id;
				},
				"Отмена": function() {
					$( this ).dialog( "close" );
				}
			}
		});




		$('#table_1 a[href*="action=delete"]').click(function() {
			var href = $(this).attr('href');
			href = href.substring(1);
			var pairs = href.split("&");
			var values = new Array();
			for(i=0; i<pairs.length; i++){
				var pair = pairs[i].split("=");
				var key = pair[0];
				var value  = pair[1];
				values[key] = value;
			}
			// глобальная переменная offer_id
			offer_id = values['offer_id'];

			$( "#delete_dialog" ).dialog( "open" );
			return false;

		});



		$( "#accordion" ).accordion();
		$( "#accordion2" ).accordion();
		//$( "#accordion3" ).accordion();


		$('input.merchant-toggle').checkboxradio();
		$('.merchant-toggles').controlgroup( {
			direction: "vertical"
		} );


		//$('#table_1 a[href*="ukr.net"]').hover(function() {}


		/*
		$('#table_1 a').mousemove(function(event) {
			var pos = $(this).offset();
			var pageX = event.pageX;
			var pageY = event.pageY;
			var x = event.pageX;//pageX - pos.left + 10;
			var y = event.pageY; //pageY - pos.top + 10;


			$(".main_block .popup_block").css({

				'left' : x + 'px',
				'top' : y + 'px'
			});

		});
		*/
		$('#table_1 a').mousemove(function(event) {
			console.log (event.target.id);

			console.log ( popup_data [ event.target.id ] );
			var el = $(".game_popup_block ." + event.target.id);
			//alert (el.innerText);

			//css({'left' : event.pageX, 'top' : event.pageY });
			$(".game_popup_block").html( popup_data [ event.target.id ]) ;

			$(".game_popup_block").css({'left' : ( event.pageX + 25 ), 'top' : (event.pageY - 50) });

		});


		$('#table_1 a').hover(function(event) {

				//alert (event.pageY);

				$(".game_popup_block").show();

				//$(".main_block .popup_block").stop(true,true).animate({opacity: "show", top: "-60"}, "slow");
		},
			function() {
				$(".game_popup_block").hide();
			 //$(".main_block .popup_block").stop(true,true).animate({opacity: "hide", top: "-85"}, "normal");
		});


		body = $( document.body );

		$( window )
			.on( 'load.twentysixteen', onResizeARIA )
			.on( 'resize.twentysixteen', function() {
				clearTimeout( resizeTimer );
				resizeTimer = setTimeout( function() {
					belowEntryMetaClass( 'img.size-full' );
					belowEntryMetaClass( 'blockquote.alignleft, blockquote.alignright' );
				}, 300 );
				onResizeARIA();
			} );

		belowEntryMetaClass( 'img.size-full' );
		belowEntryMetaClass( 'blockquote.alignleft, blockquote.alignright' );
	} );

	function dropDownCheckList(id) {
        $(id + " dt a").on('click', function() {
            $(this).toggleClass('is-active');
            $(id + " dd ul").slideToggle('fast');
        });

        $(id + " dd ul li a").on('click', function() {
            $(id + " dt a").removeClass('is-active');
            $(id + " dd ul").hide();
        });

        $(document).bind('click', function(e) {
            var $clicked = $(e.target);
            if (!$clicked.parents().hasClass("dropdown")) {
                $(id + " dt a").removeClass('is-active');
                $(id + " dd ul").hide();
            }
        });

        $(id + ' .mutliSelect input[type="checkbox"]').on('click', function() {

            var title = $(this).closest('.mutliSelect').find('input[type="checkbox"]').val(),
                title = $(this).val() + ",";

            if ($(this).is(':checked')) {
                var html = '<span title="' + title + '">' + title + '</span>';
                $(id + ' .multiSel').append(html);
                $(id + " .hida").hide();
            } else {
                $(id + ' span[title="' + title + '"]').remove();
                var ret = $(id + " .hida");
                $(id + ' dt a').append(ret);

            }
        });
        $(id + ' .mutliSelect input[type="radio"]').on('click', function() {
            var title = $(this).val();
            if ($(this).is(':checked')) {
                var html = '<span title="' + title + '">' + title + '</span>';
                $(id + ' .multiSel').html(html);
                $(id + " .hida").hide();
            } else {
                $(id + ' span[title="' + title + '"]').remove();
                var ret = $(id + " .hida");
                $(id + ' dt a').append(ret);

            }
        });
	}
    dropDownCheckList('#dropdown_server');
    dropDownCheckList('#dropdown_alliance');
    dropDownCheckList('#dropdown_currency');
    dropDownCheckList('#dropdown_payment');

} )( jQuery );
