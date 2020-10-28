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

<?php if ( is_user_logged_in() ): ?>
	<?php if ( current_user_can( 'edit_pages' ) ): ?>
		<?php if ( get_field('video') ): ?>
			
			<section id="video-teaser">
				<div class="wrapper-800 padding-ver-50">

					<div class="video-container">
						<?php the_field('video'); ?>
					</div>

				</div>
			</section>
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>

<?php if ( is_user_logged_in() ): ?>
	<?php if ( current_user_can( 'edit_pages' ) ): ?>

		<section id="testimonials">
			<div class="wrapper-800 padding-ver-100">

				<h2 class="hl-4 center">
					<?php echo first_line_bold( get_field('testimonials_hl') ); ?>
				</h2>

				<?php
				EM()->load( array(
					'tpl' => 'posts_grid',
					'posts' => get_field('testimonials'),
					'layout' => 'slider',
					'columns' => 1,
					//'post_tpl_suffix' => 'photo'
				) );
				?>

			</div>
		</section>

	<?php endif; ?>
<?php endif; ?>

<section id="teaser1">
	
	<div class="wrapper-1200 padding-ver-50">

		<?php 

		$items = get_field( 'teaser_1' )['items'];
		include( locate_template("includes/em-module-content-repeater.php") );

		?>
		
	</div>
	
</section>

<section id="products">

	<div class="wrapper-1200 padding-bot-50">

		<h2 class="hl-2 center">
			<?php echo first_line_bold(get_field('products_hl')); ?>
		</h2>

		<div class="row">

			<?php

			foreach ( get_field('products') as $em_post_id) {
				include( get_product_tile() );
			}
			?>

		</div>

		<a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" class="btn-line-left">ALLE PRODUKTE</a>
		
	</div>

</section>

<section id="newsletter">

	<div class="wrapper-800 padding-ver-100">
		<div class="row">

			<div class="col_12">
				<h2 class="hl-2 center">
					<?php echo first_line_bold( get_field('newsletter_hl') ); ?>
				</h2>
			</div>

			<div class="col_12">
				<?php if( get_field('newsletter_sub_hl') ): ?>
					<p class="sub"><?php the_field('newsletter_sub_hl'); ?></p>
				<?php endif; ?>

				<?php echo do_shortcode('[contact-form-7 id="1727" title="Newsletter GetResponse"]'); ?>
			</div>

		</div>
	</div>

</section>

<section id="instagram">

	<div class="wrapper-1200 padding-bot-50">

		<?php 
		$items = get_field( 'teaser_2' )['items'];
		include( locate_template("includes/em-module-content-repeater.php") );

		?>
		
	</div>

	<div class="wrapper-1200 padding-bot-50">


		<h2 class="hl-2 center">
			<?php echo first_line_bold(get_field('instagram_hl')); ?>
		</h2>

		<div class="center margin-top-25 margin-bot-50">
			<a href="<?php echo get_field('social_link')['url']; ?>" target="<?php echo get_field('social_link')['target']; ?>" class="txtlink">
				<?php echo get_field('social_link')['title']; ?>
			</a>
		</div>

		<div class="instafeed">
			<?php echo do_shortcode('[wdi_feed id="1"]'); ?>
		</div>
		
	</div>

</section>

<?php get_footer(); ?>