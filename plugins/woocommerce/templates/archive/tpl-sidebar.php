<?php 
/**
 * The template for displaying shop sidebar
 *
 * @see https://truereligion.de
 */

defined( 'ABSPATH' ) || exit;

global $sizes_query;
$tr_data = em_get_session_data();
?>

<div id="em-shop-archive-sidebar">
	<?php
	// echo apply_filters( 'shop_sidebar_mobile_button' , sprintf('<button class="filter em-mobile-filter"><i class="fa fa-tasks"></i>Filtern</button>') );
	?>
	<span>KATEGORIEN</span>
	<?php
	$cats = get_categories(array('taxonomy' => 'product_cat'));
	$active = !is_a( get_queried_object(), 'WP_TERM' ) ? 'active' : '';
	printf( '<a class="%s" href="%s">%s</a>', $active, get_permalink( wc_get_page_id( 'shop' ) ), 'Alle');
	foreach ($cats as $cat) {
		$active = ( (get_queried_object()->term_id) == ($cat->term_id) ) ? 'active' : '';
		printf( '<a data-value="%s" data-type="%s" class="%s" href="%s">%s</a>', $cat->term_id, 'product_cat', $active, get_term_link( $cat->term_id, 'product_cat' ), $cat->name);
	}
	?>
</div>