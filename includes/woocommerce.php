<?php
/**
 * Studio Pro.
 *
 * This file adds WooCommerce specific functionality for this theme.
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

// If WooCommerce is not active, exit.
if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

// Remove Single Product title.
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );

// Remove short description.
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );

// Remove the default product tabs.
remove_filter( 'woocommerce_product_tabs', 'woocommerce_default_product_tabs' );

// Add custom product description.
add_action( 'woocommerce_single_product_summary', 'studio_custom_product_description', 5 );

// Modify the default product tabs.
add_filter( 'woocommerce_product_tabs', 'studio_default_product_tabs' );

/**
 * Custom product description.
 *
 * Since the product short description is being used as the page subtitle,
 * move the full description to the short description area on the left hand
 * side of the product image.
 */
function studio_custom_product_description() {
	printf( '<div class="product-description">%s</div>', the_content() );
}

/**
 * Modify default product tabs.
 *
 * Remove the product description from the product tabs area. Currently
 * the only way to remove it is to overwrite the default product tabs.
 *
 * @param array $tabs Custom tabs.
 * @return array
 */
function studio_default_product_tabs( $tabs = array() ) {

	// Globals.
	global $product, $post;

	// Additional information tab.
	if ( $product && ( $product->has_attributes() || ( $product->has_dimensions() || $product->has_weight() ) ) ) {
	    $tabs['additional_information'] = array(
	        'title'    => __( 'Additional Information', 'studio-pro' ),
	        'priority' => 20,
	        'callback' => 'woocommerce_product_additional_information_tab',
	    );
	}

	// Reviews tab - shows comments.
	if ( comments_open() ) {
	    $tabs['reviews'] = array(
			/* Translators: The total number of reviews for the product. */
	        'title'    => sprintf( __( 'Reviews (%d)', 'studio-pro' ), $product->get_review_count() ),
	        'priority' => 30,
	        'callback' => 'comments_template',
	    );
	}
	return $tabs;
}
