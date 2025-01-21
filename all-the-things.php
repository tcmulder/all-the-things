<?php
/*
Plugin Name: Pattern Library
Description: Adds a basic pattern library to your WordPress site.
Version:     3.0.1
Author:      Tomas Mulder
Author URI:  https://www.thinkaquamarine.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: aqua-pattern-library
Domain Path: /languages
*/

/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Define constants
 */
define( 'AQUA_PATTERNS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'AQUA_PATTERNS_PLUGIN_URI', plugin_dir_url( __FILE__ ) );
define( 'AQUA_PATTERNS_ALLOWED_SERVERS', array( 'test.thinkaquamarine.com' ) );
define( 'AQUA_PATTERNS_VERSION', '3.0.1' );

/**
 * Check if localhost or other authorized server (will always show on localhost)
 */
function aqua_patterns_is_allowed_server() {
	if (
		in_array( $_SERVER['SERVER_NAME'], AQUA_PATTERNS_ALLOWED_SERVERS )
		|| $_SERVER['SERVER_NAME'] === 'localhost'
		|| $_SERVER['REMOTE_ADDR'] === '127.0.0.1'
	) {
		return true;
	}
	return false;
}

/**
 * Redirect non-logged-in users to login page
 */
add_action( 'template_redirect', 'aqua_patterns_redirect_to_specific_page' );
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

/**
 * Create All the Things CPT and terms
 */
add_action( 'init', 'aqua_patterns_create_all_the_things' );
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

/**
 * Enqueue styles and scripts
 */
add_action( 'wp_enqueue_scripts', 'aqua_patterns_register_scripts' );
function aqua_patterns_register_scripts() {
	
	// if we're on an authorized server and not within an archive iframe
	if ( aqua_patterns_is_allowed_server() && ! isset( $_GET['all-the-things-thing'] ) ) {
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
	if ( is_singular( 'all-the-things' ) ) {
		wp_register_style( 'aqua-hide-all-the-things', null );
		wp_enqueue_style( 'aqua-hide-all-the-things' );
		wp_add_inline_style( 'aqua-hide-all-the-things', '.site-header, .site-footer, #__bs_notify__ { display: none !important; }' );
	}

}


/**
 * Create custom templates that mimic the single and archive templates
 */
// create the single page
add_filter( 'single_template', 'aqua_patterns_custom_single_template' );
function aqua_patterns_custom_single_template( $single_template ) {
	global $post;
	if ( $post->post_type === 'all-the-things' && basename( $single_template ) === 'single.php' ) {
		$single_template = AQUA_PATTERNS_PLUGIN_DIR . 'templates/single.php';
	}
	return $single_template;
}
// create the archive page
add_filter( 'archive_template', 'aqua_patterns_custom_archive_template' );
function aqua_patterns_custom_archive_template( $archive_template ) {
	 global $post;
	if ( is_post_type_archive( 'all-the-things' ) ) {
		 $archive_template = AQUA_PATTERNS_PLUGIN_DIR . 'templates/archive.php';
	}
	 return $archive_template;
}

/**
 * Show synced pattern by ID via a shortcode
 *
 * Usate: [thing id="123"] // most efficient
 *        [thing slug="my-post"] // note: could match multiple posts
 */
add_shortcode( 'thing', 'aqua_patterns_synced_pattern_shortcode' );
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

/**
 * Show sub page nav for all the things
 */
function aqua_patterns_show() {

	// get all the things
	$page_id   = get_the_id();
	$the_query = new WP_Query(
		array(
			'post_type'      => 'all-the-things',
			'posts_per_page' => '-1',
			'orderby'        => 'title',
			'order'          => 'ASC',
		)
	);

	// if we have things
	if ( $the_query->have_posts() ) {

		// create the list of patterns
		$options = '<option disabled selected>Patterns</option>';
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$options .= sprintf( '<option value="%s">%s</option>', get_the_permalink(), get_the_title() );
		}

		// add edit link for page then wrap in list
		$links        = '<a href="' . get_post_type_archive_link( 'all-the-things' ) . '" id="things-link">All the Things</a>';
		$edit_url     = admin_url( '/post.php?post=' . get_the_id() . '&action=edit' );
		$edit_url_rev = strrev( admin_url( '/post.php?post=' . get_the_id() . '&action=edit' ) );
		$links        = sprintf( '<a href="javascript:void(0);" onclick="window.open(\'%s\'.split(\'\').reverse().join(\'\'),\'_blank\')">✎ Edit (new tab)</a>%s', $edit_url_rev, $links );

		// create the menu itself
		$str = sprintf( '<div id="all-the-things"><select class="all-the-things-control">%s</select>%s</div>', $options, $links );

		// send it!
		return $str;
	}
	wp_reset_postdata();
}

// show the page list in the footer
add_action( 'wp_footer', 'aqua_patterns_page_list_in_footer', 50 );
function aqua_patterns_page_list_in_footer() {
	if ( aqua_patterns_is_allowed_server() && ! isset( $_GET['all-the-things-thing'] ) ) {
		echo aqua_patterns_show();
	}
}

/**
 * Hack to fix Chrome password extension from setting focus on the password field.
 * 
 * You can remove this if you do not use this extension.
 * 
 * @see https://superuser.com/questions/1776123/icloud-password-chrome-extension-sets-focus-on-first-input-during-localhost-dev
 */
add_filter( 'the_content', 'aqua_patterns_extension_hack' );
function aqua_patterns_extension_hack( $content ) {
	if ( isset( $_GET['all-the-things-thing'] )  ) {
		return str_replace( 'type="password"', 'type="text"', $content );
	}
	return $content;
}