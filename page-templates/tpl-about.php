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

<?php if ( is_user_logged_in() ): ?>
	<?php if ( current_user_can( 'edit_pages' ) ): ?>

		<section id="team">

			<div class="wrapper-1200">
				
				<div class="row">
					<div class="col_12">
						<h2 class="hl-4 center">
							<?php echo first_line_bold( get_field('team_hl') ); ?>
						</h2>
					</div>
				</div>
				
				<div class="row teamrow">

					<?php $i = 0; ?>	
					<?php if ( have_rows('team') ): ?>
						<?php while (have_rows('team')) : the_row(); ?>

							<div class="col_4">

								<figure <?php EM()->Template->bg_cover(get_sub_field('img'), 'img_800'); ?>></figure>

								<div class="inner">
                                    <h4 class="hl4"><?php the_sub_field('name'); ?></h4>
									<p><?php the_sub_field('role'); ?></p>
								</div>

							</div>

							<?php $i++; ?>
						<?php endwhile; ?>
					<?php endif; ?>

				</div>
			</div>

		</section>

	<?php endif; ?>
<?php endif; ?>

<section id="contact">

	<div class="wrapper-1200 padding-ver-50">


		<h2 class="hl-4 center">
			<?php echo first_line_bold( get_field('contact_hl') ); ?>
		</h2>

		<?php echo do_shortcode('[contact-form-7 id="118" title="Kontaktformular 1"]'); ?>
		
	</div>

</section>

<?php get_footer(); ?>