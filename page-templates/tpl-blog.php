<?php
/*
Template Name: MyBali - Blog
*/
?>

<?php get_header(); ?>

<section id="intro">
        
    <?php

    EM()->load( array(
        'tpl' => 'hero_simple',
        'contents' => get_field('hero_contents'),
        'height' => get_field('hero_height'),
        'bg_id' => 'intro-bg',
        'hl_tag' => 'h1',
        'tpl_suffix' => '-mybali'
    ) );

    ?>

</section>

<section id="blog">
    <div class="wrapper-1200 padding-bot-100">

	<?php

    $posts_per_page = 18;
    $offset_init = 18;
    $published_post_count = wp_count_posts('post')->publish;

    if ( $published_post_count < $posts_per_page ) $offset_init = $published_post_count;

    EM()->load( array(
        'tpl' => 'posts_grid',
        'posts' => get_posts( array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => 18,
            'fields' => 'ids'
        ) ),
        'post_count' => $published_post_count,
        'layout' => 'grid',
        'columns' => 2,
        'load_more' => array(
            'offset_init' => $offset_init,
            'offset' => 18,
        ),
        'filters' => array(
            'taxonomy' => 'category',
        ),
    ) ); 

    ?>

    </div>
</section>

<?php get_footer(); ?>