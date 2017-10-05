<?php
/**
 * Studio Pro.
 *
 * This file adds custom widget areas to the Studio Pro theme.
 *
 * @package      Studio Pro
 * @link         https://seothemes.net/studio-pro
 * @author       Seo Themes
 * @copyright    Copyright © 2017 Seo Themes
 * @license      GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Register before header widget area.
genesis_register_sidebar( array(
	'id'          => 'before-header',
	'name'        => __( 'Before Header', 'studio-pro' ),
	'description' => __( 'This is the before header section.', 'studio-pro' ),
) );

// Register header-right widget area.
genesis_register_sidebar( array(
	'id'          => 'header-right',
	'name'        => __( 'Header Right', 'studio-pro' ),
	'description' => __( 'This is the header right section.', 'studio-pro' ),
) );

// Register header-right widget area.
genesis_register_sidebar( array(
	'id'          => 'sidebar',
	'name'        => __( 'Sidebar', 'studio-pro' ),
	'description' => __( 'This is the sidebar section.', 'studio-pro' ),
) );

// Register before footer widget area.
genesis_register_sidebar( array(
	'id'          => 'before-footer',
	'name'        => __( 'Before Footer', 'studio-pro' ),
	'description' => __( 'This is the before footer section.', 'studio-pro' ),
) );

/**
 * Display before-header widget area.
 */
function studio_before_header_widget_area() {

	genesis_widget_area( 'before-header', array(
	    'before' => '<div class="before-header"><div class="wrap">',
	    'after'	 => '</div></div>',
	) );
}
add_action( 'genesis_header', 'studio_before_header_widget_area', 5 );

/**
 * Display before-footer widget area.
 */
function studio_before_footer_widget_area() {

	genesis_widget_area( 'before-footer', array(
	    'before' => '<div class="before-footer overlay">',
	    'after'  => '</div>',
	) );
}
add_action( 'genesis_before_footer', 'studio_before_footer_widget_area', 5 );

/**
 * Dynamic footer widget areas.
 *
 * If using the Customizer, register some extra widget areas so that
 * the amount can be dynamically changed without having to save and
 * refresh the entire window. The `$count_footer_widgets` conditional
 * variable assumes that the maximum amount of footer widgets ever
 * needed is 12. The default number of footer widget areas is 3.
 */
$count_footer_widgets = is_customize_preview() ? 12 : get_option( 'studio_footer_widgets', 3 );

// Register dynamic footer widget areas.
for ( $i = 1; $i <= $count_footer_widgets; $i++ ) {
	genesis_register_sidebar( array(
		'id'          => 'footer-widget-' . $i,
		'name'        => __( 'Footer Widget ', 'studio-pro' ) . $i,
		'description' => __( 'This is the footer widget ', 'studio-pro' ) . $i . __( ' widget area.', 'studio-pro' ),
	) );
}

/**
 * Display footer widget areas.
 *
 * @var $widget_areas Number of footer widget areas.
 */
function studio_footer_widgets() {
	$widget_areas = get_option( 'studio_footer_widgets', 3 );

	// Return early if no footer widget areas.
	if ( '0' === $widget_areas ) {
		return;
	}
	// Opening markup with custom wrap.
	echo '<div class="footer-widgets"><div class="wrap">';

	// Loop through widget areas.
	for ( $i = 1; $i <= $widget_areas; $i++ ) {
		genesis_widget_area( "footer-widget-$i", array(
			'before' => sprintf( '<div class="widget-area footer-widgets-%s">', $i ),
			'after'  => '</div>',
		) );
	}

	// Closing markup.
	echo '</div></div>';
}
add_action( 'genesis_footer', 'studio_footer_widgets', 5 );

/**
 * Dynamic front-page widget areas.
 *
 * Using the same technique as above for registering additional front page
 * widget areas that can be dynamically set in the Customizer, assuming the
 * maximum amount of front page widgets is 24 with the default set to 6.
 */
$count_front_page_widgets = is_customize_preview() ? 24 : get_option( 'studio_front_page_widgets', 6 );

// Register dynamic front page widget areas.
for ( $i = 1; $i <= $count_front_page_widgets; $i++ ) {
	genesis_register_sidebar( array(
		'id'          => 'front-page-' . $i,
		'name'        => __( 'Front Page ', 'studio-pro' ) . $i,
		'description' => __( 'This is the front page ', 'studio-pro' ) . $i . __( ' widget area.', 'studio-pro' ),
	) );
}
