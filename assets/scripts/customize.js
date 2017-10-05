/**
 * Handles the customizer live preview settings.
 */
jQuery( document ).ready( function() {

	/*
	 * Shows a live preview of changing the site title.
	 */
	wp.customize( 'blogname', function( value ) {

		value.bind( function( to ) {

			jQuery( '.site-title a' ).html( to );

		} ); // value.bind

	} ); // wp.customize

	/*
	 * Shows a live preview of changing the site description.
	 */
	wp.customize( 'blogdescription', function( value ) {

		value.bind( function( to ) {

			jQuery( '.site-description' ).html( to );

		} ); // value.bind

	} ); // wp.customize

	/*
	 * Handles the header textcolor.  This code also accounts for the possibility that the header text color
	 * may be set to 'blank', in which case, any text in the header is hidden.
	 */
	wp.customize( 'header_textcolor', function( value ) {

		value.bind( function( to ) {

			/* If set to 'blank', hide the branding section and secondary menu. */
			if ( 'blank' === to ) {

				/* Hides branding and menu-secondary. */
				jQuery( '.site-title, .site-description' ).
					css( 'display', 'none' );

			}

			/* Change the header and secondary menu colors. */
			else {

				/* Makes sures both branding and menu-secondary display. */
				jQuery( '.site-title, .site-description' ).
					css( 'display', 'block' );

				/* Changes the color of the site title link. */
				jQuery( '.site-title a, .site-description' ).
					css( 'color', to );
			} // endif

		} ); // value.bind

	} ); // wp.customize

	/*
	 * Handes the header image.  This code replaces the "src" attribute for the image.
	 */
	wp.customize( 'header_image', function( value ) {

		value.bind( function( to ) {

			/* If removing the header image, make sure to hide it so there's not an error image. */
			if ( 'remove-header' === to ) {
				jQuery( '.wp-custom-header img' ).hide();
				jQuery( '.wp-custom-header video' ).hide();
			}

			/* Else, make sure to show the image and change the source. */
			else {
				jQuery( '.wp-custom-header img' ).show();
				jQuery( '.wp-custom-header img' ).attr( 'src', to );
				jQuery( '.wp-custom-header video' ).show();
				jQuery( '.wp-custom-header video' ).attr( 'src', to );
			}

		} ); // value.bind

	} ); // wp.customize

	// Get gradient theme mods.
	left  = jQuery( '#studio_gradient_left' ).attr( 'data-color' );
	right = jQuery( '#studio_gradient_right' ).attr( 'data-color' );

	/**
	 * Left gradient color.
	 */
	wp.customize( 'studio_gradient_left_color', function( value ) {

		value.bind( function( to ) {

			left = to;

			var gradient = '.overlay:after, button.gradient, input[type="button"].gradient, input[type="reset"].gradient, input[type="submit"].gradient, .button.gradient, .footer-widgets .enews-widget input[type="submit"], .widget-row.title:after, .front-page-3 .listing-item:after, .front-page-5 .widget-title:after, i.circle.gradient, .pricing-table .featured button, .pricing-table .featured .button {' +
				'background:' + to +  ';' +
				'background: -moz-linear-gradient(left,' + to + ' 0%, ' + right + ' 100%);' +
				'background: -webkit-linear-gradient(left,' + to + ' 0%, ' + right + '  100%);' +
				'background: linear-gradient(to right,' + to + ' 0%, ' + right + '  100%);' +
				'filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=' + to + ', endColorstr="' + right + '",GradientType=1 );' +
			'}' +
			'i.gradient, .genesis-nav-menu a:hover, .genesis-nav-menu a:focus, .genesis-nav-menu .current-menu-item > a, .genesis-nav-menu .sub-menu .current-menu-item > a:hover, .genesis-nav-menu .sub-menu .current-menu-item > a:focus {' +
				'background:' + to +
				'background: -moz-linear-gradient(left,' + to + ' 0%, ' + right + ' 100%);' +
				'background: -webkit-linear-gradient(left,' + to + ' 0%, ' + right + '  100%);' +
				'background: linear-gradient(to right,' + to + ' 0%, ' + right + '  100%);' +
				'filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=' + to + ', endColorstr="' + right + '",GradientType=1 );' +
				'-webkit-background-clip: text;' +
				'background-clip: text;' +
				'-webkit-text-fill-color: transparent;' +
				'text-fill-color: transparent;' +
			'}';
			jQuery( '#gradient-css' ).html( gradient );

		} ); // value.bind
	} ); // wp.customize

	/**
	 * Right gradient color.
	 */
	wp.customize( 'studio_gradient_right_color', function( value ) {

		value.bind( function( to ) {

			right = to;

			var gradient = '.overlay:after, button.gradient, input[type="button"].gradient, input[type="reset"].gradient, input[type="submit"].gradient, .button.gradient, .footer-widgets .enews-widget input[type="submit"], .widget-row.title:after, .front-page-3 .listing-item:after, .front-page-5 .widget-title:after, i.circle.gradient, .pricing-table .featured button, .pricing-table .featured .button {' +
				'background:' + left + ';' +
				'background: -moz-linear-gradient(left,' + left + ' 0%, ' + to + ' 100%);' +
				'background: -webkit-linear-gradient(left,' + left + ' 0%, ' + to + '  100%);' +
				'background: linear-gradient(to right,' + left + ' 0%, ' + to + '  100%);' +
				'filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=' + left + ', endColorstr="' + to + '",GradientType=1 );' +
			'}' +
			'i.gradient, .genesis-nav-menu a:hover, .genesis-nav-menu a:focus, .genesis-nav-menu .current-menu-item > a, .genesis-nav-menu .sub-menu .current-menu-item > a:hover, .genesis-nav-menu .sub-menu .current-menu-item > a:focus {' +
				'background:' + left +
				'background: -moz-linear-gradient(left,' + left + ' 0%, ' + to + ' 100%);' +
				'background: -webkit-linear-gradient(left,' + left + ' 0%, ' + to + '  100%);' +
				'background: linear-gradient(to right,' + left + ' 0%, ' + to + '  100%);' +
				'filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=' + left + ', endColorstr="' + to + '",GradientType=1 );' +
				'-webkit-background-clip: text;' +
				'background-clip: text;' +
				'-webkit-text-fill-color: transparent;' +
				'text-fill-color: transparent;' +
			'}';
			jQuery( '#gradient-css' ).html( gradient );

		} ); // value.bind

	} ); // wp.customize

	/**
	 * Button color.
	 */
	wp.customize( 'studio_button_color', function( value ) {

		value.bind( function( to ) {

			var button = 'button, input[type="button"], input[type="reset"], input[type="submit"], .button, archive-pagination .active a, .woocommerce a.button, .woocommerce a.button.alt, .woocommerce button.button, .woocommerce button.button.alt, .woocommerce input.button, .woocommerce input.button.alt, .woocommerce input[type="submit"], .woocommerce span.onsale, .woocommerce #respond input#submit, .woocommerce #respond input#submit.alt, .woocommerce input.button[type=submit], .woocommerce.widget_price_filter .ui-slidui-slider-handle, .woocommerce.widget_price_filter .ui-slidui-slider-range, button.secondary:hover, .button.secondary:hover, .archive-pagination a:hover, .woocommerce a.button:hover, .woocommerce a.button.alt:hover, .woocommerce button.button:hover, .woocommerce button.button.alt:hover, .woocommerce input.button:hover, .woocommerce input.button.alt:hover, .woocommerce input[type="submit"]:hover, .woocommerce #respond input#submit:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce input.button[type=submit]:hover, button.secondary:focus, .button.secondary:focus, .archive-pagination a:focus, .woocommerce a.button:focus, .woocommerce a.button.alt:focus, .woocommerce button.button:focus, .woocommerce button.button.alt:focus, .woocommerce input.button:focus, .woocommerce input.button.alt:focus, .woocommerce input[type="submit"]:focus, .woocommerce #respond input#submit:focus, .woocommerce #respond input#submit.alt:focus, .woocommerce input.button[type=submit]:focus{' +
				'background-color: ' + to + ';' +
			'}';
			jQuery( '#button-css' ).html( button );

		} ); // value.bind

	} ); // wp.customize

} ); // jQuery( document ).ready