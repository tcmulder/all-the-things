<!DOCTYPE html>
<html>
<head>
    <title></title>
    <?php wp_head(); ?>
</head>
<body>
    <?php query_posts('posts_per_page=999&post_type=all-the-things&orderby=title&order=ASC'); ?>
    <?php if(have_posts()) : ?>
        <ul class="things">
            <?php while(have_posts()) : the_post(); ?>
                <li class="things__pattern">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php endif; wp_reset_query(); ?>
<?php wp_footer(); ?>
</body>
</html>
