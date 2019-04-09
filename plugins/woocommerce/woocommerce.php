<?php


//////////////////////////////////////////////////////////////////////////////////////////////
// ADD CUSTOM TAXONOMY
//////////////////////////////////////////////////////////////////////////////////////////////
	
    if ( ! function_exists( 'em_custom_product_taxonomy' ) ) {
		function em_custom_product_taxonomy()  {

			register_taxonomy(
				'product_flavor',
				array( 'product' ),
				array(
					'hierarchical'          => false,
					'show_ui'               => true,
					'query_var'             => true,
					'parent_item'       	=> null,
					'parent_item_colon' 	=> null,
					// 'capabilities'          => array(
					// 	'manage_terms' => 'manage_product_terms',
					// 	'edit_terms'   => 'edit_product_terms',
					// 	'delete_terms' => 'delete_product_terms',
					// 	'assign_terms' => 'assign_product_terms',
					// ),
					// 'rewrite'               => array(
					// 	'slug'         => $permalinks['category_rewrite_slug'],
					// 	'with_front'   => false,
					// 	'hierarchical' => true,
					// ),
					'label'                 => __( 'Bean Flavor', 'eichmeister' ),
					'labels'                => array(
						'name'              => __( 'Bean Flavor', 'eichmeister' ),
						'singular_name'     => __( 'Flavor', 'eichmeister' ),
						'menu_name'         => _x( 'Flavors', 'Admin menu name', 'eichmeister' ),
						'search_items'      => __( 'Search flavors', 'eichmeister' ),
						'all_items'         => __( 'All flavors', 'eichmeister' ),
						'parent_item'       => __( 'Parent flavor', 'eichmeister' ),
						'parent_item_colon' => __( 'Parent flavor:', 'eichmeister' ),
						'edit_item'         => __( 'Edit flavor', 'eichmeister' ),
						'update_item'       => __( 'Update flavor', 'eichmeister' ),
						'add_new_item'      => __( 'Add new flavor', 'eichmeister' ),
						'new_item_name'     => __( 'New flavor name', 'eichmeister' ),
						'not_found'         => __( 'No flavors found', 'eichmeister' ),
					),
				)
			);

			register_taxonomy(
				'product_region',
				array( 'product' ),
				array(
					'hierarchical'          => false,
					'show_ui'               => true,
					'query_var'             => true,
					'parent_item'       	=> null,
					'parent_item_colon' 	=> null,
					// 'capabilities'          => array(
					// 	'manage_terms' => 'manage_product_terms',
					// 	'edit_terms'   => 'edit_product_terms',
					// 	'delete_terms' => 'delete_product_terms',
					// 	'assign_terms' => 'assign_product_terms',
					// ),
					// 'rewrite'               => array(
					// 	'slug'         => $permalinks['category_rewrite_slug'],
					// 	'with_front'   => false,
					// 	'hierarchical' => true,
					// ),
					'label'                 => __( 'Region', 'eichmeister' ),
					'labels'                => array(
						'name'              => __( 'Region', 'eichmeister' ),
						'singular_name'     => __( 'Region', 'eichmeister' ),
						'menu_name'         => _x( 'Regions', 'Admin menu name', 'eichmeister' ),
						'search_items'      => __( 'Search regions', 'eichmeister' ),
						'all_items'         => __( 'All regions', 'eichmeister' ),
						'parent_item'       => __( 'Parent region', 'eichmeister' ),
						'parent_item_colon' => __( 'Parent region:', 'eichmeister' ),
						'edit_item'         => __( 'Edit region', 'eichmeister' ),
						'update_item'       => __( 'Update region', 'eichmeister' ),
						'add_new_item'      => __( 'Add new region', 'eichmeister' ),
						'new_item_name'     => __( 'New region name', 'eichmeister' ),
						'not_found'         => __( 'No regions found', 'eichmeister' ),
					),
				)
			);
		}
		add_action( 'woocommerce_after_register_taxonomy', 'em_custom_product_taxonomy' );
	}

//////////////////////////////////////////////////////////////////////////////////////////////
// EDIT EICHMEISTER PRODUCT DATA
//////////////////////////////////////////////////////////////////////////////////////////////

	// Add custom Fields
    include( locate_template('plugins/woocommerce/fields/em-wc-product-fields.php') );
    include( locate_template('plugins/woocommerce/fields/em-wc-taxonomy-fields.php') );

    // Remove meta box "eichmeister product data"
    add_filter( 'em_wc_product_activate', '__return_false' );

//////////////////////////////////////////////////////////////////////////////////////////////
// SINGLE PAGE LAYOUT
//////////////////////////////////////////////////////////////////////////////////////////////

	add_action( 'woocommerce_before_main_content', 'em_wc_custom_single_page_background', 5 );
	function em_wc_custom_single_page_background() {
		$flavor_term_meta = get_term_meta( get_field("gebiet_region")->term_id ); 
		$flavor_background_color = array_shift($flavor_term_meta['background-color']); 
		?>
		<div class="custom-background" style="background-color: <?php echo $flavor_background_color; ?>">
		</div>
		<?php
	}