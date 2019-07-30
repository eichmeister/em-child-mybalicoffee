<?php
/*
Template Name: MyBali - Locations
*/
?>

<?php if ( !is_user_logged_in() ) exit; ?>

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

<section id="cafes">
	<div class="wrapper-1200 padding-top-50 padding-bot-100">
		
		<h2 class="hl-4 margin-bot-50 center">
			<?php echo first_line_bold( get_field('cafes_hl') ); ?>
		</h2>

		<?php

		$args = array(
			'post_type' => 'location',
			'post_status' => 'publish',
			'posts_per_page' => -1
		);

		EM()->load( array(
			'tpl' => 'posts_grid',
			'posts' => get_posts( $args ),
			'layout' => 'grid',
            'columns' => 2,
		) );

		?>

	</div>
</section>

<section id="merchants">
	<div class="wrapper-1200 padding-ver-100">
		
		<h2 class="hl-4 margin-bot-50 center">
			<?php echo first_line_bold( get_field('merchants_hl') ); ?>
		</h2>

		<?php

		$place_terms = get_terms( array(
		    'taxonomy' => 'place',
		    'hide_empty' => false,
		) );

		foreach ( $place_terms as $term ) {
	    
		    $member_group_query = new WP_Query( array(
		        'post_type' => 'merchant',
		        'tax_query' => array(
		            array(
		                'taxonomy' => 'place',
		                'field' => 'slug',
		                'terms' => array( $term->slug ),
		                'operator' => 'IN'
		            )
		        )
		    ) );

		    ?>

		    <h2><?php echo $term->name; ?></h2>
		    
		    <ul>
			    <?php
			    if ( $member_group_query->have_posts() ) : while ( $member_group_query->have_posts() ) : $member_group_query->the_post(); ?>
			        <li><?php echo the_title(); ?></li>
			    <?php endwhile; endif; ?>	
		    </ul>

		    <?php

		}

		wp_reset_postdata();

		?>

	</div>
</section>

<section id="contact">
	<div class="wrapper-1200 padding-ver-50">

		<h2 class="hl-4 margin-bot-50 center">
			<?php echo first_line_bold( get_field('contact_hl') ); ?>
		</h2>

		<?php echo do_shortcode('[contact-form-7 id="118" title="Kontaktformular 1"]'); ?>
		
	</div>
</section>

<?php get_footer(); ?>