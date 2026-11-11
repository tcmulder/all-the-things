<?php
/**
 * Register the All the Things post type and taxonomy.
 */

/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create All the Things CPT and terms
 */
function aqua_patterns_create_all_the_things() {

	register_taxonomy(
		'all-the-things-thing',
		'all-the-things',
		array(
			'labels'            => array(
				'name'                  => _x( 'Types', 'Taxonomy Types', 'aqua-pattern-library' ),
				'singular_name'         => _x( 'Type', 'Taxonomy Type', 'aqua-pattern-library' ),
				'search_items'          => __( 'Search Types', 'aqua-pattern-library' ),
				'popular_items'         => __( 'Popular Types', 'aqua-pattern-library' ),
				'all_items'             => __( 'All Types', 'aqua-pattern-library' ),
				'parent_item'           => __( 'Parent Type', 'aqua-pattern-library' ),
				'parent_item_colon'     => __( 'Parent Type', 'aqua-pattern-library' ),
				'edit_item'             => __( 'Edit Type', 'aqua-pattern-library' ),
				'update_item'           => __( 'Update Type', 'aqua-pattern-library' ),
				'add_new_item'          => __( 'Add New Type', 'aqua-pattern-library' ),
				'new_item_name'         => __( 'New Type Name', 'aqua-pattern-library' ),
				'add_or_remove_items'   => __( 'Add or remove Types', 'aqua-pattern-library' ),
				'choose_from_most_used' => __( 'Choose from most used Types', 'aqua-pattern-library' ),
				'menu_name'             => __( 'Types', 'aqua-pattern-library' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'has_archive'       => false,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'capabilities'      => array(
				'manage__terms' => 'edit_posts',
				'edit_terms'    => 'manage_categories',
				'delete_terms'  => 'manage_categories',
				'assign_terms'  => 'edit_posts',
			),
		)
	);

	register_post_type(
		'all-the-things',
		array(
			'labels'        => array(
				'name'                       => _x( 'All The Things', 'Taxonomy General Name', 'aqua-pattern-library' ),
				'singular_name'              => _x( 'All The Things', 'Taxonomy Singular Name', 'aqua-pattern-library' ),
				'menu_name'                  => __( 'Patterns', 'aqua-pattern-library' ),
				'all_items'                  => __( 'All Patterns', 'aqua-pattern-library' ),
				'parent_item'                => __( 'Parent Pattern', 'aqua-pattern-library' ),
				'parent_item_colon'          => __( 'Parent Pattern:', 'aqua-pattern-library' ),
				'new_item_name'              => __( 'New Pattern Name', 'aqua-pattern-library' ),
				'add_new_item'               => __( 'Add New Pattern', 'aqua-pattern-library' ),
				'edit_item'                  => __( 'Edit Pattern', 'aqua-pattern-library' ),
				'update_item'                => __( 'Update Pattern', 'aqua-pattern-library' ),
				'separate_items_with_commas' => __( 'Separate patterns with commas', 'aqua-pattern-library' ),
				'search_items'               => __( 'Search Patterns', 'aqua-pattern-library' ),
				'add_or_remove_items'        => __( 'Add or remove patterns', 'aqua-pattern-library' ),
				'choose_from_most_used'      => __( 'Choose from the most used patterns', 'aqua-pattern-library' ),
				'not_found'                  => __( 'Not Found', 'aqua-pattern-library' ),
			),
			'menu_icon'     => 'dashicons-analytics',
			'has_archive'   => true,
			'public'        => true,
			'hierarchical'  => true,
			'menu_position' => 100, // bottom-ish
			'show_in_rest'  => true,
			'supports'      => array(
				'editor',
				'custom-fields',
				'title',
				'page-attributes',
			),
		)
	);

}
add_action( 'init', 'aqua_patterns_create_all_the_things' );
