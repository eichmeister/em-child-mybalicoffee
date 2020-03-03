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

	<div class="wrapper-1200 padding-bot-50">

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

<div id="mybali-newsletter-overlay" class="overlay-full" data-open="auto" data-open-delay="15000">
    <div class="box wrapper-800">
        <div class="header">
            <a href="#" class="close-overlay"><i class="fa fa-close"></i></a>
        </div>
        <div class="content">

        	<h4 class="center margin-top-15">
				Sichere dir jetzt 10% Rabatt
        	</h4>

        	<div class="row">
        		<div class="col_3">

					<figure class="margin-top-25">
		        		<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/mybalicoffe_signet_blue.png" />
		        	</figure>

				</div>
				<div class="col_9">

					<div class="margin-ver-25">
						Newsletter abonnieren und <strong>sofort sparen</strong>
					</div>

					<?php 

					// DEV ENVIRONMANT
					// echo do_shortcode('[contact-form-7 id="581" title="Newsletter GetResponse"]');

					// LIVE ENVIRONMENT
					echo do_shortcode('[contact-form-7 id="1727" title="Newsletter GetResponse"]');

					?>

				</div>
			</div>

			</div>

        </div>
    </div>
</div>

<?php get_footer(); ?>