<?php get_header(); ?>

<?php if ( is_checkout() || is_cart() || is_account_page() ) { ?>
	<div class="wrapper-1200">
<?php } else { ?>
	<div class="wrapper-1200 em-txt padding-top-50">
<?php } ?>
<!-- Page.php -->

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <?php the_content(); ?>
        	
    <?php endwhile; endif; ?>

</div>

<?php // get_sidebar(); ?>

<?php get_footer(); ?>