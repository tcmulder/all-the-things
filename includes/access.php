<?php
/**
 * Access control for the pattern library.
 */

/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if localhost or other authorized server (will always show on localhost)
 */
function aqua_patterns_is_allowed_server() {
	$server_name = isset( $_SERVER['SERVER_NAME'] ) ? $_SERVER['SERVER_NAME'] : '';
	$remote_addr = isset( $_SERVER['REMOTE_ADDR'] ) ? $_SERVER['REMOTE_ADDR'] : '';

	$local_hosts = array( 'localhost', '127.0.0.1', '::1' );
	$local_addrs = array( '127.0.0.1', '::1' );

	if (
		in_array( $server_name, AQUA_PATTERNS_ALLOWED_SERVERS, true )
		|| in_array( $server_name, $local_hosts, true )
		|| in_array( $remote_addr, $local_addrs, true )
		|| ( function_exists( 'wp_get_environment_type' ) && 'local' === wp_get_environment_type() )
		|| (bool) preg_match( '/\.(local|test|localhost)$/', $server_name )
	) {
		return true;
	}
	return false;
}

/**
 * Redirect non-logged-in users to login page
 */
function aqua_patterns_redirect_to_specific_page() {
	if (
		// if this is one of all the things and the user isn't logged in
		( 'all-the-things' == get_post_type() && ! is_user_logged_in() )
		// and if we're not on a server that should always show all the things
		&& ! aqua_patterns_is_allowed_server()
	) {
		// make the user log in to see this post
		auth_redirect();
	}

}
add_action( 'template_redirect', 'aqua_patterns_redirect_to_specific_page' );
