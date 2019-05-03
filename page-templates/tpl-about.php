<?php
/*
Template Name: MyBali - About
*/
?>

<?php get_header(); ?>

<section id="intro" class="padding-bot-50">
		
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

<section id="content">

	<div class="wrapper-800 padding-bot-50">
		<p>
			<?php the_field('hero-teaser-txt'); ?>
		</p>
	</div>
	
</section>

<section id="teaser">

	<div class="wrapper-1200 padding-ver-50">

		<?php 

		$items = get_field( 'content' )['items'];
		include( locate_template("includes/em-module-content-repeater.php") );

		?>
		
	</div>

</section>

<section id="contact">

	<div class="wrapper-1200 padding-ver-50">


		<h2 class="center first-line-bold">
			<?php the_field('contact_hl'); ?>
		</h2>

		<?php echo do_shortcode('[contact-form-7 id="118" title="Kontaktformular 1"]'); ?>
		
	</div>

</section>

<?php get_footer(); ?>