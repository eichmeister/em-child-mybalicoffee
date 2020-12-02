<?php
/*
Template Name: MyBali - Locations
*/
?>

<?php get_header(); ?>

<?php
$google_maps = array();

$place_terms = get_terms( array(
    'taxonomy' => 'place',
    'hide_empty' => false,
) );

$locations = array();


foreach ( $place_terms as $term ) {

    $place_group_query = new WP_Query( array(
        'post_type' => 'merchant',
        'meta_query' => array(
            array(
                'key' => 'place',
                'value' => array( $term->term_id ),
            )
        ),
        'posts_per_page' => -1
    ) );

    if ( $place_group_query->have_posts() ):

    	while ( $place_group_query->have_posts() ) : $place_group_query->the_post(); 

    		$google_maps[] = array('title' => get_the_title(), 'location' => get_field('google_maps') ); 

    		$locations[$term->name][] = array(
    			"name" => get_the_title(),
    			"address" => get_field("address"),
    			"zip_code" => get_field("zip_code"),
    			"place" => get_term( get_field('place'), 'place' )->name
    		);

    	endwhile;

	endif;

	wp_reset_postdata();
}
?>

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
	<div class="wrapper-1200 padding-bot-150">
		
		<h2 class="hl-4 margin-bot-50 center">
			<?php echo first_line_bold( get_field('cafes_hl') ); ?>
		</h2>

		<?php

		$count_posts = wp_count_posts('location');
		$location_count = $count_posts->publish;

		if ( $location_count > 0 ):

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

		else:

			echo '<div class="coming-soon">Coming Soon</div>';

		endif;

		?>

	</div>
</section>

<section id="maps">
	<div class="wrapper-1200 padding-bot-50">

		<div class="google-maps">

			<?php

	        EM()->Load( array(
	            'tpl' => 'google_maps',
	            'locations' => $google_maps
	        ) );

	        ?>

	    </div>

	</div>
</section>

<section id="merchants">
	<div class="wrapper-1200 padding-bot-50">
		
		<h2 class="hl-4 margin-bot-50 center">
			<?php echo first_line_bold( get_field('merchants_hl') ); ?>
		</h2>

		<div class="em-masonry margin-bot-50">
			<?php foreach ($locations as $location => $places ) { ?>

				<div class="em-masonry-item">
				    <h3><?php echo $location; ?></h3>

				    <ul>
					    <?php foreach ($places as $place) { ?>

					        <li>
					        	<strong><?php echo $place["name"]; ?></strong>
					        	<div><?php echo $place["address"]; ?> <?php echo $place["zip_code"]; ?>, <?php echo $place["place"]; ?></div>
				        	</li>
					    
					    <?php } ?>
					</ul>
				</div>

			<?php } ?>
		</div>

	</div>
</section>

<section id="contact">
	<div class="wrapper-1200 padding-bot-50">

		<div class="contact">

			<h2 class="hl-4 margin-bot-50 center">
				<?php echo first_line_bold( get_field('contact_hl') ); ?>
			</h2>

			<?php echo do_shortcode('[contact-form-7 id="437" title="Kooperationsanfrage"]'); ?>

		</div>

	</div>
</section>

<?php get_footer(); ?>