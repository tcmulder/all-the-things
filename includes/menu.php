<?php
/**
 * Pattern library footer navigation menu.
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
 * Show sub page nav for all the things.
 *
 * @return string
 */
function aqua_patterns_show() {

	// get all the things.
	$page_id   = get_the_id();
	$the_query = new WP_Query(
		array(
			'post_type'      => 'all-the-things',
			'posts_per_page' => '-1',
			'orderby'        => 'title',
			'order'          => 'ASC',
		)
	);

	// if we have things.
	$select = '';
	if ( $the_query->have_posts() ) {

		// create the list of patterns.
		$options = sprintf( '<option disabled selected>%s</option>', esc_html__( 'Patterns', 'aqua-pattern-library' ) );
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$options .= sprintf(
				'<option value="%s">%s</option>',
				esc_url( add_query_arg( 'hide-things', '', get_the_permalink() ) ),
				esc_html( get_the_title() )
			);
		}
		$new_tab = '<input title="Open patterns in new tab" type="checkbox" />';
		$select  = sprintf( '<div><select aria-label="Open Pattern" class="all-the-things-control">%s</select>%s</div>', $options, $new_tab );
	} else {
		return '<p>' . esc_html__( 'All the Things does not have any posts', 'aqua-pattern-library' ) . '</p>';
	}
	wp_reset_postdata();

	// Store edit URL reversed so BrowserSync (etc.) cannot rewrite the host in the HTML source.
	// Inline script un-reverses into href immediately so the link is a real URL for cmd+click, drag, and copy.
	$edit_url_rev = strrev( admin_url( '/post.php?post=' . $page_id . '&action=edit' ) );
	$link_edit    = sprintf(
		'<a class="all-the-things-edit" data-href-rev="%1$s">✎ %2$s</a><script>(function (el) { var r = el && el.getAttribute("data-href-rev"); if (r) { el.href = r.split("").reverse().join(""); } })(document.currentScript.previousElementSibling);</script>',
		esc_attr( $edit_url_rev ),
		esc_html__( 'Edit', 'aqua-pattern-library' )
	);

	// add link to all of the things.
	$link_all_the_things = sprintf(
		'<a href="%s" id="things-link">%s</a>',
		esc_url( get_post_type_archive_link( 'all-the-things' ) ),
		esc_html__( 'All the Things', 'aqua-pattern-library' )
	);

	// create the menu itself.
	$str = sprintf( '<div id="all-the-things">%s<div>%s <span>|</span> %s</div></div>', $select, $link_edit, $link_all_the_things );

	// send it!
	return $str;
}

/**
 * Show the page list in the footer.
 */
function aqua_patterns_page_list_in_footer() {
	if ( aqua_patterns_is_allowed_server() && ! isset( $_GET['iframe-things'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only display flag.
		echo aqua_patterns_show(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Markup is escaped inside aqua_patterns_show().
	}
}
add_action( 'wp_footer', 'aqua_patterns_page_list_in_footer', 50 );
