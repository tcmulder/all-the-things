<?php
/**
 * Dev workaround for Chrome password extension focus issues.
 */

/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Hack to fix Chrome password extension from setting focus on the password field.
 *
 * You can remove this if you do not use this extension.
 *
 * @see https://superuser.com/questions/1776123/icloud-password-chrome-extension-sets-focus-on-first-input-during-localhost-dev
 */
function aqua_patterns_extension_hack( $content ) {
	if ( isset( $_GET['iframe-things'] )  ) {
		return str_replace( 'type="password"', 'type="text"', $content );
	}
	return $content;
}
add_filter( 'the_content', 'aqua_patterns_extension_hack' );
