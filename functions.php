<?php
/**
 * Studio Pro.
 *
 * This file adds the default functionality to the Studio Pro theme.
 *
 * @package      Studio Pro
 * @link         https://seothemes.net/studio-pro
 * @author       Seo Themes
 * @copyright    Copyright © 2017 Seo Themes
 * @license      GPL-2.0+
 */

// Start the engine (do not remove).
include_once( get_template_directory() . '/lib/init.php' );

// Set Localization (do not remove).
load_child_theme_textdomain( 'studio-pro', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'studio-pro' ) );

// Child theme (do not remove).
define( 'CHILD_THEME_NAME', 'studio-pro' );
define( 'CHILD_THEME_URL', 'http://www.seothemes.net/' );
define( 'CHILD_THEME_VERSION', '2.0.1' );

// Enable responsive viewport.
add_theme_support( 'genesis-responsive-viewport' );

// Enable automatic output of WordPress title tags.
add_theme_support( 'title-tag' );

// Enable selective refresh and Customizer edit icons.
add_theme_support( 'customize-selective-refresh-widgets' );

// Enable HTML5 markup structure.
add_theme_support( 'html5', array(
	'caption',
	'comment-form',
	'comment-list',
	'gallery',
	'search-form',
) );

// Enable Accessibility support.
add_theme_support( 'genesis-accessibility', array(
	'404-page',
	'drop-down-menu',
	'headings',
	'rems',
	'search-form',
	'skip-links',
) );

// Rename primary and secondary navigation menus.
add_theme_support( 'genesis-menus' , array(
	'primary' => __( 'Header Menu', 'studio-pro' ),
) );

// Enable menu wrap only, using custom wraps for everything else.
add_theme_support( 'genesis-structural-wraps', array(
	'menu-primary',
) );

// Enable Logo option in Customizer > Site Identity.
add_theme_support( 'custom-logo', array(
	'height'      => 60,
	'width'       => 200,
	'flex-height' => true,
	'flex-width'  => true,
	'header-text' => array( '.site-title', '.site-description' ),
) );

// Enable theme support for custom header background image.
add_theme_support( 'custom-header', array(
	'header-selector'  => '.hero',
	'header_image'     => get_stylesheet_directory_uri() . '/assets/images/hero.jpg',
	'header-text'      => false,
	'width'            => 1920,
	'height'           => 1080,
	'flex-height'      => true,
	'flex-width'       => true,
	'video'            => true,
	'wp-head-callback' => 'studio_custom_header',
) );

// Enable WooCommerce support.
add_theme_support( 'woocommerce' );

// Register default custom header image.
register_default_headers( array(
	'child' => array(
		'url'           => '%2$s/assets/images/hero.jpg',
		'thumbnail_url' => '%2$s/assets/images/hero.jpg',
		'description'   => __( 'Hero Image', 'studio-pro' ),
	),
) );

// Enable shortcodes in text widgets.
add_filter( 'widget_text', 'do_shortcode' );

// Remove primary sidebar.
unregister_sidebar( 'sidebar' );

// Remove secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Remove header right widget area.
unregister_sidebar( 'header-right' );

// Remove site layouts.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Custom structural wraps.
add_action( 'genesis_header', 'studio_wrap_open', 6 );
add_action( 'genesis_header', 'studio_wrap_close', 13 );
add_action( 'genesis_content', 'studio_wrap_open', 6 );
add_action( 'genesis_content', 'studio_wrap_close', 13 );
add_action( 'genesis_footer', 'studio_wrap_open', 6 );
add_action( 'genesis_footer', 'studio_wrap_close', 13 );
add_action( 'genesis_before_content_sidebar_wrap', 'studio_wrap_open', 6 );
add_action( 'genesis_after_content_sidebar_wrap', 'studio_wrap_close', 13 );

// Remove unused templates and metaboxes.
add_filter( 'theme_page_templates', 'studio_remove_templates' );
add_action( 'genesis_admin_before_metaboxes', 'studio_remove_metaboxes' );

// Change order of main stylesheet to override plugin styles.
remove_action( 'genesis_meta', 'genesis_load_stylesheet' );
add_action( 'wp_enqueue_scripts', 'genesis_enqueue_main_stylesheet', 99 );

// Display custom logo.
add_action( 'genesis_site_title', 'the_custom_logo', 0 );

// Remove content-sidebar-wrap.
add_filter( 'genesis_markup_content-sidebar-wrap', '__return_null' );

// Add `ontouchstart` to body element.
add_filter( 'genesis_attr_body', 'studio_add_ontouchstart' );

// Reposition primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

// Remove featured image from content.
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
remove_action( 'genesis_post_content', 'genesis_do_post_image' );

// Reposition comments.
remove_action( 'genesis_after_post', 'genesis_get_comments_template' );
remove_action( 'genesis_after_entry', 'genesis_get_comments_template' );
add_action( 'genesis_entry_footer', 'genesis_get_comments_template', 1 );
add_action( 'genesis_entry_footer', 'genesis_get_comments_template', 1 );

// Modify breadcrumbs.
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_breadcrumbs', 5 );
add_filter( 'genesis_breadcrumb_args', 'studio_breadcrumb_args' );

// Display featured image on blog.
add_action( 'genesis_before', 'studio_display_featured_image' );

// Accessible read more links.
add_filter( 'excerpt_more', 'studio_read_more' );
add_filter( 'the_content_more_link', 'studio_read_more' );
add_filter( 'get_the_content_more_link', 'studio_read_more' );

// Modify site header schema microdata.
add_filter( 'genesis_attr_title-area', 'studio_title_area' );
add_filter( 'genesis_attr_site-title', 'studio_site_title' );

// Add prev/next links to portfolio.
add_action( 'genesis_after_content_sidebar_wrap',   'studio_prev_next_post_nav_cpt', 999 );

// Modify footer credits.
add_filter( 'genesis_footer_creds_text', 'studio_footer_creds_filter' );

/**
 * Enqueue scripts and styles.
 */
function studio_enqueue_scripts_styles() {

	global $post;

	// Remove WP Featherlight CSS & JS if no gallery.
	if ( $post && ! has_shortcode( $post->post_content, 'gallery' ) ) {
		wp_dequeue_style( 'wp-featherlight' );
		wp_dequeue_script( 'wp-featherlight' );
	}

	// Google fonts.
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Muli:400,700|Monstserrat:700|Roboto+Mono:300,400,500,700|Crimson+Text', array(), CHILD_THEME_VERSION );

	// Enqueue scripts.
	wp_enqueue_script( 'studio-pro', get_stylesheet_directory_uri() . '/assets/scripts/min/studio-pro.min.js', array( 'jquery' ), CHILD_THEME_VERSION, true );

	// Remove default superfish args.
	wp_deregister_script( 'superfish-args' );

	// Localize responsive menus script.
	wp_localize_script( 'studio-pro', 'genesis_responsive_menu', array(
		'mainMenu'         => __( 'Menu', 'studio-pro' ),
		'subMenu'          => __( 'Menu', 'studio-pro' ),
		'menuIconClass'    => null,
		'subMenuIconClass' => null,
		'menuClasses'      => array(
			'combine' => array(
				'.nav-primary',
			),
		),
	) );

}
add_action( 'wp_enqueue_scripts', 'studio_enqueue_scripts_styles' );

// Load theme defaults, in order of front-end importance.
include_once( get_stylesheet_directory() . '/includes/helpers.php' );
include_once( get_stylesheet_directory() . '/includes/hero.php' );
include_once( get_stylesheet_directory() . '/includes/sidebars.php' );
include_once( get_stylesheet_directory() . '/includes/woocommerce.php' );
include_once( get_stylesheet_directory() . '/includes/defaults.php' );
include_once( get_stylesheet_directory() . '/includes/plugins.php' );
include_once( get_stylesheet_directory() . '/includes/customize.php' );
include_once( get_stylesheet_directory() . '/includes/output.php' );
