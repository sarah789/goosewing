<?php
/**
 * Studio Pro.
 *
 * This file contains theme-specific functions for the Studio Pro theme.
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
 * Remove Page Templates.
 *
 * The Genesis Blog & Archive templates are not needed and can
 * create problems for users so it's safe to remove them. If
 * you need to use these templates, simply remove this function.
 *
 * @param  array $page_templates All page templates.
 * @return array Modified templates.
 */
function studio_remove_templates( $page_templates ) {
	unset( $page_templates['page_archive.php'] );
	unset( $page_templates['page_blog.php'] );
	return $page_templates;
}

/**
 * Remove blog metabox.
 *
 * Also remove the Genesis blog settings metabox from the
 * Genesis admin settings screen as it is no longer required
 * if the Blog page template has been removed.
 *
 * @param string $hook The metabox hook.
 */
function studio_remove_metaboxes( $hook ) {
	remove_meta_box( 'genesis-theme-settings-blogpage', $hook, 'main' );
}

/**
 * Custom opening wrap.
 *
 * Used for entry-header, entry-content and entry-footer.
 * Genesis doesn't provide structural wraps for these elements
 * so we need to hook in and add the wrap div at the start.
 * This is a utility function that can be used anywhere to open
 * a wrap anywhere in your theme.
 */
function studio_wrap_open() {
	echo '<div class="wrap">';
}

/**
 * Custom closing wrap.
 *
 * The closing markup for the additional opening wrap divs,
 * simply closes the wrap divs that we created earlier. This
 * is a utility function that can be used anywhere to close
 * any kind of div, not just wraps.
 */
function studio_wrap_close() {
	echo '</div>';
}

/**
 * Render the site title for the selective refresh partial.
 *
 * @see studio_customize_register()
 * @return void
 */
function studio_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @see studio_customize_register()
 * @return void
 */
function studio_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Add no-js class to body.
 *
 * Used for checking whether or not JavaScript is active so we can
 * style the navigation menus to suit the user. Also add an empty
 * `ontouchstart` attribute which emulates hover effects on mobile.
 *
 * @param  string $attr On touch start attribute.
 * @return string
 */
function studio_add_ontouchstart( $attr ) {
	$attr['class'] 		  .= ' no-js';
	$attr['ontouchstart']  = ' ';
	return $attr;
}

/**
 * Add schema microdata to title-area.
 *
 * @since 1.5.0
 * @param  array $args Array of arguments.
 * @return array $args Additional arguments.
 */
function studio_title_area( $args ) {
	$args['itemscope'] = 'itemscope';
	$args['itemtype']  = 'http://schema.org/Organization';
	return $args;
}

/**
 * Correct site-title schema microdata.
 *
 * @since 1.5.0
 * @param  array $args Array of arguments.
 * @return array $args New arguments.
 */
function studio_site_title( $args ) {
	$args['itemprop'] = 'name';
	return $args;
}

/**
 * Modify breadcrumb arguments.
 *
 * @param  array $args Original breadcrumb args.
 * @return array Cleaned breadcrumbs.
 */
function studio_breadcrumb_args( $args ) {
	$args['prefix']              = '<div class="breadcrumb" itemscope="" itemtype="https://schema.org/BreadcrumbList"><div class="wrap">';
	$args['suffix']              = '</div></div>';
	$args['labels']['prefix']    = '';
	$args['labels']['author']    = '';
	$args['labels']['category']  = '';
	$args['labels']['tag']       = '';
	$args['labels']['date']      = '';
	$args['labels']['tax']       = '';
	$args['labels']['post_type'] = '';
	return $args;
}

/**
 * Accessible read more link.
 *
 * The below code modifies the default read more link when
 * using the WordPress More Tag to break a post on your site.
 * Instead of seeing 'Read more', screen readers will instead
 * see 'Read more about (entry title)'.
 */
function studio_read_more() {
	return sprintf( '&hellip; <a href="%s" class="more-link">%s</a>',
		get_the_permalink(),
		genesis_a11y_more_link( __( 'Read more', 'studio-pro' ) )
	);
}

/**
 * Enable prev/next links in portfolio.
 */
function studio_prev_next_post_nav_cpt() {

	if ( ! is_singular( 'portfolio' ) && ! is_singular( 'product' ) ) {
		return;
	}

	genesis_markup( array(
		'html5'   => '<div %s><div class="wrap">',
		'xhtml'   => '<div class="navigation">',
		'context' => 'adjacent-entry-pagination',
	) );

		echo '<div class="pagination-previous alignleft">';
			previous_post_link();
		echo '</div>';
		echo '<div class="pagination-next alignright">';
			next_post_link();
		echo '</div>';
	echo '</div></div>';
}

/**
 * Display featured image before post content on blog.
 *
 * @return array Featured image size.
 */
function studio_display_featured_image() {

	// Check display featured image option.
	$genesis_settings = get_option( 'genesis-settings' );

	if ( ( ! is_archive() && ! is_home() && ! is_page_template( 'blog-masonry.php' ) ) || ( 1 !== $genesis_settings['content_archive_thumbnail'] ) ) {
		return;
	}

	// Display featured image.
	add_action( 'genesis_entry_header', 'genesis_do_post_image', 1 );
}

/**
 * Change the footer text.
 *
 * @since 1.5.0
 * @param  string $creds Defaults.
 * @return string Custom footer credits.
 */
function studio_footer_creds_filter( $creds ) {
	$creds = '[footer_copyright] Goosewing Digital';
	return $creds;
}

/**
 * Custom header image callback.
 *
 * Loads image or video depending on what is set.
 * If a featured image is set it will override the
 * header image. If a video is set it will be used
 * on the home page only.
 *
 * @since 1.5.0
 */
function studio_custom_header() {

	// Get the featured image if one is set.
	if ( get_the_post_thumbnail_url() ) {

		$image = '';

		if ( class_exists( 'WooCommerce' ) && is_shop() ) {

			$image = get_the_post_thumbnail_url( get_option( 'woocommerce_shop_page_id' ) );

			if ( ! $image ) {
				$image = get_header_image();
			}
		} elseif ( is_home() ) {

			$image = get_the_post_thumbnail_url( get_option( 'page_for_posts' ) );

			if ( ! $image ) {
				$image = get_header_image();
			}
		} elseif ( is_archive() || is_category() || is_tag() || is_tax() || is_home() ) {
			$image = get_header_image();

		} else {
			$image = get_the_post_thumbnail_url();

		}
	} elseif ( has_header_image() ) {
		$image = get_header_image();

	}

	if ( ! empty( $image ) ) {
		printf( '<style>.hero-section,.before-footer{ background-image:url(%s);}</style>', esc_url( $image ) );
	}
}

/**
 * Minify CSS helper function.
 *
 * A handy CSS minification script by Gary Jones that we'll use to
 * minify the CSS output by the customizer. This is called near the
 * end of the /includes/customizer-output.php file.
 *
 * @author Gary Jones
 * @link https://github.com/GaryJones/Simple-PHP-CSS-Minification
 * @param string $css The CSS to minify.
 * @return string Minified CSS.
 */
function studio_minify_css( $css ) {

	// Normalize whitespace.
	$css = preg_replace( '/\s+/', ' ', $css );

	// Remove spaces before and after comment.
	$css = preg_replace( '/(\s+)(\/\*(.*?)\*\/)(\s+)/', '$2', $css );

	// Remove comment blocks, everything between /* and */, unless preserved with /*! ... */ or /** ... */.
	$css = preg_replace( '~/\*(?![\!|\*])(.*?)\*/~', '', $css );

	// Remove ; before }.
	$css = preg_replace( '/;(?=\s*})/', '', $css );

	// Remove space after , : ; { } */ >.
	$css = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $css );

	// Remove space before , ; { } ( ) >.
	$css = preg_replace( '/ (,|;|\{|}|\(|\)|>)/', '$1', $css );

	// Strips leading 0 on decimal values (converts 0.5px into .5px).
	$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );

	// Strips units if value is 0 (converts 0px to 0).
	$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

	// Converts all zeros value into short-hand.
	$css = preg_replace( '/0 0 0 0/', '0', $css );

	// Shorten 6-character hex color codes to 3-character where possible.
	$css = preg_replace( '/#([a-f0-9])\\1([a-f0-9])\\2([a-f0-9])\\3/i', '#\1\2\3', $css );

	return trim( $css );
}
