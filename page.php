<?php get_header(); ?>

<!-- Page.php -->
<div class="wrapper-1200 em-txt">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <?php the_content(); ?>
        	
    <?php endwhile; endif; ?>

</div>

<?php // get_sidebar(); ?>

<?php get_footer(); ?>