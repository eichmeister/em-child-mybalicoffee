<?php

defined( 'ABSPATH' ) || exit;

$checkout_validation = false;

?>

<div class="logo-wrapper">
    <img src="<?php echo em_theme_info()['logo_header']; ?>" class="logo" />
</div>

<div class="row">

	<div class="col_6">
		<h4 class="hl hl-4 order-overview"><?php _e( 'Order overview', 'eichmeister'); ?></h4>
	</div>

	<div class="col_6">
		<button type="button" name="em_send_order" class="em_send_order_top button"><?php _e( 'Buy now', 'eichmeister'); ?></button>
	</div>

	<div class="col_12 widerruf">
		<?php 
		$widerrufsbelehrung_page_id = get_field( 'checkout_widerrufsbelehrung', 'option' );
		$widerrufsbelehrung_permalink = esc_url( get_the_permalink( $widerrufsbelehrung_page_id ) );
		?>

		<a href="<?php echo $widerrufsbelehrung_permalink; ?>" target="_blank" class="">Widerrufsbelehrung</a>
	</div>
</div>

<div class="table-wrapper">
	<?php include_once ( locate_template( "plugins/woocommerce/templates/em-review-order.php" ) ); ?>
</div>

<button type="button" class="close-overlay button"><?php _e( 'Edit order', 'eichmeister'); ?></button>

<button type="button" name="em_send_order" class="em_send_order button"><?php _e( 'Buy now', 'eichmeister'); ?></button>

