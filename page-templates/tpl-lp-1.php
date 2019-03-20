<?php
/*
Template Name: CHILD - TPL LP 01
*/
?>

<?php get_header(); ?>

<section id="intro">
		
	<?php EM()->Template->hero_simple( get_field('intro_hero')['contents'], get_field('intro_hero')['height'] ); ?>

</section>

<?php get_footer(); ?>