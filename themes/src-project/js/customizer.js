/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( newVal ) {
			$( '.site-title a' ).text( newVal );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( newVal ) {
			$( '.site-description' ).text( newVal );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( newVal ) {
			if ( 'blank' === newVal ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title a, .site-description' ).css( {
					'color': newVal
				} );
			}
		} );
	} );

  //TODO Second Logo (SRC)
	wp.customize( 'second_logo', function(value){
		value.bind( function( newVal ){
			//use the image id to find its source and alt attrib

		});
	});

	//TODO Homepage Hero image
	wp.customize( 'current_festival_hero_image', function(value){
		value.bind( function( newVal ){
			//use the image id to find its source and alt attrib

		});
	});

	//Festival dates
	//See https://codex.wordpress.org/Theme_Customization_API#Part_3:_Configure_Live_Preview_.28Optional.29
	wp.customize( 'current_festival_dates', function( value ) {
		value.bind( function( newVal ) {
			$( '.festival-dates' ).text( newVal );
		} );
	} );

	// Text color.
	wp.customize( 'current_festival_text_color', function( value ) {
		value.bind( function( newVal ) {
			if ( 'blank' != newVal ) {
				$( 'body, input, select, optgroup, .site-footer, .site-footer a, .site-footer label, .site-footer .widget-title' ).css( {
					'color': newVal,
				} );
				$( '.site-footer #es_txt_button' ).css( {
					'color': '#FFF'
				} );
			}
		} );
	} );

	// Menu color.
	wp.customize( 'current_festival_menu_color', function( value ) {
		value.bind( function( newVal ) {
			if ( 'blank' != newVal ) {
				$( '.main-navigation a, #hero .site-title, .single-event_cpt .entry-content, .site-footer .es_caption' ).css( {
					'color': newVal,
				} );
				$( '.search-bttn svg.icon' ).css( {
					'fill': newVal,
				} );
				$('input[type="submit"], .site-footer #es_txt_button, button').css( {
					'border-color':newVal,
					'background-color': newVal,
				} );
				$('#programme .links a, .single-event_cpt .links a').css( {
					'background-color': newVal,
				} );
			}
		} );
	} );

	// Accent color.
	wp.customize( 'current_festival_accent_color', function( value ) {
		value.bind( function( newVal ) {
			if ( 'blank' != newVal ) {
				$( '.main-navigation .current_page_item > a, body[class*="page-whats-"] .event-header, .single-event_cpt .entry-header, body:not(.home) .site-main #programme' ).css( {
					'border-color': newVal,
				} );
				$( '#hero .site-description, #hero .festival-dates, .single-event_cpt article .right-column .subcolumn-B ').css( {
					'color': newVal,
				} );
				$( 'input[type="text"], input[type="email"], input[type="search"], .social-navigation a ' ).css( {
					'background-color': newVal,
					'border-color': newVal,
				} );
			}
		} );
	} );

} )( jQuery );
