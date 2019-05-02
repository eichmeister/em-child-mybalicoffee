<?php 
/**
 * The template for displaying product archive page
 *
 * @see https://mybali-coffee.de
 */

defined( 'ABSPATH' ) || exit;

?>

<?php if ( woocommerce_product_loop() ) { ?>

	<div class="shop-header em-wc-wrapper">
		<?php em_wc_sidebar(); ?>
	</div>

	<div class="products-wrapper em-wc-wrapper">
		<div class="products row">

			<?php
			if ( wc_get_loop_prop( 'total' ) ) {
				while ( have_posts() ) {
					the_post();
					/**
					 * Hook: woocommerce_shop_loop.
					 *
					 * @hooked WC_Structured_Data::generate_product_data() - 10
					 */
					do_action( 'woocommerce_shop_loop' );


					global $product;
					// Ensure visibility.
					if ( ! empty( $product ) || $product->is_visible() ) {
						include( get_product_tile() );
					}
				}
			}
			?>

		</div>
	</div>

<?php woocommerce_pagination(); ?>

<?php } else { ?>

	<?php wc_no_products_found(); ?>

<?php } ?>



<div class="em-wc-wrapper padding-top-100 padding-bot-50">

		<?php 
		$items = get_field( 'clone', wc_get_page_id('shop') )['items'];
		include_once( locate_template("includes/em-module-content-repeater.php") );
		?>
	
</div>