<?php
/**
 * Studio Pro.
 *
 * This file adds customizer settings to the Studio Pro theme.
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

// Add theme customizer colors here.
$studio_colors = array(
	'button' 		 => '#2A2B33',
	'gradient_left'  => '#7A28FF',
	'gradient_right' => '#00A1FF',
);

/**
 * Sets up the theme customizer sections, controls, and settings.
 *
 * @access public
 * @param  object $wp_customize Global customizer object.
 * @return void
 */
function studio_customize_register( $wp_customize ) {

	// Globals.
	global $wp_customize, $studio_colors;

	// Enable live preview for WordPress core theme features.
	$wp_customize->get_setting( 'blogname' )->transport              = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport       = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport      = 'postMessage';
	$wp_customize->get_setting( 'header_image' )->transport          = 'postMessage';
	$wp_customize->get_setting( 'background_color' )->transport      = 'postMessage';
	$wp_customize->get_setting( 'background_image' )->transport      = 'postMessage';
	$wp_customize->get_setting( 'background_position_x' )->transport = 'postMessage';
	$wp_customize->get_setting( 'background_repeat' )->transport     = 'postMessage';
	$wp_customize->get_setting( 'background_attachment' )->transport = 'postMessage';

	// Enable selective refresh for site title and description.
	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector'        => '.site-title',
		'render_callback' => 'studio_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector'        => '.site-description',
		'render_callback' => 'studio_customize_partial_blogdescription',
	) );

	/**
	 * Custom colors.
	 *
	 * Loop through the global variable array of colors and
	 * register a customizer setting and control for each.
	 * To add additional color settings, do not modify this
	 * function, instead add your color name and hex value to
	 * the $studio_colors` array at the start of this file.
	 */
	foreach ( $studio_colors as $id => $hex ) {

		// Format ID and label.
		$setting = "studio_{$id}_color";
		$label	 = ucwords( str_replace( '_', ' ', $id ) ) . __( ' Color', 'studio-pro' );

		// Add color setting.
		$wp_customize->add_setting(
			$setting,
			array(
				'default'           => $hex,
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'			=> 'postMessage',
			)
		);

		// Add color control.
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$setting,
				array(
					'section'  => 'colors',
					'label'    => $label,
					'settings' => $setting,
				)
			)
		);
	}

	/**
	 * Front Page Content.
	 *
	 * Adds the Front Page Content setting and control to the Static
	 * Front Page section section of the customizer. This allows the
	 * user to easily show or hide the front page content.
	 */
	$wp_customize->add_setting(
		'studio_front_page_content',
		array(
		    'default'           => 'false',
		    'type'              => 'option',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'studio_front_page_content',
		array(
			'label'       => __( 'Front Page Content', 'studio-pro' ),
			'description' => __( 'Show or hide the front page content.', 'studio-pro' ),
			'section'     => 'static_front_page',
			'settings'    => 'studio_front_page_content',
			'type'        => 'radio',
			'choices'     => array(
				'true'    => __( 'Show content', 'studio-pro' ),
				'false'   => __( 'Hide content', 'studio-pro' ),
			),
	    )
	);

	/**
	 * Front page widget areas.
	 *
	 * Adds the Front Page Widget Areas setting and control to the
	 * Static Front Page section of the customizer. This allows the
	 * user to select the number of widget areas to display on the
	 * home page of their site.
	 */
	$wp_customize->add_setting(
		'studio_front_page_widgets',
		array(
			'default'           => 6,
			'sanitize_callback' => 'sanitize_text_field',
			'type'				=> 'option',
			'transport'   		=> 'refresh',
		)
	);
	$wp_customize->add_control(
		'studio_front_page_widgets',
		array(
			'type'		  => 'number',
			'label'       => __( 'Front Page Widget Areas', 'studio-pro' ),
			'description' => __( 'Select the number of widget areas to display on the home page.', 'studio-pro' ),
			'section'     => 'static_front_page',
			'settings'    => 'studio_front_page_widgets',
		)
	);

	/**
	 * Footer widget areas.
	 *
	 * Adds the Footer Widget Areas setting and control to the
	 * Site Layout section of the customizer. This allows the user
	 * to select the number of widget areas to display in the footer
	 * section of their site.
	 */
	$wp_customize->add_setting(
		'studio_footer_widgets',
		array(
			'default'           => 3,
			'sanitize_callback' => 'sanitize_text_field',
			'type'				=> 'option',
			'transport'   		=> 'refresh',
		)
	);
	$wp_customize->add_control(
		'studio_footer_widgets',
		array(
			'type'		  => 'number',
			'label'       => __( 'Footer Widget Areas', 'studio-pro' ),
			'description' => __( 'Select the number of widget areas to display in the footer section.', 'studio-pro' ),
			'section'     => 'genesis_layout',
			'settings'    => 'studio_footer_widgets',
			'priority'	  => 20,
		)
	);
}
add_action( 'customize_register', 'studio_customize_register' );

/**
 * Preview customizer colors.
 *
 * This function enables postMessage support for the customizer
 * colors. First it outputs two divs containing the existing theme
 * mod values which can then be accessed by the customizer JS.
 * Then we output empty style blocks which are modified by the
 * postMessage functions when the custom colors are changed.
 */
function studio_gradient_customizer_styles() {

	// Add in Customizer Only (style tag placeholder for gradient color).
	global $wp_customize, $studio_colors;

	if ( isset( $wp_customize ) ) {
		echo '<div id="studio_gradient_left" data-color="' . esc_attr( get_theme_mod( 'studio_gradient_left_color', $studio_colors['gradient_left'] ) ) . '"></div>';
		echo '<div id="studio_gradient_right" data-color="' . esc_attr( get_theme_mod( 'studio_gradient_right_color', $studio_colors['gradient_right'] ) ) . '"></div>';
	    echo '<style type="text/css" id="button-css"></style>';
		echo '<style type="text/css" id="gradient-css"></style>';
	}
}
add_action( 'wp_head', 'studio_gradient_customizer_styles' );

/**
 * Customizer inline CSS.
 *
 * This function adds some styles to the WordPress Customizer to
 * hide the first paragraph of the Widgets panel notice. Because
 * of the dynamic widget areas, it displays an incorrect number
 * of available widget areas. The simplest way to fix this is to
 * just hide the number, it's not needed anyway.
 */
function my_customizer_styles() {
	$css = '
		.no-widget-areas-rendered-notice p:nth-of-type(1) {
			display: none !important;
		}
		.no-widget-areas-rendered-notice p:nth-of-type(2) {
			margin-top: 0 !important;
		}
	';
	printf( '<style>%s</style>', studio_minify_css( $css ) );
}
add_action( 'customize_controls_print_styles', 'my_customizer_styles', 999 );

/**
 * Customizer JavaScript file.
 *
 * Loads the custom scripts used to add the postMessage functions
 * to WordPress core customizer settings and also the color settings
 * defined by the theme. Without this, live preview will not work.
 *
 * @access public
 * @return void
 */
function studio_enqueue_customizer_scripts() {
	wp_enqueue_script( 'studio-customize', get_stylesheet_directory_uri() . '/assets/scripts/min/customize.min.js', array( 'jquery' ), null, true );
}
add_action( 'customize_preview_init', 'studio_enqueue_customizer_scripts' );
