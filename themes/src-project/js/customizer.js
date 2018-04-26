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

	//Festival dates
	//See https://codex.wordpress.org/Theme_Customization_API#Part_3:_Configure_Live_Preview_.28Optional.29
	wp.customize( 'current_festival_dates', function( value ) {
		value.bind( function( newval ) {
			$( '.festival-dates' ).text( newval );
		} );
	} );

	// Text color.
	wp.customize( 'current_festival_text_color', function( value ) {
		value.bind( function( newval ) {
			console.log(newVal);
			if ( 'blank' != newval ) {
				$( '.main-navigation a, #hero .site-title' ).css( {
					'color': newval
				} );
				$( 'svg.icon' ).css( {
					'fill': newval
				} );
			}
		} );
	} );

	// Menu color.
	wp.customize( 'current_festival_menu_color', function( value ) {
		value.bind( function( newval ) {
			console.log(newVal);
			if ( 'blank' != newval ) {
				$( '.main-navigation a, #hero .site-title' ).css( {
					'color': newval
				} );
				$( 'svg.icon' ).css( {
					'fill': newval
				} );
			}
		} );
	} );

	// Accent color.
	wp.customize( 'current_festival_accent_color', function( value ) {
		value.bind( function( newval ) {
			console.log(newVal);
			if ( 'blank' != newval ) {
				$( '.main-navigation a, #hero .site-title' ).css( {
					'color': newval
				} );
				$( 'svg.icon' ).css( {
					'fill': newval
				} );
			}
		} );
	} );

} )( jQuery );
