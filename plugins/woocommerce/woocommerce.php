<?php


//////////////////////////////////////////////////////////////////////////////////////////////
// ADD CUSTOM TAXONOMY
//////////////////////////////////////////////////////////////////////////////////////////////
	
    if ( ! function_exists( 'em_custom_product_taxonomy' ) ) {
		function em_custom_product_taxonomy()  {

			register_taxonomy(
				'product_cat_2',
				apply_filters( 'woocommerce_taxonomy_objects_product_cat', array( 'product' ) ),
				apply_filters(
					'woocommerce_taxonomy_args_product_cat', array(
						'hierarchical'          => true,
						'update_count_callback' => '_wc_term_recount',
						'label'                 => __( 'Categories', 'woocommerce' ),
						'labels'                => array(
							'name'              => __( 'Product categories', 'woocommerce' ),
							'singular_name'     => __( 'Category', 'woocommerce' ),
							'menu_name'         => _x( 'Categories', 'Admin menu name', 'woocommerce' ),
							'search_items'      => __( 'Search categories', 'woocommerce' ),
							'all_items'         => __( 'All categories', 'woocommerce' ),
							'parent_item'       => __( 'Parent category', 'woocommerce' ),
							'parent_item_colon' => __( 'Parent category:', 'woocommerce' ),
							'edit_item'         => __( 'Edit category', 'woocommerce' ),
							'update_item'       => __( 'Update category', 'woocommerce' ),
							'add_new_item'      => __( 'Add new category', 'woocommerce' ),
							'new_item_name'     => __( 'New category name', 'woocommerce' ),
							'not_found'         => __( 'No categories found', 'woocommerce' ),
						),
						'show_ui'               => true,
						'query_var'             => true,
						'capabilities'          => array(
							'manage_terms' => 'manage_product_terms',
							'edit_terms'   => 'edit_product_terms',
							'delete_terms' => 'delete_product_terms',
							'assign_terms' => 'assign_product_terms',
						),
						'rewrite'               => array(
							'slug'         => $permalinks['category_rewrite_slug'],
							'with_front'   => false,
							'hierarchical' => true,
						),
					)
				)
			);

		}
		add_action( 'woocommerce_after_register_taxonomy', 'em_custom_product_taxonomy' );
	}