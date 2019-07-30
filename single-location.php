
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

<section id="infos">
	<div class="wrapper-1200 padding-bot-50">
	
		<div class="row">
			<div class="col_4 col-left">
				<div class="inner">

					<h2>
						<?php the_title(); ?>
					</h2>

					<div class="address">
						<h3>
							<?php _e('Adresse & Kontakt', 'eichmeister'); ?>
						</h3>
						<?php the_field('address'); ?><br />
						<?php the_field('zip_code'); ?> <?php echo get_term( get_field('place'), 'place' )->name; ?>

					</div>

					<?php if ( get_field('phone') || get_field('email') ): ?>
						<div class="contact">
							<a href="tel:<?php the_field('phone'); ?>">
								<?php the_field('phone'); ?>
							</a>
							<a href="mailto:<?php the_field('email'); ?>">
								<?php the_field('email'); ?>
							</a>
						</div>
					<?php endif; ?>

					<?php if ( have_rows('opening_times') ): ?>
						<h3>
							<?php _e('Öffnungszeiten', 'eichmeister'); ?>
						</h3>
						<div class="opening-times">
							<?php while ( have_rows('opening_times') ): the_row(); ?>
								<strong><?php the_sub_field('caption'); ?></strong>
								<?php the_sub_field('time'); ?>
							<?php endwhile; ?>
						</div>
					<?php endif; ?>

				</div>
			</div>
			<div class="col_8 col-right">

				<?php

				EM()->Load( array(
					'tpl' => 'google_maps',
					'locations' => array('locations' => array('location' => get_field('google_maps') ) )
				) );

				?>
				
			</div>
		</div>

	</div>
</section>

<section id="gallery">
	<div class="wrapper-1200 padding-bot-50">

		<?php 

		$images = get_field('gallery_photos');
		$size = 'landscape_800';

		if( $images ): ?>
		    <div class="row">
		        <?php foreach( $images as $image ): ?>
		            <div class="col_6">
		            	<a href="<?php echo $image['sizes']['img_1200']; ?>" class="em-photo em-swipebox" rel="gallery-1">
		            		<?php echo wp_get_attachment_image( $image['ID'], $size ); ?>
		            	</a>
		            </div>
		        <?php endforeach; ?>
		    </div>
		<?php endif; ?>

	</div>
</section>

<?php if( have_rows('menu_highlights') ): ?>

	<section id="menu-highlights" class="">
		<div class="wrapper-1200">

			<h2 class="hl-2">
				<?php _e('Menü Highlights'); ?>
			</h2>

			<?php while ( have_rows('menu_highlights') ) : the_row(); ?>

				<div class="item">
					<strong>
						<?php the_sub_field('hl'); ?>
					</strong>
					<div>
						<?php the_sub_field('txt'); ?>
					</div>
				</div>

			<?php endwhile; ?>
			
		</div>
	</section>

<?php endif; ?>

<?php get_footer(); ?>