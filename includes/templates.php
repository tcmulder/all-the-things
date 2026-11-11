<?php
/**
 * Custom single and archive templates for the pattern library.
 */

/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create custom templates that mimic the single and archive templates
 */
// create the single page
function aqua_patterns_custom_single_template( $single_template ) {
	global $post;
	if ( $post->post_type === 'all-the-things' && basename( $single_template ) === 'single.php' ) {
		$single_template = AQUA_PATTERNS_PLUGIN_DIR . 'templates/single.php';
	}
	return $single_template;
}
add_filter( 'single_template', 'aqua_patterns_custom_single_template' );

// create the archive page
function aqua_patterns_custom_archive_template( $archive_template ) {
	 global $post;
	if ( is_post_type_archive( 'all-the-things' ) ) {
		 $archive_template = AQUA_PATTERNS_PLUGIN_DIR . 'templates/archive.php';
	}
	 return $archive_template;
}
add_filter( 'archive_template', 'aqua_patterns_custom_archive_template' );
