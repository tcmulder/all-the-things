<?php
/**
 * Enqueue pattern library styles and scripts.
 *
 * @package Aqua_Pattern_Library
 */

/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue styles and scripts
 */
function aqua_patterns_register_scripts() {

	// if we're on an authorized server and not within an archive iframe
	if ( aqua_patterns_is_allowed_server() && ! isset( $_GET['iframe-things'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only display flag.
		// enqueue global scripts (mostly for the menu)
		wp_enqueue_style( 'aqua-all-the-things-style', AQUA_PATTERNS_PLUGIN_URI . 'assets/all-the-things.css', null, AQUA_PATTERNS_VERSION, 'all' );
		wp_enqueue_script( 'aqua-all-the-things-script', AQUA_PATTERNS_PLUGIN_URI . 'assets/all-the-things.js', null, AQUA_PATTERNS_VERSION, 'true' );

		// enqueue archive page scripts
		if ( is_post_type_archive( 'all-the-things' ) ) {
			wp_enqueue_style( 'aqua-all-the-things-archive-style', AQUA_PATTERNS_PLUGIN_URI . 'assets/all-the-things-archive.css', null, AQUA_PATTERNS_VERSION, 'all' );
			wp_enqueue_script( 'aqua-all-the-things-archive-script', AQUA_PATTERNS_PLUGIN_URI . 'assets/all-the-things-archive.js', null, AQUA_PATTERNS_VERSION, 'true' );
		}
	}

	// if we're within an archive iframe then don't show the header/footer
	if ( is_singular( 'all-the-things' ) && isset( $_GET['hide-things'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only display flag.
		wp_register_style( 'aqua-hide-all-the-things', false, array(), AQUA_PATTERNS_VERSION );
		wp_enqueue_style( 'aqua-hide-all-the-things' );
		wp_add_inline_style( 'aqua-hide-all-the-things', '.site-header, .site-footer, #__bs_notify__ { display: none !important; }' );
	}
}
add_action( 'wp_enqueue_scripts', 'aqua_patterns_register_scripts' );
