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
	$combobox = '';
	if ( $the_query->have_posts() ) {

		// create the list of patterns.
		$options = '';
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$options .= sprintf(
				'<li role="option" class="all-the-things-menu__option" id="all-the-things-option-%1$d" data-url="%2$s" aria-selected="false">%3$s</li>',
				get_the_ID(),
				esc_url( add_query_arg( 'hide-things', '', get_the_permalink() ) ),
				esc_html( get_the_title() )
			);
		}
		$patterns_label = __( 'Patterns', 'aqua-pattern-library' );
		$combobox       = sprintf(
			'<div class="all-the-things-menu">
				<input type="text" role="combobox" id="all-the-things-combobox" class="all-the-things-control all-the-things-menu__input" aria-label="%1$s" aria-autocomplete="list" aria-expanded="false" aria-controls="all-the-things-listbox" aria-activedescendant="" autocomplete="off" placeholder="%1$s" />
				<ul id="all-the-things-listbox" role="listbox" class="all-the-things-menu__list" aria-label="%1$s" hidden>%2$s</ul>
			</div>',
			esc_attr( $patterns_label ),
			$options
		);
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
		'<a href="%s" id="things-link" class="all-the-things-link">%s</a>',
		esc_url( get_post_type_archive_link( 'all-the-things' ) ),
		esc_html__( 'All the Things', 'aqua-pattern-library' )
	);

	// create the menu itself.
	$str = sprintf(
		'<div id="all-the-things">%s%s%s</div>',
		$combobox,
		$link_edit,
		$link_all_the_things
	);

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
