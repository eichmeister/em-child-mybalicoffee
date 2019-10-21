<?php

    add_filter( "woocommerce_order_get_total_discount", "em_wc_order_get_total_discount", 10, 2 );
    function em_wc_order_get_total_discount( $discount, $object ) {
        $tax_display = $tax_display ? $tax_display : get_option( 'woocommerce_tax_display_cart' );
        $subtotal    = 0;

        if ( ! $compound ) {
            foreach ( $object->get_items() as $item ) {
                $subtotal += $item->get_subtotal();

                if ( 'incl' === $tax_display ) {
                    $subtotal += $item->get_subtotal_tax();
                }
            }
        } else {
            if ( 'incl' === $tax_display ) {
                return '';
            }

            foreach ( $object->get_items() as $item ) {
                $subtotal += $item->get_subtotal();
            }

            // Add Shipping Costs.
            $subtotal += $object->get_shipping_total();

            // Remove non-compound taxes.
            foreach ( $object->get_taxes() as $tax ) {
                if ( $tax->is_compound() ) {
                    continue;
                }
                $subtotal = $subtotal + $tax->get_tax_total() + $tax->get_shipping_tax_total();
            }

            // Remove discounts.
            $subtotal = $subtotal - $this->get_total_discount();
        }
        $discount = ($subtotal - $object->get_total());
        return $discount;
    }

//////////////////////////////////////////////////////////////////////////////////////
// ADD CONTACT TO MAIN MENU AND FOOTER MENU 2
//////////////////////////////////////////////////////////////////////////////////////

    function new_nav_menu_items($items, $args) {
        if ( $args->menu == 'main' || $args->menu == 'Footer2' ) {
            $homelink = '<li class="home"><a href="' . get_permalink( '117' ) . '/#contact' . '">' . __('Kontakt') . '</a></li>';
            // add the home link to the end of the menu
            $items = $items . $homelink;
        }
        return $items;
    }
    add_filter( 'wp_nav_menu_items', 'new_nav_menu_items', 10, 2 );

//////////////////////////////////////////////////////////////////////////////////////
// EICHMEISTER THEME SETTINGS (manual / options pages)
//////////////////////////////////////////////////////////////////////////////////////

    if ( ! function_exists( 'em_theme_info' ) ) {
        function em_theme_info() {

            if (!empty(get_field('em_header', 'option'))) $header_id = get_field('em_header', 'option');
            else $header_id = 1;

            return apply_filters( 'em_theme_info', array(
                'header' => $header_id,
                'footer' => 'custom',
                'logo_header' => get_stylesheet_directory_uri().'/assets/img/logo.svg',
                'logo_header_1' => get_stylesheet_directory_uri().'/assets/img/logo-white-1.svg',
                'logo_footer' => get_stylesheet_directory_uri().'/assets/img/logo-white.svg',
                'google_api_key' => get_field('em_gmaps_apikey', 'option')
            ));
        }
    }

//////////////////////////////////////////////////////////////////////////////////////
// LOAD PARENT AND CHILD THEME STYLES & JS
//////////////////////////////////////////////////////////////////////////////////////

    function my_theme_enqueue_styles() {
        
        wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/assets/css/style.css' );
        wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/assets/css/style.css', array('parent-style') );

        // Main child js
        wp_enqueue_script( 'main-child-js', get_stylesheet_directory_uri()."/assets/js/main-child.js", array(), '1.0.0', true );

        // New woocommerce styles
        wp_enqueue_style( 'style-wc-child-css', get_stylesheet_directory_uri()."/plugins/woocommerce/assets/css/style-wc-child.css" );
        wp_enqueue_script( 'script-wc-child-js', get_stylesheet_directory_uri()."/plugins/woocommerce/assets/js/script-wc-child.js", array(), '1.0.0', true );

        if (is_page_template('page-templates/tpl-lp-1.php')) {

    		// LP01
    		
    		wp_enqueue_style( 'style-lp-1-css', get_stylesheet_directory_uri()."/assets/css/style-lp-1.css" );
    		wp_enqueue_style( 'style-odometer-css', get_template_directory_uri()."/assets/css/lib/odometer_default.css" );
    		wp_enqueue_script( 'page-lp-1-js', get_stylesheet_directory_uri()."/assets/js/page-lp-1.js", array(), '1.0.0', true );

            wp_enqueue_script( 'odometer-js', get_template_directory_uri()."/assets/js/lib/odometer.min.js", array(), '1.0.0', true );
            wp_enqueue_script( 'typed-js', get_template_directory_uri()."/assets/js/lib/typed.min.js", array(), '1.0.0', true );

    	} else if ( is_singular('location') ) {

            // SINGLE LOCATION

            wp_enqueue_style( 'style-single-location-css', get_stylesheet_directory_uri()."/assets/css/style-single-location.css" );

        } else if ( is_page_template('page-templates/tpl-locations.php') ) {

            // LOCATION OVERVIEW

            wp_enqueue_style( 'style-locations-css', get_stylesheet_directory_uri()."/assets/css/style-locations.css" );

        } else if (is_singular('post')) {

            // SINGLE POST PAGE

            wp_dequeue_style( 'style-blog-masonry-css' );
            wp_dequeue_style( 'single-post-css' );

            // load single post detail stylesheet
            wp_enqueue_style( 'single-post-child-css', get_stylesheet_directory_uri() . "/assets/css/style-single-post.css" );

        } else if ( is_page_template() ) {

            // BLOG ARCHIVE

            wp_enqueue_style( 'blog-css', get_stylesheet_directory_uri() . "/assets/css/style-blog.css" );

        }


    }
    add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles', PHP_INT_MAX );

//////////////////////////////////////////////////////////////////////////////////////
// PROJECT SPECIFIC ADDITIONAL IMAGE SIZES
//////////////////////////////////////////////////////////////////////////////////////

    // add_image_size( 'img_600x400', 600, 400, true );
    // add_image_size( 'img_1200x800', 1200, 800, true );
    // add_image_size( 'img_400x600', 400, 600, true );
    // add_image_size( 'img_800x800', 800, 800, true );
    // add_image_size( 'img_1200x1200', 1200, 1200, true );

//////////////////////////////////////////////////////////////////////////////////////
// HOOK TYPEKIT INTO HEADER OF PAGE
//////////////////////////////////////////////////////////////////////////////////////

    function load_typekit() {
        ?>

 

        <?php
    }
    add_action('wp_head', 'load_typekit');

//////////////////////////////////////////////////////////////////////////////////////
// MOVE YOAST PLUGIN TO BOTTOM IN ADMIN VIEW
//////////////////////////////////////////////////////////////////////////////////////

    add_filter( 'wpseo_metabox_prio', function() { return 'low'; } );

//////////////////////////////////////////////////////////////////////////////////////
// LOAD LESS REF IN PARENT THEME
//////////////////////////////////////////////////////////////////////////////////////

    if ( ! function_exists( 'em_update_ref_less' ) ) {
        function em_update_ref_less() {
            $dir = ABSPATH . 'wp-content/themes/eichmeister/assets/css/lib/ref.less';
            if ( ! class_exists( 'WP_Filesystem_Direct' ) ) {
                require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
                require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';
            }

            $fs      = new WP_Filesystem_Direct( '' );

            $name = basename(get_stylesheet_directory());
            $text = "@import (optional, reference) url('../../../../{$name}/assets/css/mixins.less');";
            $fs->put_contents( $dir, $text);
        }
        add_action( 'after_setup_theme', 'em_update_ref_less' );
    }

//////////////////////////////////////////////////////////////////////////////////////
// REGISTER POST TYPE(S)
//////////////////////////////////////////////////////////////////////////////////////

    add_action( 'init', 'em_mybali_custom_post_types', 0 );

    function em_mybali_custom_post_types() {

        // LOCATION POST TYPE

        $labels = array(
            'name'                  => _x( 'Locations', 'Post Type General Name', 'eichmeister' ),
            'singular_name'         => _x( 'Location', 'Post Type Singular Name', 'eichmeister' ),
            'menu_name'             => __( 'Locations', 'eichmeister' ),
            'name_admin_bar'        => __( 'Location', 'eichmeister' ),
            'archives'              => __( 'Location Archives', 'eichmeister' ),
            'attributes'            => __( 'Location Attributes', 'eichmeister' ),
            'parent_item_colon'     => __( 'Parent Location:', 'eichmeister' ),
            'all_items'             => __( 'All Locations', 'eichmeister' ),
            'add_new_item'          => __( 'Add New Location', 'eichmeister' ),
            'add_new'               => __( 'Add New', 'eichmeister' ),
            'new_item'              => __( 'New Location', 'eichmeister' ),
            'edit_item'             => __( 'Edit Location', 'eichmeister' ),
            'update_item'           => __( 'Update Location', 'eichmeister' ),
            'view_item'             => __( 'View Location', 'eichmeister' ),
            'view_items'            => __( 'View Locations', 'eichmeister' ),
            'search_items'          => __( 'Search Locations', 'eichmeister' ),
            'not_found'             => __( 'Not found', 'eichmeister' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'eichmeister' ),
            'featured_image'        => __( 'Featured Image', 'eichmeister' ),
            'set_featured_image'    => __( 'Set featured image', 'eichmeister' ),
            'remove_featured_image' => __( 'Remove featured image', 'eichmeister' ),
            'use_featured_image'    => __( 'Use as featured image', 'eichmeister' ),
            'insert_into_item'      => __( 'Insert into item', 'eichmeister' ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', 'eichmeister' ),
            'items_list'            => __( 'Locations list', 'eichmeister' ),
            'items_list_navigation' => __( 'Locations list navigation', 'eichmeister' ),
            'filter_items_list'     => __( 'Filter Locations list', 'eichmeister' ),
        );
        $args = array(
            'label'                 => __( 'Location', 'eichmeister' ),
            'description'           => __( 'Post Type Description', 'eichmeister' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor' ),
            'taxonomies'            => array( 'category', 'post_tag' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
        );
        register_post_type( 'location', $args );

        // MERCHANT POST TYPE

        $labels = array(
            'name'                  => _x( 'Merchants', 'Post Type General Name', 'eichmeister' ),
            'singular_name'         => _x( 'Merchant', 'Post Type Singular Name', 'eichmeister' ),
            'menu_name'             => __( 'Merchants', 'eichmeister' ),
            'name_admin_bar'        => __( 'Merchant', 'eichmeister' ),
            'archives'              => __( 'Merchant Archives', 'eichmeister' ),
            'attributes'            => __( 'Merchant Attributes', 'eichmeister' ),
            'parent_item_colon'     => __( 'Parent Merchant:', 'eichmeister' ),
            'all_items'             => __( 'All Merchants', 'eichmeister' ),
            'add_new_item'          => __( 'Add New Merchant', 'eichmeister' ),
            'add_new'               => __( 'Add New', 'eichmeister' ),
            'new_item'              => __( 'New Merchant', 'eichmeister' ),
            'edit_item'             => __( 'Edit Merchant', 'eichmeister' ),
            'update_item'           => __( 'Update Merchant', 'eichmeister' ),
            'view_item'             => __( 'View Merchant', 'eichmeister' ),
            'view_items'            => __( 'View Merchants', 'eichmeister' ),
            'search_items'          => __( 'Search Merchants', 'eichmeister' ),
            'not_found'             => __( 'Not found', 'eichmeister' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'eichmeister' ),
            'featured_image'        => __( 'Featured Image', 'eichmeister' ),
            'set_featured_image'    => __( 'Set featured image', 'eichmeister' ),
            'remove_featured_image' => __( 'Remove featured image', 'eichmeister' ),
            'use_featured_image'    => __( 'Use as featured image', 'eichmeister' ),
            'insert_into_item'      => __( 'Insert into item', 'eichmeister' ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', 'eichmeister' ),
            'items_list'            => __( 'Merchants list', 'eichmeister' ),
            'items_list_navigation' => __( 'Merchants list navigation', 'eichmeister' ),
            'filter_items_list'     => __( 'Filter Merchants list', 'eichmeister' ),
        );
        $args = array(
            'label'                 => __( 'Merchant', 'eichmeister' ),
            'description'           => __( 'Post Type Description', 'eichmeister' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor' ),
            'taxonomies'            => array( 'category', 'post_tag' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
        );
        register_post_type( 'merchant', $args );

//////////////////////////////////////////////////////////////////////////////////////
// TAXONOMIES
////////////////////////////////////////////////////////////////////////////////////// 

    add_action( 'init', 'em_place_taxonomy_init' );

    function em_place_taxonomy_init() {

        // General categorization
        register_taxonomy(
            'place',
            array('location', 'merchant'),
            array(
                'label' => __( 'Places' ),
                'rewrite' => array( 'slug' => 'place' ),
                'capabilities' => array(
                    'manage_terms' => 'manage_categories',
                    'edit_terms' => 'manage_categories',
                    'delete_terms' => 'manage_categories',
                    'assign_terms' => 'edit_posts'
                ),
                'hierarchical' => true
            )
        );     
    }


    }

//////////////////////////////////////////////////////////////////////////////////////
// GOOGLE ANALYTICS
//////////////////////////////////////////////////////////////////////////////////////

    add_action('em_wp_head', 'mybali_google_analytics');

    function mybali_google_analytics() {

        ?>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-124334568-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-122470977-1', { 'anonymize_ip': true });
        </script>

        <?php 
    }

?>