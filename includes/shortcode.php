<?php
/**
 * Synced pattern shortcode.
 */

/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Show synced pattern by ID via a shortcode
 *
 * Usate: [thing id="123"] // most efficient
 *        [thing slug="my-post"] // note: could match multiple posts
 */
function aqua_patterns_synced_pattern_shortcode( $attr ) {
	$html = '';
	extract(
		shortcode_atts(
			array(
				'id'   => 0,
				'slug' => '',
			),
			$attr
		)
	);
	if ( $id ) {
		$post_obj = get_post( $id );
		if ( $post_obj ) {
			$html = apply_filters( 'the_content', $post_obj->post_content );
		}
	} elseif ( $slug ) {
		$post_types = get_post_types();
		foreach ( $post_types as $type ) {
			$post_arr = get_posts(
				array(
					'post_type' => $type,
					'name'      => $slug,
				)
			);
			if ( $post_arr ) {
				$html = apply_filters( 'the_content', $post_arr[0]->post_content );
				break;
			}
		}
	}
	return $html;
}
add_shortcode( 'thing', 'aqua_patterns_synced_pattern_shortcode' );
