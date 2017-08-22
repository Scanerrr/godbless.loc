/*global jQuery, wp, Circles, imagesLoaded, window, document, lesseVars*/
/*exported Lesse*/

jQuery( function( $ ){
	"use strict";

	window.Lesse = {

		$backToTop     : $('#lesse-back-to-top'),
		$header        : $('.site-header'),
		$slider        : $('#lesse-super-slider'),
		$scrollIcon    : $('.lesse-scroll-icon'),
		$featured      : $('.lesse-wide-thumb'),
		$sections      : $('.row-content'),
		sectionOffsets : [],
		isHomeTemplate : false,

		init : function(){
			this.prop();
			this.checkHomeTemplate();
			this.createSticky();
			this.animateMenu();
			this.fixAdminBar();
			this.adjustSlideHeight();
			this.createFlexMenu();
			this.createSlider();
			this.hoverEffects();
			this.events();
			this.removeLoading();
			this.setSectionOffsets();
		},

		events : function(){
			$(window).on( 'scroll', this.onWindowScroll );
			$(window).on('load', this.onWindowLoad );
			$(window).on( 'resize', this.centerSliderImage );
			$(document).on( 'ready', this.onDocReady );
			this.$header.on( 'sticky-end', this.slideDownStickyMenu );
			this.$scrollIcon.on( 'click' , this.backToTop );
		},

		prop : function(){
			this.headerHeight = this.$header.outerHeight();
			this.$featuredOverlay = this.$featured.find('.lesse-overlay');
		},

		setSectionOffsets : function(){
			this.sectionOffsets = [];

			this.$sections.each(function( index, el ){
				Lesse.sectionOffsets.push( $(el).offset().top );
			});
		},

		removeLoading : function(){
			$('.lesse-loading').removeClass('lesse-loading');
		},

		checkHomeTemplate : function()
		{
			this.isHomeTemplate =  $('#page.lesse-full-slider-page').length;
		},

		backToTop : function()
		{
			$('body,html').animate( {
				scrollTop : 0
			} , 600 );
		},

		createSlider : function()
		{
			var _this = this, exportedSlides = lesseVars ? lesseVars.slides : false, showSlider;

			if( ! this.$slider.length || ! exportedSlides ) {
				return false;
			}

			this.$slider.supersized({
				slide_interval   : 4000,
				transition       : 1,
				transition_speed : 700,
				new_window       : 1,
				slides           : exportedSlides,
				progress_bar     : 1,
				mouse_scrub      : 0,
				image_protect    : false,
				slide_links      : 'blank'
			});

			showSlider = function() {
				Lesse.createSliderParallax( $(window) );
				if ( exportedSlides.length < 2 ) {
					$( '#prevslide, #nextslide' ).hide();
				}
				setTimeout( function() {
					$( '.lesse-full-slider-loader' ).fadeOut();
					_this.$slider.css( 'opacity', 1 );
				}, 400 );
			};

			if ( 'undefined' !== typeof imagesLoaded ) {
				this.$slider.imagesLoaded().always( showSlider );
			} else { // For backward compatibility.
				setTimeout( function() {
					showSlider();
				}, 2000 );
				if ( window.console ) {
				    console.warn( "imagesLoaded is not defined. Please update to the latest version of WordPress to fix this issue." );
				}
			}
		},

		createProgressBar : function()
		{
			var progress = $('#lesse-progress-bar'),
				$slider = this.$slider;

			$slider.on( 'init', function( e, opts ) {
			    progress.stop(true).css( 'width', 0 );
	        	progress.animate({ width: '100%' }, 3000, 'linear' );
			});

			$slider.on( 'afterChange', function( e, opts ) {
				progress.stop(true).css( 'width', 0 );
		        progress.animate({ width: '100%' }, 3000, 'linear' );
			});

		},

		onDocReady : function(e)
		{
			$('html').removeClass('no-js');
		},

		onWindowLoad : function(){
			$('#page').removeClass('lesse-loading');
		},

		makeAnimateReady : function()
		{
			var toAnimate = [ '.row-content button', '.lesse-hs4-progress-container', '.lesse-hs1-icon', '.lesse-testi-left', '.lesse-testi-right' ];

			$(toAnimate).each(function(){
				$(this).css( {
					'min-height': $(this).height(),
					'visibility' : 'hidden'
				});
			});
		},

		createFlexMenu : function()
		{
			var $menuContainer = $('.lesse-main-navigation');
			var $menu = $menuContainer.find( '> div > ul' );
			$menu.flexMenu({'showOnHover' : true});
			$menuContainer.removeClass('loading');
		},

		getOffsets : function(){
			this.homeSections = {
				'one' : '.lesse-home-section-1'
			};
		},

		animateEl : function( el , animationClass )
		{
			$(el).css( 'visibility', 'visible' ).hide().show().addClass('animated ' + animationClass );
		},

		createSticky : function(){

			var $adminbar = $('#wpadminbar');
			var adminBarHeight = $adminbar.length ? $adminbar.height() : 0;
			var options = {
							topSpacing       : adminBarHeight,
							wrapperClassName : 'lesse-sticky-header',
							responsiveWidth  : true
						  };

			if( Lesse.isHomeTemplate ){
				options.bottomSpacing = 0;
			}

			this.$header.sticky( options );
		},

		fixAdminBar : function(){
			//mmenu sometimes wrapes adminbar inside its div.
			if( $('div.mm-page').length && $('div.mm-page').find('#wpadminbar').length ){
				var $adminBar = $('#wpadminbar');
				$('body').append($adminBar);
			}
		},

		animateMenu : function(){
			$('.lesse-main-navigation ul ul').addClass('animated-menu fadeInUp');
		},

		showBacktoTop : function( $this ){
			if ( $this.width() > 960 ){
				if ( $this.scrollTop() > 50 ) this.$backToTop.show();
				else  this.$backToTop.hide();
			}
		},

		onWindowScroll : function( e )
		{
			Lesse.createFeaturedParallax( $(this) );
			Lesse.createSliderParallax( $(this) );
			Lesse.addActiveSectionClass( $(this) );
		},

		addActiveSectionClass : function( $window )
		{
			for( var i = 0; i <= this.sectionOffsets.length; i++  ){
				if( $window.scrollTop() > ( this.sectionOffsets[i] - this.headerHeight ) ){
					if( ! this.$sections.eq(i).data('passed') ){
						this.$sections.removeClass('current-section');
						this.$sections.eq(i).addClass('current-section');
						this.$sections.eq(i).data( 'passed', true );
					}
				}
			}
		},

		createFeaturedParallax : function( $window )
		{

			if( ! this.$featured.length ) return;

			var extra       = this.headerHeight,
				scrollTop   = $window.scrollTop(),
				$image 		= this.$featured.find('img'),
				topOffset   = this.$featured.offset().top - extra;

			if ( topOffset < scrollTop )
			{
				var difference = scrollTop  - topOffset;
				var halfDiff   = difference / 2;
				var half       = halfDiff + 'px';
				var opacity    = halfDiff/500 + 0.4;
				$image.css('top', half);
				$image.css('left', 0);
				this.$featuredOverlay.css('opacity', opacity );
			}
			else
			{
				$image.css('top', '0');
				$image.css('left', 0);
			}
		},

		createSliderParallax : function( $window ){
			if( ! this.$slider.length ) return;

			this.$slider.find('.lesse-super-container li').each(function(){
				if( ! $(this).hasClass('cycle-sentinel') ){
					var extra       = 0,
						scrollTop   = $window.scrollTop(),
						$image 		= $(this).find('img'),
						topOffset   = $(this).offset().top - extra;

					if ( topOffset < scrollTop )
					{
						var difference = scrollTop  - topOffset;
						var half       = (difference / 2) + 'px';

						$image.css('top', half);
					}
					else
					{
						$image.css('top', '0');
					}
				}
			});

		},

		slideDownStickyMenu : function(){
			$('.site-description').slideDown();
			Lesse.$header.parent().css( 'height', 'auto' );
		},

		adjustSlideHeight : function()
		{
			var $slider = $('#lesse-slider');
			var $adminbar = $('#wpadminbar');
			var extraHeight = $(window).height() - $adminbar.outerHeight() - this.$header.outerHeight();
			if( $adminbar.length ){
				$slider.css( 'max-height', extraHeight + 'px' );
			}
		},

		hoverEffects : function()
		{
			$(".lesse-hs7-button-container button").addClass("hvr-bubble-float-top");
			$(".lesse-main-navigation ul:first-child > li > a").addClass("hvr-overline-reveal");
			$(".lesse-lite-secondary .tagcloud a, .site-footer .widget_tag_cloud a").addClass("hvr-sweep-to-right");
		}
	};

	window.Lesse.init();
});
