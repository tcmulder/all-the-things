<!DOCTYPE html>
<html>
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
	<title><?php _e( 'All the Things', 'aqua-pattern-library' ); ?></title>
	<?php wp_head(); ?>
</head>
<body class="things-wrap">
	<?php query_posts( 'posts_per_page=999&post_type=all-the-things&orderby=title&order=ASC' ); ?>
	<?php if ( have_posts() ) : ?>
		<ul class="things-grid">
			<?php $items = array(); ?>
			<?php
			while ( have_posts() ) {
				the_post();
				$terms = get_the_terms( get_the_id(), 'all-the-things-thing' );
				$term  = $terms[0] ?? '' ? $terms[0]->name : __( 'Uncategorized', 'aqua-pattern-library' );
				$html  = sprintf(
					'<li><a href="%s" class="things-control"><div><iframe data-src="%s?all-the-things-thing" tabindex="-1"></iframe></div><span>%s</span></a></li>',
					get_the_permalink(),
					get_the_permalink(),
					get_the_title()
				);
				if ( ! isset( $items[ $term ] ) ) {
					$items[ $term ] = array( sprintf( '<li class="things-label"><h2>%s:</h2></li>', $term ) );
				}
				array_push( $items[ $term ], $html );
			}
			foreach ( $items as $item ) {
				echo implode( '', $item );
			}
			?>
		</ul>
		<?php
	endif;
	wp_reset_query();
	?>
<?php wp_footer(); ?>
</body>
</html>
