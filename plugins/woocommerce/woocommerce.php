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

    // Remove woocommerce images 
    remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );

    // Remove woocommerce script for single page images
    remove_action( 'after_setup_theme', 'em_wc_theme_setup', 10 );

    // Add new SinglePage image layout
    add_action( 'woocommerce_before_single_product_summary', 'em_show_single_product_image', 20 );
    function em_show_single_product_image() {
		global $product;
		$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
		$post_thumbnail_id = $product->get_image_id();
		$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
			'woocommerce-product-gallery',
			'woocommerce-product-gallery--' . ( $product->get_image_id() ? 'with-images' : 'without-images' ),
			'woocommerce-product-gallery--columns-' . absint( $columns ),
			'images',
		) );
		?>
		<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
		<?php echo wp_get_attachment_image( $post_thumbnail_id, 'img_600' ); ?>
		</div>
		<?php
    }

    // Reorder breadcrumb
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
	add_action( 'woocommerce_before_single_product_summary', 'woocommerce_breadcrumb', 5 );

	// Reorder notices 
    remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices', 10 );
	add_action( 'woocommerce_before_single_product_summary', 'wc_print_notices', 6 );

    // Set SinglePage related products to 3 
    add_filter( 'em_related_products_cols', function( $cols ) { $cols = 3; return $cols; } );

    // Product single page - related products headline
    function em_related_products_headline() {
        return "Ähnliche Produkte";
    }
    add_filter( 'em_related_products_headline', 'em_related_products_headline' );
    
    // Dont display subheadline for related products
    add_filter( 'em_related_products_sub_headline', '__return_false' );



//////////////////////////////////////////////////////////////////////////////////////////////
// ARCHIVE AJAX
//////////////////////////////////////////////////////////////////////////////////////////////

    add_action('wp_ajax_em_shop_archive_filter', 'em_shop_archive_filter' );
    add_action('wp_ajax_nopriv_em_shop_archive_filter', 'em_shop_archive_filter' );

    function em_shop_archive_filter() {

        $em_wc_args = em_shop_archive_filter_query();

        $em_wc_ajax_query = new WP_Query( $em_wc_args );

		?>

		<div class="products-wrapper em-wc-wrapper">
			<div class="products row">

				<?php
				if ( $em_wc_ajax_query->have_posts() ) {
					while ( $em_wc_ajax_query->have_posts() ) {
						$em_wc_ajax_query->the_post();
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
				} else {
					wc_no_products_found();
				}
				?>

			</div>
		</div>

		<?php
        wp_die();
    }

    function em_shop_archive_filter_query() {
        $_SESSION["tr_data"] = array();
        $product_array = array();
        $new_args = $_POST['query'];
        $wc_query = new WC_Query();

        // unset product cat pages
        unset($new_args['product_cat']);
        unset($new_args['taxonomy']);
        unset($new_args['term']);
        
        $new_args['orderby'] = $wc_query->get_catalog_ordering_args($_POST['query']['orderby'],$_POST['query']['order'])['orderby'];
        $new_args['order'] = $wc_query->get_catalog_ordering_args($_POST['query']['orderby'],$_POST['query']['order'])['order'];
        if ( isset( $wc_query->get_catalog_ordering_args($_POST['query']['orderby'],$_POST['query']['order'])['meta_key'] ) ) {
            $new_args['meta_key'] = $wc_query->get_catalog_ordering_args($_POST['query']['orderby'],$_POST['query']['order'])['meta_key'];
        }
        $tax_query = array(
            array(
                'taxonomy'  => 'product_visibility',
                'field'    => 'term_id',
                'terms'    => array(7),
                'operator' => 'NOT IN',
            )
        );

        if( isset($_POST['tr_data']) && !empty($_POST['tr_data']) ) {
        	if ($_POST['tr_data'][0]['type'] == 'product_cat') {
	        	$tax_query[] = array(
	                'taxonomy'  => 'product_cat',
	                'field'    => 'term_id',
	                'terms'    => $_POST['tr_data'][0]['value'],
	                'operator' => 'IN',
	        	);
	        }
        }

        if ( isset($_POST['em_page'])) {
            $new_args['paged'] = $_POST['em_page'];
            $_SESSION["paged"] = $_POST['em_page'];
        }
        $new_args['post_status'] = 'publish';
        $new_args['tax_query'] = $tax_query;
        $_SESSION['tr_data'] = ( isset($_POST['tr_data']) && !empty($_POST['tr_data']) ) ? $_POST['tr_data'] : array();
        return $new_args;
    }