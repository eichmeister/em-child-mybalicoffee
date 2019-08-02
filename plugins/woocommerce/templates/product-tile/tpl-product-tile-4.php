<?php
defined( 'ABSPATH' ) || exit;

global $product;

if ( isset($em_post_id) ) {
	if( empty($em_post_id)) {
		$_product = $product;
	} else {
		$_product = wc_get_product($em_post_id);
	}
} else {
	$_product = wc_get_product( get_the_ID() );
}

if ( ! $_product->is_type('variation') ) {
	if ( $_product->is_type('variable') ) {
		$variation_id = $_product->get_available_variations()[0]['variation_id'];
		$_product = wc_get_product($variation_id);
	} else {
		return;
	}
}

wp_enqueue_script( 'wc-add-to-cart-variation' );

$parent 	 = $_product->get_parent_id() ;
$em_post_id  = $_product->get_id();
$title 		 = $_product->get_title();
$price 		 = $_product->get_price_html();
$link 		 = $_product->get_permalink();
$images 	 = array();
$type 		 = $_product->get_type();
$product_tile_grid = apply_filters( 'product_tile_grid', 'col_sm_6 col_4' );


$region_field = get_field( 'gebiet_region', $parent );
$region_term_meta = get_term_meta( $region_field->term_id ); 
$region_background_color = $region_term_meta['background_color'][0]; 

$flavor_field = get_field( 'bohnenart', $parent );
$flavor_term_meta = get_term_meta( $flavor_field->term_id ); 

$product_color = get_field( 'product_color', $parent );	

?>

<div class="em-product-tile-4 em-product-tile <?php echo $product_tile_grid; ?>" data-em_post_id="<?php echo $em_post_id; ?>"<?php if ( isset($product_color) ) { echo ' style="background-color: ' . $product_color . '"'; } ?>>

	<div class="tile-loader"></div>
	<div class="content">

		<?php 
		if (isset($_product->get_data()['attributes']['pa_farbe'])) {

			$attribute = $_product->get_data()['attributes']['pa_farbe'];
			$parent = wc_get_product($_product->get_parent_id());
			$link = add_query_arg( 'attribute_pa_farbe', $attribute, $parent->get_permalink() );
            foreach ($parent->get_gallery_image_ids() as $attachment_id) {
            	if ( !empty( get_field('img_color', $attachment_id, false) ) ) {
            		$img_color = get_term( get_field('img_color', $attachment_id, false), 'pa_farbe' )->slug;
                    if ( $attribute == $img_color ) {
                    	$images[$em_post_id] = $attachment_id;
                    	break;
                    }
            	}
            }
            $new_images = !empty($images) ? $images : array();
			echo em_display_images_lazyload( $link, $new_images );

		} else {

			$parent = wc_get_product($_product->get_parent_id());
			$link = $parent->get_permalink();

			if ( $_product->get_image_id() ) {
				$new_images = array( $_product->get_image_id() );
				array_push($new_images, $parent->get_gallery_image_ids());
			} else {
				$new_images = $parent->get_gallery_image_ids();
			}

			echo em_display_images_lazyload( $link, $new_images );
		}
		?>
		<div class="description">
			<div class="wrapper">

				<span class="flavor">
			        <?php if ( get_field('product_template') == 1 ): ?>
			        	<?php echo $flavor_field->name; ?>
			        <?php else: ?>
						&nbsp;
			        <?php endif; ?>
			    </span>

		        <span class="title"><?php echo $title; ?></span>

				<?php if ( get_field('product_settings_availability', $_product->get_parent_id()) ): ?>

					<?php
				    if( $parent->is_type('variable') ){
				        $default_attributes = $parent->get_default_attributes();
				        foreach($parent->get_available_variations() as $variation_values ){
				            foreach($variation_values['attributes'] as $key => $attribute_value ){
				                $attribute_name = str_replace( 'attribute_', '', $key );
				                $default_value = $parent->get_variation_default_attribute($attribute_name);
				                if( $default_value == $attribute_value ){
				                    $is_default_variation = true;
				                } else {
				                    $is_default_variation = false;
				                    break; // Stop this loop to start next main lopp
				                }
				            }
				            if( $is_default_variation ){
				                $variation_id = $variation_values['variation_id'];
				                break; // Stop the main loop
				            }
				        }

				        // Now we get the default variation data
				        if( $is_default_variation ){
				            // Get the "default" WC_Product_Variation object to use available methods
				            $default_variation = wc_get_product($variation_id);

				            // Raw output of available "default" variation details data
				            echo '<span class="not-available price">' . ($parent->get_default_attributes())['pa_gewicht'] . ' - ' . wc_price( $default_variation->get_price() ) . '</span>';
				        }
				    }
			        ?>

				<?php else: ?>

					<div class="price"><?php _e('nicht vorrätig', 'eichmeister'); ?></div>

				<?php endif; ?>

		    </div>

		    <div class="more-information">
		    	<a href="<?php echo $link; ?>" class="btn">Mehr erfahren</a>
		    </div>
	    </div>

    </div>
</div>

<?php $em_post_id = null; ?>