<?php
/*
Template Name: MyBali - Engagement
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

<section id="news">

	<div class="wrapper-1200 padding-ver-100">

		<h2 class="hl-2 center">
			<?php echo first_line_bold(get_field('news_hl')); ?>
		</h2>
		
		<?php

		// FETCH 4 MOST RECENT BLOG POSTS OF CATEGORY ENGAGEMENT

		EM()->load( array(
			'tpl' => 'posts_grid',
			'posts' => get_posts( array(
				'post_type' => 'post',
				'post_status' => 'publish',
				'posts_per_page' => 4,
				'orderby'  => 'date',
				'order'    => 'DESC',
				'fields' => 'ids',
				'category' => 120
			) ),
			'layout' => 'grid',
			'columns' => 2,
		) ); 

		?>

		<div class="col_12 btn-wrapper"><a href="/blog/" class="btn-line-left">Alle Beiträge</a></div>
	</div>

</section>


<?php get_footer(); ?>