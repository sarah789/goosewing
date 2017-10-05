<?php
/**
 * Studio Pro.
 *
 * This file adds the front page to the Studio Pro Theme.
 *
 * @package Studio Pro
 * @author  SeoThemes
 * @license GPL-2.0+
 * @link    https://seothemes.net/themes/studio-pro/
 */

/**
 * Dynamic front page widget areas.
 *
 * @var $widget_areas Number of widget areas.
 */
function studio_front_page_widgets() {

	$widget_areas = get_option( 'studio_front_page_widgets', 6 );

	// Return early if is paged or no front page widget areas.
	if ( is_paged() || '0' === $widget_areas ) {
		return;
	}

	// Remove page title if not showing posts.
	if ( ! is_home() ) {
		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
	}

	// Loop through dynamic widget areas.
	for ( $i = 1; $i <= $widget_areas; $i++ ) {

		if ( 1 === $i && is_active_sidebar( 'front-page-1' ) ) : ?>

			<div class="front-page-1 hero-section overlay" role="banner">
				<?php the_custom_header_markup(); ?>
				<div class="wrap">
				<?php genesis_widget_area( 'front-page-1', array(
					'before' => false,
					'after'  => false,
				) ); ?>
				</div>
			</div>

		<?php else :

			genesis_widget_area( "front-page-$i", array(
				'before' => sprintf( '<div class="front-page-%s widget-area">%s', $i, 3 !== $i ? '<div class="wrap">' : '' ),
				'after'  => sprintf( '</div>%s', 3 !== $i ? '</div>' : '' ),
			) );

		endif;
	}
}

// Add action front page widgets to before content sidebar wrap hook.
add_action( 'genesis_before_content_sidebar_wrap', 'studio_front_page_widgets', 1 );

// Remove the default Genesis loop.
if ( 'false' === get_option( 'studio_front_page_content' ) ) {

	// Force full width.
	add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

	// Remove site-inner markup.
	add_filter( 'genesis_markup_content-sidebar-wrap_output', '__return_false' );
	add_filter( 'genesis_markup_content', '__return_null' );

	// Remove loop.
	remove_action( 'genesis_loop', 'genesis_do_loop' );

	// Remove custom structural wraps.
	remove_action( 'genesis_before_content_sidebar_wrap', 'studio_wrap_open', 6 );
	remove_action( 'genesis_after_content_sidebar_wrap', 'studio_wrap_close', 13 );

}

// Remove hero.
remove_action( 'genesis_after_header', 'studio_hero', 99 );

// Run Genesis.
genesis();
