/* global avaniScreenReaderText */
/**
 * Theme scripts file.
 *
 * Contains scripts for navigation menu.
 */
(function( $ ) {
	var siteNavigation;
	
	/*
	 * Test if inline SVGs are supported.
	 * @link https://github.com/Modernizr/Modernizr/
	 */
	function supportsInlineSVG() {
		var div = document.createElement( 'div' );
		div.innerHTML = '<svg/>';
		return 'http://www.w3.org/2000/svg' === ( 'undefined' !== typeof SVGRect && div.firstChild && div.firstChild.namespaceURI );
	}
	
	// Change HTML class based on SVG support.
	$( document ).ready( function() {
		if ( true === supportsInlineSVG() ) {
			document.documentElement.className = document.documentElement.className.replace( /(\s*)no-svg(\s*)/, '$1svg$2' );
		}
	});

	// Sticky Main navigation.
	$(document).ready(function() {
	
		// define variables
		var navOffset, scrollPos = 0;
		
		// add utility wrapper elements for positioning
		$("#main-navigation").wrap('<div class="nav-placeholder"></div>');
		
		// function to run on page load and window resize
		function stickyUtility() {
			
			// only update navOffset if it is not currently using fixed position
			if (!$("#main-navigation").hasClass("site-navigation-fixed")) {
				navOffset = $("#main-navigation").offset().top;
			
				// Account for Admin bar.
				if ( $( '#wpadminbar' ).length ) {
					navOffset = navOffset - $( '#wpadminbar' ).height();
				}
			}

			var $menuToggle = $("#main-navigation").find( '.menu-toggle' );
			if ( 'none' === $menuToggle.css( 'display' ) ) {
				// apply matching height to nav wrapper div to avoid awkward content jumps
				$(".nav-placeholder").height($("#main-navigation").outerHeight()).css('min-height','79px');
			} else {
				// apply auto height for smaller screens
				$(".nav-placeholder").css({"height": "auto", "min-height": "initial"});
			}
			
		} // end stickyUtility function

		// run on page load
		stickyUtility();
		
		// run on window resize
		$(window).resize(function() {
			stickyUtility();
		});
		
		// run on scroll event
		$(window).scroll(function() {
			
			scrollPos = $(window).scrollTop();
			
			if (scrollPos >= navOffset) {
				$("#main-navigation").addClass("site-navigation-fixed");
			} else {
				$("#main-navigation").removeClass("site-navigation-fixed");
			}
			
		});
		
	});

	function initMainNavigation( container ) {

		// Add dropdown toggle that displays child menu items.
		var dropdownToggle = $( '<button />', { 'class': 'sub-menu-toggle', 'aria-expanded': false })
			.append( avaniScreenReaderText.icon )
			.append( $( '<span />', { 'class': 'screen-reader-text', text: avaniScreenReaderText.expand }) );

		container.find( '.menu-item-has-children > a, .page_item_has_children > a' ).after( dropdownToggle );

		// Set the active submenu dropdown toggle button initial state.
		container.find( '.current-menu-ancestor > button' )
			.addClass( 'toggled-on' )
			.attr( 'aria-expanded', 'true' )
			.find( '.screen-reader-text' )
			.text( avaniScreenReaderText.collapse );
		// Set the active submenu initial state.
		container.find( '.current-menu-ancestor > .sub-menu' ).addClass( 'toggled-on' );

		container.find( '.sub-menu-toggle' ).click( function( e ) {
			var _this = $( this ),
				screenReaderSpan = _this.find( '.screen-reader-text' );

			e.preventDefault();
			_this.toggleClass( 'toggled-on' );
			_this.next( '.children, .sub-menu' ).toggleClass( 'toggled-on' );

			_this.attr( 'aria-expanded', _this.attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );

			screenReaderSpan.text( screenReaderSpan.text() === avaniScreenReaderText.expand ? avaniScreenReaderText.collapse : avaniScreenReaderText.expand );
		});
	}
	
	function initNavToggle( container ) {
		var menuToggle = container.find('.menu-toggle');
		// Return early if menuToggle is missing.
		if ( ! menuToggle.length ) {
			return;
		}

		// Add an initial value for the attribute.
		menuToggle.attr( 'aria-expanded', 'false' );

		menuToggle.on( 'click.avani', function() {
			container.toggleClass( 'toggled-on' );

			$( this ).attr( 'aria-expanded', container.hasClass( 'toggled-on' ) );
		});
	}

	if( $( '.main-navigation' ).length ) {
		initMainNavigation( $( '.main-navigation' ) );
		initNavToggle( $( '.main-navigation' ) );
	}

	// Fix sub-menus for touch devices and better focus for hidden submenu items for accessibility.
	(function() {
		var masthead  = $( '#masthead' );
		siteNavigation = masthead.find( '.nav-menu' );

		if ( ! siteNavigation.length || ! siteNavigation.children().length ) {
			return;
		}

		// Toggle `focus` class to allow submenu access on tablets.
		function toggleFocusClassTouchScreen() {
			if ( 'none' === $( '.menu-toggle' ).css( 'display' ) ) {

				$( document.body ).on( 'touchstart.nimble', function( e ) {
					if ( ! $( e.target ).closest( '.main-navigation li' ).length ) {
						$( '.main-navigation li' ).removeClass( 'focus' );
					}
				});

				siteNavigation.find( '.menu-item-has-children > a, .page_item_has_children > a' )
					.on( 'touchstart.nimble', function( e ) {
						var el = $( this ).parent( 'li' );

						if ( ! el.hasClass( 'focus' ) ) {
							e.preventDefault();
							el.toggleClass( 'focus' );
							el.siblings( '.focus' ).removeClass( 'focus' );
						}
					});

			} else {
				siteNavigation.find( '.menu-item-has-children > a, .page_item_has_children > a' ).unbind( 'touchstart.nimble' );
			}
		}

		if ( 'ontouchstart' in window ) {
			$( window ).on( 'resize.nimble', toggleFocusClassTouchScreen );
			toggleFocusClassTouchScreen();
		}

		siteNavigation.find( 'a' ).on( 'focus.nimble blur.nimble', function() {
			$( this ).parents( '.menu-item, .page_item' ).toggleClass( 'focus' );
		});
	})();
})( jQuery );
