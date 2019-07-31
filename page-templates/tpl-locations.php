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
	<div class="wrapper-1200 padding-bot-150">
		
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
	<div class="wrapper-1200">
		
		<h2 class="hl-4 margin-bot-50 center">
			<?php echo first_line_bold( get_field('merchants_hl') ); ?>
		</h2>

		<div class="em-masonry margin-bot-50">

			<?php

			$google_maps = array();

			$place_terms = get_terms( array(
			    'taxonomy' => 'place',
			    'hide_empty' => false,
			) );

			foreach ( $place_terms as $term ) {
		    
			    $place_group_query = new WP_Query( array(
			        'post_type' => 'merchant',
			        'meta_query' => array(
			            array(
			                'key' => 'place',
			                'value' => array( $term->term_id ),
			            )
			        )
			    ) );

			    ?>

			    <div class="em-masonry-item">

				    <h3>
				    	<?php echo $term->name; ?>
			    	</h3>
				    
				    <ul>
					    
					    <?php 

					    if ( $place_group_query->have_posts() ) : while ( $place_group_query->have_posts() ) : $place_group_query->the_post(); 

					    	$google_maps[] = array('location' => get_field('google_maps')); 

					   	?>
					        
					        <li>
					        	<strong><?php echo the_title(); ?></strong>
					        	<div><?php the_field('address'); ?> <?php the_field('zip_code'); ?>, <?php echo get_term( get_field('place'), 'place' )->name; ?></div>
				        	</li>

					    <?php endwhile; endif; ?>	
				    
				    </ul>

				</div>

			<?php

			}

			wp_reset_postdata();

			?>

		</div>

	</div>
</section>

<section id="google-maps-contact">
	<div class="wrapper-1200 padding-bot-50">

		<div class="google-maps">

			<?php

	        EM()->Load( array(
	            'tpl' => 'google_maps',
	            'locations' => $google_maps
	        ) );

	        ?>

	    </div>

		<div class="contact">

			<h2 class="hl-4 margin-bot-50 center">
				<?php echo first_line_bold( get_field('contact_hl') ); ?>
			</h2>

			<?php echo do_shortcode('[contact-form-7 id="437" title="Kooperationsanfrage"]'); ?>

		</div>

	</div>
</section>

<?php get_footer(); ?>