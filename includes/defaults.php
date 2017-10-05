<?php
/**
 * Studio Pro.
 *
 * This file registers the required plugins for the Studio Pro theme.
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

/**
 * Update Theme Settings upon reset.
 *
 * @param  array $defaults Default theme settings.
 * @return array Custom theme settings.
 */
function studio_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 12;
	$defaults['content_archive']           = 'excerpt';
	$defaults['content_archive_limit']     = 300;
	$defaults['content_archive_thumbnail'] = 1;
	$defaults['image_alignment']           = 'alignnone';
	$defaults['posts_nav']                 = 'numeric';
	$defaults['image_size']                = 'large';
	$defaults['site_layout']               = 'full-width-content';

	return $defaults;

}
add_filter( 'genesis_theme_settings_defaults', 'studio_theme_defaults' );

/**
 * Update Theme Settings upon activation.
 */
function studio_theme_setting_defaults() {

	if ( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 12,
			'content_archive'           => 'excerpt',
			'content_archive_limit'     => 300,
			'content_archive_thumbnail' => 1,
			'image_alignment'           => 'alignnone',
			'image_size'                => 'large',
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'full-width-content',
		) );
	}

	update_option( 'posts_per_page', 8 );

}
add_action( 'after_switch_theme', 'studio_theme_setting_defaults' );

/**
 * Set portfolio image size to override plugin.
 */
add_image_size( 'portfolio', 620, 380, true );

/**
 * Starter Pro Simple Social Icon Defaults.

 * @param  array $defaults Default Simple Social Icons settings.
 * @return array Custom settings.
 */
function studio_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'alignleft',
		'background_color'       => '#555555',
		'background_color_hover' => '#999999',
		'border_radius'          => 0,
		'border_color'           => '#ffffff',
		'border_color_hover'     => '#ffffff',
		'border_width'           => 0,
		'icon_color'             => '#ffffff',
		'icon_color_hover'       => '#ffffff',
		'size'                   => 32,
		'new_window'             => 1,
		'facebook'               => '#',
		'gplus'                  => '#',
		'instagram'              => '#',
		'pinterest'              => '#',
		'twitter'                => '#',
		'youtube'                => '#',
	);
	$args = wp_parse_args( $args, $defaults );

	return $args;

}
add_filter( 'simple_social_default_styles', 'studio_social_default_styles' );
