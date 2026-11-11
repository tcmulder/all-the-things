<?php
/**
 * Pattern library footer navigation menu.
 */

/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
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
	$select = '';
	if ( $the_query->have_posts() ) {

		// create the list of patterns
		$options = sprintf( '<option disabled selected>%s</option>', __( 'Patterns', 'aqua-pattern-library' ) );
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$options .= sprintf( '<option value="%s">%s</option>', add_query_arg( 'hide-things', '', get_the_permalink() ), get_the_title() );
		}
		$new_tab = '<input title="Open patterns in new tab" type="checkbox" />';
		$select = sprintf( '<div><select aria-label="Open Pattern" class="all-the-things-control">%s</select>%s</div>', $options, $new_tab );
	} else {
		return '<p>All the Things does not have any posts</p>';
	}
	wp_reset_postdata();

	// add link to edit this page (reversed till click to bypass any browsersync or other URL rewriting)
	$edit_url     = admin_url( '/post.php?post=' . get_the_id() . '&action=edit' );
	$edit_url_rev = strrev( admin_url( '/post.php?post=' . get_the_id() . '&action=edit' ) );
	$link_edit    = sprintf( '<a href="javascript:void(0);" onclick="window.open(\'%s\'.split(\'\').reverse().join(\'\'),\'_blank\')">✎ %s</a>', $edit_url_rev, __( 'Edit', 'aqua-pattern-library' ) );

	// add link to all of the things
	$link_all_the_things = sprintf( '<a href="%s" id="things-link">%s</a>', get_post_type_archive_link( 'all-the-things' ), __( 'All the Things', 'aqua-pattern-library' ) );

	// create the menu itself
	$str = sprintf( '<div id="all-the-things">%s<div>%s <span>|</span> %s</div></div>', $select, $link_edit, $link_all_the_things );

	// send it!
	return $str;
}

// show the page list in the footer
function aqua_patterns_page_list_in_footer() {
	if ( aqua_patterns_is_allowed_server() && ! isset( $_GET['iframe-things'] ) ) {
		echo aqua_patterns_show();
	}
}
add_action( 'wp_footer', 'aqua_patterns_page_list_in_footer', 50 );
