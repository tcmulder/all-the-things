<?php
/**
 * Custom single and archive templates for the pattern library.
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
 * Create the single page template.
 *
 * @param string $single_template Path to the single template.
 * @return string
 */
function aqua_patterns_custom_single_template( $single_template ) {
	global $post;
	if ( 'all-the-things' === $post->post_type && 'single.php' === basename( $single_template ) ) {
		$single_template = AQUA_PATTERNS_PLUGIN_DIR . 'templates/single.php';
	}
	return $single_template;
}
add_filter( 'single_template', 'aqua_patterns_custom_single_template' );

/**
 * Create the archive page template.
 *
 * @param string $archive_template Path to the archive template.
 * @return string
 */
function aqua_patterns_custom_archive_template( $archive_template ) {
	global $post;
	if ( is_post_type_archive( 'all-the-things' ) ) {
		$archive_template = AQUA_PATTERNS_PLUGIN_DIR . 'templates/archive.php';
	}
	return $archive_template;
}
add_filter( 'archive_template', 'aqua_patterns_custom_archive_template' );
