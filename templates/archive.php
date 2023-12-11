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
    <title>All the Things</title>
    <?php wp_head(); ?>
</head>
<body class="things-wrap">
    <?php query_posts('posts_per_page=999&post_type=all-the-things&orderby=title&order=ASC'); ?>
    <?php if(have_posts()) : ?>
        <select class="things-list things-control">
            <option disabled selected value="">
                <?php _e( 'Start typing to select a pattern, then press Return to navigate there.', 'all-the-things' ); ?>
            </option>
            <?php while(have_posts()) : the_post(); ?>
                <option value="<?php the_permalink(); ?>">
                    <?php
                        the_title();
                        $terms = get_the_terms( get_the_id(), 'all-the-things-thing' );
                        if ( $terms ) {
                            $terms = array_map( function( $term ) { return $term->name; }, $terms );
                            printf( ' (%s)', strtolower( implode( ', ', $terms ) ) );
                        }
                    ?>
                </option>
            <?php endwhile; ?>
        </select>
        <ul class="things-grid">
            <?php while(have_posts()) : the_post(); ?>
                <li>
                    <a href="<?php the_permalink(); ?>" class="things-control">
                        <div>
                            <iframe data-src="<?php the_permalink(); ?>?demo" tabindex="-1"></iframe>
                        </div>
                        <span>
                            <?php the_title(); ?>
                        </span>
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>
        <style>
            .things-wrap::before {
                content: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1000 1000' width='100%25' height='100%25' style='transform:rotate(-9deg)'%3E%3Cg fill-rule='nonzero'%3E%3Cpath fill='aquamarine' d='M480.2 940.8c-54-3.2-98.3-12.8-143.5-31-35.8-14.3-68.4-32.6-99.6-56-52-39-95.4-89.5-125.8-146.6-9-16.8-21.6-45.4-25.5-57.4l-2.7-8c-12.5-35.5-21-80.2-22.8-121l-.3-7.3 4.6-3.4 6.3-4.3c7.8-6 19.6-14 20-14 .3.2.7 8.5 1 18.4.7 41.5 7.4 79.7 20.6 119.8 11.2 34 28 68.2 48 98.2C190 771.5 228 809.7 271 838.8c55.8 38 119.2 61 185.4 68 54.7 5.7 108.5 1 160.7-14.3 89.8-26 170.2-85.3 223.3-164.5 9.2-13.8 15.8-25 23.8-40.7 10.7-20.7 17.7-37.3 24.4-57.5 13.2-40 20-78.3 20.7-119.7.3-9.8.7-18 1-18.2.4-.2 12.2 8 20 14 1 .5 3.8 2.5 6.4 4.3l4.7 3.5-.2 7.2c-2 41-10.3 85.6-22.8 121l-2.7 8c-4 12-16.5 40.7-25.5 57.5-13.5 25.3-29.6 49.4-48 72-33 40.3-74 75.6-118.8 102-42.6 25-89.4 42.6-137.7 52-17 3-27.3 4.6-47.7 6.5-9.3 1-48.8 1.6-57.4 1z'%3E%3C/path%3E%3Cpath fill='aquamarine' d='M498 898c-2-3.7-4.2-9.6-10.3-26.8-5.3-15-9.8-23.6-17-32.8-17.8-23-50.6-38.5-100.6-47.4-18.4-3.3-27.4-5-37.4-7.8-43.3-11.6-77-29.8-101.5-55-11.7-12.3-20.2-24-26.7-37.3-11-22.4-15.4-44-14.4-69.5.7-20.3 5.8-41.6 14.3-60.6 1.6-3.7 2.7-6.8 2.5-7 0-.4-1.4-1-3-1.5-4.6-1.7-15.7-6.7-16.5-7.5-.7-.7 0-2 3.8-7.8l28.5-43.4c3-5 9.4-14.6 14-21.6l8.3-12.7 20.5-10.2c13.7-7 20.5-10 20.7-9.5.3 1 2.8 20.2 4.4 34.6l1 9.5-1.5 6.6-14 54.3-6.7 26.4c-.7 3-1.5 5.7-2 6.2-.7 1-1.2.8-12-4l-9-4-1 2c-2.2 5.3-6 16.6-8 24.8-5.5 22.5-5.2 43.4 1 60 5.4 14.8 14.6 27.7 26.4 37.2 27.2 22 66.7 34.8 125 41 15.6 1.5 29.2-1.3 40.8-8.6 3.8-2.3 11-9.8 14-14.3 6.2-9.5 11-21.8 14.6-38l1.7-7.6.2-97c0-60.5 0-100.6-.5-106.2-1-13.6-2.6-17.7-8.4-20.8-2.4-1.3-3-1.4-16.2-1-26.7.5-57.2.2-64-.6-34.4-4.2-60.5-12.5-87-27.5-16.7-9.4-36-24.5-51-39.8l-5.7-6-2.2 2c-1.3 1-5 4.3-8 7-17 15.3-44 37-59.4 47.2-6.6 4.5-21.4 14-22.3 14.5-.2 0-3.8 2-8 4.5-9.3 5.6-23 12.8-43 23-8.5 4.2-17.3 8.8-19.4 10l-4 2-3.5-3.7c-4.5-4.8-6.5-7.3-11-14.5-3.8-6-11.4-21-15-29.6-7.5-18.4-19-54-18-55.2.4-.3 3.3-.2 6.6.2 3.3.3 11.4.6 18 .6 42.6 0 90.5-12.7 138-36.4 6.2-3.4 12.5-6.6 14-7.4 10-5.7 13.2-7.5 19.6-11.4 4-2.4 11-7 15.4-10 4.5-3 8.3-5.4 8.5-5.4.2 0 1.6 1.7 3 4 12.7 18 30.6 36.6 48 49.6 11 8.3 20.7 14 33.4 20.4 13.8 6.8 26 11.2 39.8 14.7 13.2 3.3 22 4.4 37 4.8 23 .6 41.3-3 59-11.5l7-3.5-.3-14.7-.3-14.8-8-.5-46-3c-20.7-1.3-44.7-3-53.3-3.4l-16.4-1.3c-1-.4-1-49 0-49.4.7-.2 37.5-2.7 92-6.2l28.5-1.8 3.6-.4v-27.2l-3.8-2.6c-8.2-5.3-17.4-14.6-23-23.2-6.5-9.7-10-18-12.2-28.7-2.8-13.5-2.6-24.7.7-38 6.3-26 26-48 51.4-57.7 10-3.8 17-5 29.5-5 12.6 0 19.5 1.2 29.4 5 25.3 9.7 45 31.8 51.3 57.6 3.3 13.3 3.5 24.5.7 38-2.2 10.8-5.7 19-12 28.8-5.8 8.6-15 18-23 23.2l-4 2.6v27.2l3.6.4c2 0 14.8 1 28.5 2 54.5 3.4 91.3 6 92 6 .6.3.8 6 .8 24.8 0 19-.2 24.5-.8 24.7-.4 0-7.8.7-16.4 1.2-8.5.4-32.6 2-53.4 3.4-20.7 1.3-41.3 2.6-45.8 3l-8 .4-.3 14.8v14.7l7 3.5c17.5 8.5 35.8 12 59 11.5 14.7-.4 23.6-1.5 36.8-4.8 25.6-6.4 51-18.5 73.3-35 17.4-13 35.3-31.7 48-50 1.4-2 2.8-3.7 3-3.7l8.4 5.5 15.4 10c6.4 3.8 9.6 5.6 19.7 11.3l14 7.3c47.4 23.6 95.3 36.3 137.8 36.3 6.7 0 14.8-.3 18-.6 3.4-.4 6.3-.5 6.6-.2 1 1.2-10.5 36.8-18 55.2-3.6 8.5-11.2 23.6-15 29.6-4.5 7.2-6.5 9.7-11 14.5l-3.7 3.8-4-2c-2-1.3-10.7-6-19.3-10.2-20-10-33.7-17.3-43-23l-8-4.5c-1-.5-15.8-10-22.4-14.6-15.4-10.3-42.5-32-59.4-47-3-3-6.7-6-8-7L776 367l-6 6c-15 15.3-34 30.4-50.7 39.7-26.6 15-52.7 23.2-87 27.4-7 .8-37.4 1-64 .5-13.3-.4-14-.3-16.4 1-6 3-7.6 7.2-8.5 20.8-.4 5.6-.6 45.7-.4 106.2l.3 97 1.6 7.6c5 22 11.4 36.3 21.3 46.2 9 9.2 20.6 14 35.2 15 13.7 1 50.3-4.6 75-11.3 42.8-11.5 71.8-31 84.7-56.7 8.7-17.3 11-32.8 8.2-56-1-9.7-6.6-29.8-10.8-39.2l-1-2-8.8 4c-11 4.8-11.4 5-12.2 4-.4-.5-1.2-3.2-2-6.2-.6-3-3.6-14.8-6.6-26.5l-14-54.4-1.5-6.7 1-9.6c1.7-14.4 4.2-33.7 4.5-34.6.2-.5 7 2.6 20.7 9.5l20.5 10.2 8.3 12.7c4.6 7 11 16.7 14 21.6l28.4 43.4c3.7 5.7 4.4 7 3.7 7.8-.8.8-12 5.8-16.6 7.5-1.4.5-2.7 1-2.8 1.5-.2.2 1 3.3 2.5 7 8.5 19 13.6 40.2 14.4 60.5 1 25.5-3.4 47-14.3 69.4-14 28.7-40.6 54.3-74.3 71.8-10.8 5.6-26.2 12-38.7 16-15.2 4.8-28.4 8-52.8 12.2-50 9-83 24.3-100.8 47.4-7 9.2-11.6 18-17 32.8-8 22.8-11.3 30.6-12.7 30.6-.3 0-1.5-1.6-2.5-3.8zm12.8-666.6c9.2-2 19.5-8.4 25.5-15.8 20.6-25.6 9-63.8-22-73.7-4.8-1.6-6.4-1.8-13.8-1.8s-9 .2-13.7 1.7c-22.7 7-36 29.7-31.5 53.2 2 10.6 8.6 21.6 16.7 27.6 5 3.7 12.8 7.5 18 8.5 5.3 1.2 15.4 1.2 20.8 0z'%3E%3C/path%3E%3Cpath fill='aquamarine' d='M373 593.4c-.5-.7.4-6 5-29.8 2-11.3 5-26.5 9.5-51.5l5-26.4 3-16.3.5-3 4.6-.5c2.6-.2 12-.4 21-.5h16.5l.6 1.4c.4.8 1 10.3 1.7 21 .5 11 2 38.8 3.5 62 1.3 23.5 2.2 42.7 2 43-1 .8-72.4 1.5-73 .7zM575 593.5c-10.5 0-19.5-.4-19.8-.8-.2-.2.7-19.5 2-43 1.4-23.2 3-51 3.5-62 .6-10.7 1.3-20.2 1.7-21l.5-1.4h16.3c9 0 18.5.3 21 .5l4.7.4.5 3 3 16.4 5 26.5 9.6 51.6c4.6 23.5 5.5 29 5 29.7 0 .4-6.4.6-17 .5l-36-.3zM342.3 590.2c-20.8-3-54-7.4-57.7-8-1.6 0-3.2-.3-3.6-.4-.8-.3 1.6-7.3 17-52l7.5-21.7 7-21c3.3-9 7-20.2 8.7-24.8 1.5-4.7 3-8.7 3.2-9 .2 0 7 1 15 2.8 8 1.6 17.2 3.5 20.3 4 3 .7 5.6 1.5 5.8 2 .2.4-.7 24-2 52.4-1 28.4-2.4 57.4-2.6 64.4-.3 8-.7 12.8-1.2 13.2-.4.3-7.7-.5-17.5-1.8zM641 591.8c-.3-.4-.7-6.3-1-13.2l-2.6-64.2c-1.2-28.4-2-52-2-52.4.3-.5 3-1.3 6-2l20-4c8.2-1.7 15-3 15.2-2.7.2.2 1.7 4.2 3.2 9l8.6 24.8 7 21c1 2.5 4.3 12.3 7.6 22 13.8 39.6 17.7 51.4 17.3 51.7-.2 0-2 .4-4.2.6l-21.7 3L660 590c-9 1-16.8 2.2-17.3 2.3-.6 0-1.3 0-1.6-.5zM161 527.5c-5.5-4-14.3-11-19.7-15.4l-17.5-13.6c-9.2-7-18.4-14.6-18.4-15 0-.3 4-3.6 8.6-7.3l30.4-23.8L155 444c15-12 45.4-36 47.5-37.4 3.4-2.6 6.5-5 13-10.3l6-4.8 1.6 1.4c.8.7 7 7.4 13.4 14.7l12 13.2-2.4 3.6-17.3 25.7-21.6 32c-3.6 5.6-13 19.7-21 31.3-7.7 11.7-14.4 21.3-14.7 21.4-.4 0-5-3.2-10.4-7.5zM828.3 533.5L815 513.7 795 484l-22.7-33.7-17.3-25.7-2.4-3.7 12-13.3L778 393l1.4-1.5 6 4.8 13 10.3c2.2 1.5 32.6 25.4 47.7 37.4l10.6 8.2c2.3 1.7 17.4 13.6 30.4 24 4.7 3.6 8.6 7 8.6 7.2 0 .4-9.2 8-18.4 15L859.7 512c-21 16.7-29.4 23.2-29.8 23.2-.3 0-1-.7-1.7-1.7zM87 347.4c-.5-1 11-28.2 18.5-43.2 11-22 17.7-33.4 34.3-57.8 2.8-4.2 15-20.5 18.3-24.3 26-31 52-55.8 80-76.6 4.2-3 4-3 12.3-8.6C311.5 94.4 382.7 68.2 456 61.2c66.8-6.4 133 1.6 194 23.6 35.2 12.7 69.6 30.4 100.7 52l12.2 8.6c28 20.8 54 45.7 80 76.7 3 4 15.4 20.2 18.2 24.4 23.6 35 37 59.7 51.4 96.5 1 2.4 1.4 4.2 1 4.5-1 1-21.8-5-33-10l-5.6-2.2-2.3-5c-20.6-45-49-85.8-83.5-120.2-15-14.7-28.4-26.5-43-37.3l-9.8-7.2c-1.2-1-5.8-4-10.3-7-56.7-37.4-119.3-59.4-187.6-66-16-1.5-59.7-1.5-75.8 0-48.8 4.7-93.4 17-136.8 37.4-20.5 9.6-47.6 25.3-61.2 35.5-1.2 1-5.6 4-9.7 7.2-52 38.4-95.5 91.8-123.7 151.3-3.7 7.6-5.7 11.2-6.7 11.8-3.7 2-15 6-24.5 9-10.2 3-12.4 3.5-13 2.6z'%3E%3C/path%3E%3C/g%3E%3C/svg%3E");
                position: fixed;
                z-index: -1;
                pointer-events: none;
                bottom: 0;
                right: 0;
                width: 40vw;
                height: 40vw;
                transform: translate(15%, 15%) rotate(-9deg);
                fill: aquamarine;
                opacity: 0.1;
            }
            .things-list {
                -webkit-appearance: none;
                appearance: none;
                display: block;
                margin: 16px;
                padding: 0.5em;
                background-color: aquamarine;
                border: 0;
                border-radius: 5px;
            }
            .things-list:not(:focus) {
                color: cadetblue;
            }
            .things-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 10px 5px;
                padding-left: 16px;
            }
            .things-grid a {
                display: block;
                margin-top: 5px;
                padding: 8px;
                font-size: 16px;
                font-weight: bold;
                text-decoration: none;
                color: teal;
            }
            .things-grid li {
                position: relative;
                list-style: none;
                min-width: 0;
            }
            .things-grid div {
                pointer-events: none;
                width: 250px;
                height: 141px;
                padding: 0;
                overflow: hidden;
                border: 1px solid teal;
                opacity: 0.15;
                transition: opacity .3s;
            }
            .things-grid span {
                font-size: 20px;
            }
            .things-grid li:focus-within div,
            .things-grid li:hover div {
                opacity: 1;
            }
            .things-grid iframe {
                width: 960px;
                height: 540px;
                border: 1px solid black;
                transform: scale(0.260416667);
                transform-origin: 0 0;
            }
        </style>
    <?php endif; wp_reset_query(); ?>
    <script>
        window.addEventListener('load', () => {
            // handle quick links
            const quickSelect = document.querySelector('.things-list');
            if (quickSelect) {
                quickSelect.focus();
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter') {
                        if (quickSelect.value) {
                            window.location = quickSelect.value
                        }
                    } else if (e.key !== 'Tab' && e.key !== 'Shift') {
                        quickSelect.focus();
                    }
                });
            }

            // lazy load iframes
            const iframes = document.querySelectorAll('iframe');
            let focusTracker = document.activeElement;
            // start loading the first iframe
            iframes[0]?.setAttribute('src', iframes[0].dataset.src);
            for (let i = 0; i < iframes.length; i++) {
                // on load of each iframe
                iframes[i].addEventListener('load', () => {
                    iframes[i].classList.add('is-loaded');
                    // if we have a "next" iframe
                    if (iframes[i+1]) {
                        // if this isn't already loading
                        if (!iframes[i+1].src) {
                            // load this iframe
                            iframes[i+1].setAttribute('src', iframes[i+1].dataset.src);
                            if (i !== iframes.length - 2) {
                                // prevent getting hung up on slow-loading iframes
                                clearTimeout(iframes[i].timer);
                                iframes[i+1].timer = setTimeout(() => {
                                    console.error(`iframe ${i+1} took too long to load: skipping for now`, iframes[i+1])
                                    window.frames[i+1].stop()
                                    iframes[i+1].classList.add('is-delayed');
                                    if (iframes[i+2] && !iframes[i+2].src) {
                                        iframes[i+2].setAttribute('src', iframes[i+2].dataset.src);
                                    }
                                }, 5000);
                            // if this is the last iframe then try to reload any that we delayed due to slowness
                            } else {
                                for (let j = 0; j < iframes.length; j++) {
                                    clearTimeout(iframes[j].timer);
                                    if (iframes[j].classList.contains('is-delayed')) {
                                        console.error(`attempting to reload slow iframe ${j}`, iframes[j])
                                        iframes[j].setAttribute('src', iframes[j].dataset.src);
                                    }
                                }
                            }
                        }
                        // prevent focus from occurring within this iframe (e.g. wp's password protected field)
                        if (document.activeElement.classList.contains('things-control')) {
                            focusTracker = document.activeElement;
                        } else {
                            focusTracker.focus();
                        }
                    }
                });
            }
        })
    </script>
<?php wp_footer(); ?>
</body>
</html>
