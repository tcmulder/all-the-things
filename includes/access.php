<?php
/**
 * Access control for the pattern library.
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
 * Check if public pattern access is enabled for the current domain.
 */
function aqua_patterns_is_allowed_server() {
	$host = wp_parse_url( home_url(), PHP_URL_HOST );
	if ( ! is_string( $host ) || '' === $host ) {
		return false;
	}

	$domains = get_option( 'all_the_things_for_domain', array() );
	if ( ! is_array( $domains ) || empty( $domains[ $host ] ) ) {
		return false;
	}

	return true;
}

/**
 * Redirect non-logged-in users to login page
 */
function aqua_patterns_redirect_to_specific_page() {
	if (
		// if this is one of all the things and the user isn't logged in
		( 'all-the-things' === get_post_type() && ! is_user_logged_in() )
		// and if we're not on a server that should always show all the things
		&& ! aqua_patterns_is_allowed_server()
	) {
		// make the user log in to see this post
		auth_redirect();
	}
}
add_action( 'template_redirect', 'aqua_patterns_redirect_to_specific_page' );
