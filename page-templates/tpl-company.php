<?php
/*
Template Name: MyBali - Company
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

<section id="product-showcase">

	<div class="wrapper-1200 padding-ver-50">
		<div class="row">
		
			<?php if ( have_rows('products') ): ?>
				<?php while ( have_rows('products') ) : the_row(); ?>

						<div class="col_6" style="background-color:<?php the_sub_field('color'); ?>">

							<figure>
								<?php if(get_sub_field('stamp')): ?>
									<div class="stamp"><?php echo wp_get_attachment_image( get_sub_field('stamp')['ID'], 'img_500' ); ?></div>
								<?php endif; ?>
								<?php echo wp_get_attachment_image( get_sub_field('img')['ID'], 'img_800' ); ?>
							</figure>

							<div class="content">
								<h4><?php the_sub_field('type'); ?></h4>
								<h3><?php the_sub_field('name'); ?></h3>
								<p><?php the_sub_field('pricing'); ?></p>
								<p class="body-txt"><?php the_sub_field('desc'); ?></p>
							</div>

						</div>

				<?php endwhile; ?>
			<?php endif; ?>
		
		</div>
	</div>

</section>

<section id="all-products">
	<div class="wrapper-1200 padding-bot-50">
		<div class="row">
		
			<div class="col_6 pattern" style="background-color:<?php the_field('all_products_color'); ?>">
				<?php echo wp_get_attachment_image( get_field('all_products_img')['ID'], 'img_1200' ); ?>
			</div>

			<div class="col_6 no-pattern" style="background-color:<?php the_field('all_products_color'); ?>">
				<a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" class="btn-line-left">Alle Produkte entdecken</a>
			</div>
		
			<div class="col_12 btn-wrapper"><a href="#contact" class="btn"><?php the_field('all_products_btn'); ?></a></div>
	
		</div>
	</div>
</section>


<section id="highlight">
	<div class="wrapper-1200 padding-ver-50">

		<h2 class="hl-2 center">
			<?php echo first_line_bold(get_field('highlight_hl')); ?>
		</h2>
		
		<div class="row">
		
			<?php if ( have_rows('repeater') ): ?>
				<?php while ( have_rows('repeater') ) : the_row(); ?>

					<div class="col_3 profiles">

						<figure <?php EM()->Template->bg_cover(get_sub_field('img'), 'img_500'); ?>></figure>

						<div class="content">
							<?php the_sub_field('txt'); ?>
						</div>

					</div>

				<?php endwhile; ?>
			<?php endif; ?>

		</div>
		
		<?php 

		$items = get_field( 'teaser_1' )['items'];
		include( locate_template("includes/em-module-content-repeater.php") );

		?>
		
	</div>
</section>

<section id="contact">

	<div class="wrapper-1200 padding-ver-100">

		<h2 class="hl-4 center">
			<?php echo first_line_bold( get_field('contact_hl') ); ?>
		</h2>

		<?php echo do_shortcode('[contact-form-7 id="118" title="Kontaktformular 1"]'); ?>

	</div>

</section>

<section id="contacts">

	<div class="wrapper-1200 padding-ver-50">
		<div class="row">
			
			<h2 class="hl-4 center">
				<?php echo first_line_bold( get_field('contacts_hl') ); ?>
			</h2>

			<?php if ( have_rows('contacts') ): ?>
				<?php while ( have_rows('contacts') ) : the_row(); ?>

					<div class="col_6">
						<div class="box">
							<figure <?php EM()->Template->bg_cover(get_sub_field('img'), 'img_1200'); ?>></figure>

							<div class="content">
								<h4><?php the_sub_field('role'); ?></h4>
								<h3><?php the_sub_field('name'); ?></h3>
								<p>Telefon:<a href="tel:<?php the_sub_field('number'); ?>"><?php the_sub_field('number'); ?></a></p>
								<a href="mailto:<?php the_sub_field('email'); ?>" class="btn-line-left">E-Mail schreiben</a>
							</div>
						</div>
					</div>

				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</div>

</section>

<?php get_footer(); ?>