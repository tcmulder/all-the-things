<?php
/**
 * Archive template for All the Things.
 *
 * @package Aqua_Pattern_Library
 */

?>
<!DOCTYPE html>
<html id="all-the-things-archive">
<head>
	<!--                                                                            -->
	<!--                         `..-:///+++++///:-..`                              -->
	<!--                       .-/+oo+/::~~~...~~~::/+oo+/-.`                       -->
	<!--                   `-/oo/:-`            .-://:-.-:/oo/-`                    -->
	<!--                `-/o+:.`              .+o+/:/+o+-  `.:+o+-`                 -->
	<!--              `:+o/.                 .oo:`    -oo-     .:oo:`               -->
	<!--            `:o+:`                   :oo`      +o/       `:+o:`             -->
	<!--           -+o:`                     .oo/.   `:oo-         `:o+-            -->
	<!--    ...`` `..```..-:/+`      ```      .ooo+++oo+-            `/o/`          -->
	<!--    -oo+++++++++oooooo+`     ++++//:~~~oooooo:.`               :o+.         -->
	<!--    .oooooooooooo+/-:oo+-   ./+ooooooooooooo+.``                -o+.        -->
	<!--     +oooooo+/:~~~::`-+oo/.   ``.-:/+oooooooooo+/:-.`            -o+`       -->
	<!--     ./:-...-:/+ooo+. `:+oo+:.`     `+ooooo++ooooooo+.            :o/       -->
	<!--     ``. .++ooooo+:.... `-/+oo++//://oooooo.``.~~:///      `-.    `+o-      -->
	<!--     /o:  .+ooo/-.:+oo:  ....-//++ooooooooo/.`         `.-/+oo/.   -o+      -->
	<!--    `oo`   `:/../oooo+``:oo+` `..``+ooooooooo++/:::::/++ooo++ooo/.``/o.     -->
	<!--    -o+       -ooooo+``/ooo: .+o+-`+ooooo/.-://+++oo+++/:-.../oooo+:..`     -->
	<!--    :o+       -oo+o/`-+ooo+``+ooo`-oooooo`-:-. `....```  .+o/.-+ooooo+/-.`` -->
	<!--    :o+      :oo/`.`-+oooo-`+ooo/`oooooo-`ooo: `o++. `+/.`+ooo:./oooooooo+/ -->
	<!--    -o+     -oo/     `.-//`+oooo.:ooooo+`/ooo- :ooo- :ooo-.oooo/../oooooo/` -->
	<!--    `oo`    /oo.          `.~~:/`oooooo~~oooo.`oooo: /ooo+`:ooooo-`./oo+.   -->
	<!--     /o:    /oo-                :ooooo+`/+ooo`:oooo/ /oooo/`+o++/-`` ..     -->
	<!--     .oo`   -oo+.              `oooooo- ``.-: :/+++/ /+ooo/``.`   `+:       -->
	<!--      :o/    :ooo/.`           /ooooo+            `` ``oo+        /o/       -->
	<!--      `+o:    -+ooo+:.`      `/oooooo-                 oo+       :o+`       -->
	<!--       `+o:    `-+oooo+/:~~~:+ooooooo-                -oo:      :o+`        -->
	<!--        `/o/`     .:++ooooooooooooooo+`             `:oo+`    `/o+`         -->
	<!--          :o+.       `.:+ooooooooooooo+:-..``````.-/+oo/`    .+o:`          -->
	<!--           .+o/.         .:+oooooooooooooooooooooooo+/.    `/o+.            -->
	<!--             -+o/.         `/ooooooo++++++++++++/:-.`    ./o+-`             -->
	<!--              `-+o/-`        +oo+-.`                  `-/o+-`               -->
	<!--                 .:+o/-`     :o-                   `-/o+/.                  -->
	<!--                    .:+o+/:.`..               `.:/+o+:.`                    -->
	<!--                       `.:/+oo+//::::~~::://+oo+/:-`                        -->
	<!--                            ``.~~:://///::~~..`                             -->
	<!--                                                                            -->
	<!--                     https://www.thinkaquamarine.com                        -->
	<!--                                                                            -->
	<title><?php esc_html_e( 'All the Things', 'aqua-pattern-library' ); ?></title>
	<?php wp_head(); ?>
</head>
<body class="things-wrap">
	<h1>All the Things:</h1>
	<?php
	$things_query = new WP_Query(
		array(
			'posts_per_page' => 999, // phpcs:ignore WordPress.WP.PostsPerPage.posts_per_page_posts_per_page -- Archive shows every pattern.
			'post_type'      => 'all-the-things',
			'orderby'        => 'title',
			'order'          => 'ASC',
		)
	);
	?>
	<?php if ( $things_query->have_posts() ) : ?>
		<?php
		$term_count   = (bool) wp_count_terms(
			array(
				'taxonomy'   => 'all-the-things-thing',
				'hide_empty' => true,
			)
		);
		$allowed_html = array(
			'li'     => array(
				'class' => true,
			),
			'a'      => array(
				'href'  => true,
				'class' => true,
			),
			'div'    => array(),
			'iframe' => array(
				'data-src' => true,
				'tabindex' => true,
			),
			'span'   => array(),
			'h2'     => array(),
		);
		?>
		<ul class="things-grid">
			<?php $items = array(); ?>
			<?php
			while ( $things_query->have_posts() ) {
				$things_query->the_post();
				$terms = get_the_terms( get_the_id(), 'all-the-things-thing' );
				$term  = ! empty( $terms[0] ) ? $terms[0]->name : __( 'Uncategorized', 'aqua-pattern-library' );
				$html  = sprintf(
					'<li><a href="%s" class="things-control"><div><iframe data-src="%s?iframe-things" tabindex="-1"></iframe></div><span>%s</span></a></li>',
					esc_url( add_query_arg( 'hide-things', '', get_the_permalink() ) ),
					esc_url( get_the_permalink() ),
					esc_html( get_the_title() )
				);
				if ( ! isset( $items[ $term ] ) ) {
					$term_title     = $term_count ? sprintf( '<li class="things-label"><h2>%s</h2></li>', esc_html( $term ) ) : '';
					$items[ $term ] = array( $term_title );
				}
				array_push( $items[ $term ], $html );
			}
			foreach ( $items as $item ) {
				echo wp_kses( implode( '', $item ), $allowed_html );
			}
			?>
		</ul>
		<?php
	endif;
	wp_reset_postdata();
	?>
<?php wp_footer(); ?>
</body>
</html>

