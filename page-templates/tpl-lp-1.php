<?php
/*
Template Name: MyBali - LP 01
*/
?>

<?php get_header(); ?>

<section id="intro">
		
	<?php
	
	$contents = get_field('hero_contents');
	$contents['hero_teaser_img'] = get_field('hero-teaser-image');
	$contents['hero_teaser_link'] = get_field('hero-teaser-link');

	EM()->load( array(
		'tpl' => 'hero_simple',
		'contents' => $contents,
		'height' => get_field('hero_height'),
		'bg_id' => 'intro-bg',
		'hl_tag' => 'h1',
		'tpl_suffix' => '-mybali'
	) );

	?>
</section>

<section id="teaser1">

	<div class="wrapper-1200 padding-top-200">

		<?php 

		$items = get_field( 'teaser_1' )['items'];
		include_once( locate_template("includes/em-module-content-repeater.php") );

		?>
		
	</div>

</section>

<section id="products">

	<div class="wrapper-1200 padding-top-100">

		<?php

		EM()->load( array(
            'tpl' => 'posts_grid',
            'posts' => get_field('products'),
            'layout' => 'grid',
            'columns' => 3,
        ) );

		?>

	</div>

</section>
	

<?php get_footer(); ?>