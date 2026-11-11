<?php
/**
 * Register Pattern block and limit its availability.
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
 * Register the Pattern block editor script and block type.
 */
function aqua_patterns_register_blocks() {
	wp_register_script(
		'all-the-things-pattern-block',
		AQUA_PATTERNS_PLUGIN_URI . 'assets/all-the-things-pattern-block.js',
		array(
			'wp-blocks',
			'wp-block-editor',
			'wp-components',
			'wp-core-data',
			'wp-data',
			'wp-element',
			'wp-html-entities',
			'wp-i18n',
		),
		AQUA_PATTERNS_VERSION,
		true
	);

	register_block_type(
		'all-the-things/pattern',
		array(
			'api_version'   => 3,
			'title'         => __( 'Pattern', 'aqua-pattern-library' ),
			'description'   => __( 'Pick a synced pattern to insert.', 'aqua-pattern-library' ),
			'category'      => 'widgets',
			'icon'          => 'block-default',
			'editor_script' => 'all-the-things-pattern-block',
			'supports'      => array(
				'html'     => false,
				'reusable' => false,
			),
		)
	);
}
add_action( 'init', 'aqua_patterns_register_blocks' );

/**
 * Allow the Pattern block only on All The Things posts.
 *
 * @param  bool|string[]           $allowed_block_types Allowed types, or true for all.
 * @param  WP_Block_Editor_Context $editor_context      Editor context.
 * @return bool|string[]
 */
function aqua_patterns_restrict_pattern_block( $allowed_block_types, $editor_context ) {
	$block_name = 'all-the-things/pattern';

	if ( ! empty( $editor_context->post ) && 'all-the-things' === $editor_context->post->post_type ) {
		return $allowed_block_types;
	}

	if ( true === $allowed_block_types ) {
		$registered = array_keys( WP_Block_Type_Registry::get_instance()->get_all_registered() );
		return array_values( array_diff( $registered, array( $block_name ) ) );
	}

	if ( is_array( $allowed_block_types ) ) {
		return array_values( array_diff( $allowed_block_types, array( $block_name ) ) );
	}

	return $allowed_block_types;
}
add_filter( 'allowed_block_types_all', 'aqua_patterns_restrict_pattern_block', 10, 2 );
