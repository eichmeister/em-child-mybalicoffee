<?php

    // add_filter( "woocommerce_email_settings", "max_new_test" );
    // function max_new_test( $array ) {
    //     br($array);
    //     return $array;
    // }

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
            // wp_enqueue_style( 'style-odometer-css', get_template_directory_uri()."/assets/css/lib/odometer_default.css" );
            // wp_enqueue_script( 'page-lp-1-js', get_stylesheet_directory_uri()."/assets/js/page-lp-1.js", array(), '1.0.0', true );

            // wp_enqueue_script( 'lp1-getresponse-js', "https://app.getresponse.com/view_webform_v2.js?u=GOPHD&webforms_id=33291405", array(), '1.0.0', true );

            // wp_enqueue_script( 'odometer-js', get_template_directory_uri()."/assets/js/lib/odometer.min.js", array(), '1.0.0', true );
            // wp_enqueue_script( 'typed-js', get_template_directory_uri()."/assets/js/lib/typed.min.js", array(), '1.0.0', true );

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

    }

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

//////////////////////////////////////////////////////////////////////////////////////
// GOOGLE TAG MANAGER - ANALYTICS & FB Pixel - NEEDS CONFIGURATION SO WE CAN REMOVE SINGLE TRACKING CODES
//////////////////////////////////////////////////////////////////////////////////////

    // GOOGLE TAG MANAGER

    /*
    add_action('em_wp_head', 'mybali_global_tracking');

    function mybali_global_tracking() {

        ?>

        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-NK4HLMK');</script>
        <!-- End Google Tag Manager -->

        <?php 
    }


    // GOOGLE TAG MANAGER (NOSCRIPT) FALLBACK

    add_action('em_body_start', 'mybali_global_tracking_noscript');

    function mybali_global_tracking_noscript() {

        ?>

        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NK4HLMK"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->

        <?php

    }
    */

//////////////////////////////////////////////////////////////////////////////////////
// GOOGLE ANALYTICS
//////////////////////////////////////////////////////////////////////////////////////

    add_action('em_wp_head', 'mybali_google_analytics');

    function mybali_google_analytics() {

        ?>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-122470977-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-122470977-1', { 'anonymize_ip': true });
        </script>

        <!-- Global site tag (gtag.js) - Google Ads: 722172369 -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=AW-722172369"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'AW-722172369', { 'anonymize_ip': true });
        </script>

        <?php 
    }

//////////////////////////////////////////////////////////////////////////////////////
// FACEBOOK PIXEL
//////////////////////////////////////////////////////////////////////////////////////

    // add_action('em_wp_head', 'mybali_facebook_pixel');

    function mybali_facebook_pixel() {

        ?>

        <?php

        /*

        <!-- Facebook Pixel Code -->
        <!--
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window,document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
             fbq('init', '1975264845901190'); 
            fbq('track', 'PageView');
            </script>
            <noscript>
             <img height="1" width="1" 
            src="https://www.facebook.com/tr?id=1975264845901190&ev=PageView
            &noscript=1"/>
        </noscript>
        -->
        <!-- End Facebook Pixel Code -->

        */

        ?>

        <?php 
    }

//////////////////////////////////////////////////////////////////////////////////////
// THANK YOU PAGE TRACKING
//////////////////////////////////////////////////////////////////////////////////////

    add_action( 'woocommerce_thankyou', 'mybali_thankyou_page_tracking' );

    function mybali_thankyou_page_tracking( $order_id ) {

        ?>

        <!-- Event snippet for Conversion - Sale conversion page -->
        <script>
          gtag('event', 'conversion', {
              'send_to': 'AW-722172369/jWGhCIu8l8ABENHzrdgC',
              'transaction_id': <?php echo $order_id; ?>
          });
        </script>

        

        <?php

    }

//////////////////////////////////////////////////////////////////////////////////////
// ACF
//////////////////////////////////////////////////////////////////////////////////////

    add_filter('acf/settings/show_admin', 'my_acf_show_admin');

    function my_acf_show_admin( $show ) {
        return current_user_can('update_core');
    }



    if( function_exists('acf_add_local_field_group') ):

        acf_add_local_field_group(array(
            'key' => 'group_single_post',
            'title' => 'Single Post',
            'fields' => array(
                array(
                    'key' => 'field_5b991c1976553',
                    'label' => 'General',
                    'name' => '',
                    'type' => 'tab',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'placement' => 'left',
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_5731ef8ccc082',
                    'label' => 'Preview Photo / Hero Image',
                    'name' => 'preview_image',
                    'type' => 'image',
                    'instructions' => 'Bild aus Medienbiblothek auswählen oder neues Bild vom Computer hochladen.
        Auf editieren (Stift) Button des hochgeladenen Bildes klicken und Bildunterschrift eingeben.',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'return_format' => 'array',
                    'preview_size' => 'thumbnail',
                    'library' => 'all',
                    'min_width' => '',
                    'min_height' => '',
                    'min_size' => '',
                    'max_width' => '',
                    'max_height' => '',
                    'max_size' => '',
                    'mime_types' => '',
                ),
                array(
                    'key' => 'field_5731ef27cc081',
                    'label' => 'Preview Type',
                    'name' => 'preview_type',
                    'type' => 'select',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'choices' => array(
                        'image' => 'Bild',
                        'video' => 'Video',
                    ),
                    'default_value' => array(
                        0 => 'image',
                    ),
                    'allow_null' => 0,
                    'multiple' => 0,
                    'ui' => 0,
                    'return_format' => 'value',
                    'ajax' => 0,
                    'placeholder' => '',
                ),
                array(
                    'key' => 'field_5731f040d278d',
                    'label' => 'Preview Video (Youtube / Vimeo)',
                    'name' => 'preview_video',
                    'type' => 'oembed',
                    'instructions' => 'URL eines Youtube oder Vimeo Videos hier einfügen',
                    'required' => 0,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_5731ef27cc081',
                                'operator' => '==',
                                'value' => 'video',
                            ),
                        ),
                    ),
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'width' => '',
                    'height' => '',
                ),
                array(
                    'key' => 'field_57332f205b5b0',
                    'label' => 'Excerpt',
                    'name' => 'custom_excerpt',
                    'type' => 'wysiwyg',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'tabs' => 'all',
                    'toolbar' => 'full',
                    'media_upload' => 1,
                    'delay' => 0,
                ),
                array(
                    'key' => 'field_57a232a204db7',
                    'label' => 'Featured Post?',
                    'name' => 'featured',
                    'type' => 'radio',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'choices' => array(
                        1 => 'FEATURED Artikel',
                        0 => 'normaler Artikel',
                    ),
                    'allow_null' => 0,
                    'other_choice' => 0,
                    'default_value' => 0,
                    'layout' => 'horizontal',
                    'return_format' => 'value',
                    'save_other_choice' => 0,
                ),
                array(
                    'key' => 'field_57332fa15b5b1',
                    'label' => 'Custom Author Name',
                    'name' => 'author',
                    'type' => 'text',
                    'instructions' => 'If author info should not be fetched from wordpress user account, enter author name here manually',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_5b991c2f76554',
                    'label' => 'Content Blocks',
                    'name' => '',
                    'type' => 'tab',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'placement' => 'left',
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_5b991cc5ad490',
                    'label' => 'Content Blocks',
                    'name' => 'content',
                    'type' => 'clone',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'clone' => array(
                        0 => 'group_module_content_blocks',
                    ),
                    'display' => 'seamless',
                    'layout' => 'block',
                    'prefix_label' => 0,
                    'prefix_name' => 0,
                ),
                array(
                    'key' => 'field_5b991c4e76555',
                    'label' => 'Sources / Legal',
                    'name' => '',
                    'type' => 'tab',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'placement' => 'left',
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_5756dccc398df',
                    'label' => 'Sources',
                    'name' => 'sources',
                    'type' => 'repeater',
                    'instructions' => '<a href="http://apareferencing.ukessays.com/generator/" target="_blank">http://apareferencing.ukessays.com/generator/</a>',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'collapsed' => '',
                    'min' => 0,
                    'max' => 0,
                    'layout' => 'table',
                    'button_label' => 'Eintrag hinzufügen',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_5756de0fbcb9e',
                            'label' => 'Quelle',
                            'name' => 'item',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                    ),
                ),
                array(
                    'key' => 'field_57333019c033b',
                    'label' => 'Soruce Links',
                    'name' => 'source_links',
                    'type' => 'repeater',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'collapsed' => '',
                    'min' => 0,
                    'max' => 0,
                    'layout' => 'table',
                    'button_label' => 'Eintrag hinzufügen',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_5733304cc033c',
                            'label' => 'Link Titel',
                            'name' => 'title',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                        array(
                            'key' => 'field_5733306fc033d',
                            'label' => 'Link URL',
                            'name' => 'url',
                            'type' => 'url',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                        ),
                    ),
                ),
                array(
                    'key' => 'field_573331206d4ae',
                    'label' => 'Source Files',
                    'name' => 'source_files',
                    'type' => 'repeater',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'collapsed' => '',
                    'min' => 0,
                    'max' => 0,
                    'layout' => 'table',
                    'button_label' => 'Eintrag hinzufügen',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_573331476d4af',
                            'label' => 'Datei Titel',
                            'name' => 'title',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                        array(
                            'key' => 'field_5733317c6d4b0',
                            'label' => 'Datei Upload',
                            'name' => 'item',
                            'type' => 'file',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'return_format' => 'array',
                            'library' => 'all',
                            'min_size' => '',
                            'max_size' => '',
                            'mime_types' => '',
                        ),
                    ),
                ),
                array(
                    'key' => 'field_5756e32d29aef',
                    'label' => 'Photo Copyrights',
                    'name' => 'photo_copyrights',
                    'type' => 'repeater',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'collapsed' => '',
                    'min' => 0,
                    'max' => 0,
                    'layout' => 'table',
                    'button_label' => 'Eintrag hinzufügen',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_5756e34429af0',
                            'label' => 'Bild Copyright',
                            'name' => 'item',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'post',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => array(
                0 => 'the_content',
            ),
            'active' => true,
            'description' => '',
            'modified' => 1542919920,
        ));

        acf_add_local_field_group(array(
            'key' => 'group_5d88ce7910280',
            'title' => 'Blog',
            'fields' => array(
                array(
                    'key' => 'field_5d88ce908902c',
                    'label' => 'Intro',
                    'name' => '',
                    'type' => 'tab',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'placement' => 'left',
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_5d88ce968902d',
                    'label' => 'Hero',
                    'name' => 'hero',
                    'type' => 'clone',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'clone' => array(
                        0 => 'group_module_hero_simple',
                    ),
                    'display' => 'seamless',
                    'layout' => 'block',
                    'prefix_label' => 0,
                    'prefix_name' => 1,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'page_template',
                        'operator' => '==',
                        'value' => 'page-templates/tpl-blog.php',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => array(
                0 => 'the_content',
            ),
            'active' => true,
            'description' => '',
        ));

        acf_add_local_field_group(array(
            'key' => 'group_5d3f1dc38e562',
            'title' => 'Merchant',
            'fields' => array(
                array(
                    'key' => 'field_5d3f1da504db9',
                    'label' => 'Address',
                    'name' => 'address',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_5d3f1dab04dba',
                    'label' => 'Zip Code',
                    'name' => 'zip_code',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_5d3f1db004dbb',
                    'label' => 'Place',
                    'name' => 'place',
                    'type' => 'taxonomy',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'taxonomy' => 'place',
                    'field_type' => 'select',
                    'allow_null' => 0,
                    'add_term' => 1,
                    'save_terms' => 0,
                    'load_terms' => 0,
                    'return_format' => 'id',
                    'multiple' => 0,
                ),
                array(
                    'key' => 'field_5d3f4cdc17c9c',
                    'label' => 'Google Maps',
                    'name' => 'google_maps',
                    'type' => 'google_map',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'center_lat' => '',
                    'center_lng' => '',
                    'zoom' => '',
                    'height' => '',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'merchant',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => array(
                0 => 'the_content',
            ),
            'active' => true,
            'description' => '',
        ));

        acf_add_local_field_group(array(
            'key' => 'group_5d3ac3d8e7484',
            'title' => 'Locations',
            'fields' => array(
                array(
                    'key' => 'field_5d3ac41f50e66',
                    'label' => 'Hero',
                    'name' => '',
                    'type' => 'tab',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'placement' => 'left',
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_5d3ac42950e67',
                    'label' => 'Hero',
                    'name' => 'hero',
                    'type' => 'clone',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'clone' => array(
                        0 => 'group_module_hero_simple',
                    ),
                    'display' => 'seamless',
                    'layout' => 'block',
                    'prefix_label' => 0,
                    'prefix_name' => 1,
                ),
                array(
                    'key' => 'field_5d3ed5e4dd723',
                    'label' => 'Cafes',
                    'name' => '',
                    'type' => 'tab',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'placement' => 'left',
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_5d3ed60edd726',
                    'label' => 'Headline',
                    'name' => 'cafes_hl',
                    'type' => 'textarea',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'maxlength' => '',
                    'rows' => 2,
                    'new_lines' => 'br',
                ),
                array(
                    'key' => 'field_5d3ed9c96c8c7',
                    'label' => 'Info',
                    'name' => '',
                    'type' => 'message',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'message' => 'Add, edit or delete existing Café Locations <a href="edit.php?post_type=location" target="_blank">here</a>',
                    'new_lines' => 'wpautop',
                    'esc_html' => 0,
                ),
                array(
                    'key' => 'field_5d3ed5ffdd724',
                    'label' => 'Merchants',
                    'name' => '',
                    'type' => 'tab',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'placement' => 'left',
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_5d3ed623dd727',
                    'label' => 'Headline',
                    'name' => 'merchants_hl',
                    'type' => 'textarea',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'maxlength' => '',
                    'rows' => 2,
                    'new_lines' => 'br',
                ),
                array(
                    'key' => 'field_5d3ed607dd725',
                    'label' => 'Contact',
                    'name' => '',
                    'type' => 'tab',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'placement' => 'left',
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_5d3ed671dd728',
                    'label' => 'Headline',
                    'name' => 'contact_hl',
                    'type' => 'textarea',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'maxlength' => '',
                    'rows' => 2,
                    'new_lines' => 'br',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'page_template',
                        'operator' => '==',
                        'value' => 'page-templates/tpl-locations.php',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => array(
                0 => 'the_content',
            ),
            'active' => true,
            'description' => '',
        ));

        acf_add_local_field_group(array(
            'key' => 'group_5d375e67ceb2d',
            'title' => 'Location',
            'fields' => array(
                array(
                    'key' => 'field_5d375e67d1933',
                    'label' => 'Hero',
                    'name' => '',
                    'type' => 'tab',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'placement' => 'left',
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_5d375e67d199e',
                    'label' => 'Hero',
                    'name' => 'hero',
                    'type' => 'clone',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'clone' => array(
                        0 => 'group_module_hero_simple_opacity_overlay',
                    ),
                    'display' => 'seamless',
                    'layout' => 'block',
                    'prefix_label' => 0,
                    'prefix_name' => 1,
                ),
                array(
                    'key' => 'field_5d375e67d1a72',
                    'label' => 'Infos',
                    'name' => '',
                    'type' => 'tab',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'placement' => 'left',
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_5d381fd116ff4',
                    'label' => 'Google Maps',
                    'name' => 'google_maps',
                    'type' => 'google_map',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'center_lat' => '',
                    'center_lng' => '',
                    'zoom' => '',
                    'height' => '',
                ),
                array(
                    'key' => 'field_5d38268a41c45',
                    'label' => 'Address',
                    'name' => 'address',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_5d3f13e1c863e',
                    'label' => 'Zip Code',
                    'name' => 'zip_code',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_5d3f13eac863f',
                    'label' => 'Place',
                    'name' => 'place',
                    'type' => 'taxonomy',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'taxonomy' => 'place',
                    'field_type' => 'select',
                    'allow_null' => 0,
                    'add_term' => 1,
                    'save_terms' => 0,
                    'load_terms' => 0,
                    'return_format' => 'id',
                    'multiple' => 0,
                ),
                array(
                    'key' => 'field_5d38200316ff5',
                    'label' => 'Phone',
                    'name' => 'phone',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_5d38201116ff6',
                    'label' => 'E-Mail',
                    'name' => 'email',
                    'type' => 'email',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                ),
                array(
                    'key' => 'field_5d382399fe1ff',
                    'label' => 'Opening Times',
                    'name' => 'opening_times',
                    'type' => 'repeater',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'collapsed' => '',
                    'min' => 0,
                    'max' => 0,
                    'layout' => 'table',
                    'button_label' => '',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_5d3823acfe200',
                            'label' => 'Day(s) Caption',
                            'name' => 'caption',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                        array(
                            'key' => 'field_5d3823c2fe201',
                            'label' => 'Time',
                            'name' => 'time',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                    ),
                ),
                array(
                    'key' => 'field_5d375e67d1b47',
                    'label' => 'Gallery',
                    'name' => '',
                    'type' => 'tab',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'placement' => 'left',
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_5d3823d8fe202',
                    'label' => 'Photos',
                    'name' => 'gallery_photos',
                    'type' => 'gallery',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'min' => '',
                    'max' => '',
                    'insert' => 'append',
                    'library' => 'all',
                    'min_width' => '',
                    'min_height' => '',
                    'min_size' => '',
                    'max_width' => '',
                    'max_height' => '',
                    'max_size' => '',
                    'mime_types' => '',
                ),
                array(
                    'key' => 'field_5d375eb476823',
                    'label' => 'Menu Highlights',
                    'name' => '',
                    'type' => 'tab',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'placement' => 'left',
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_5d3823fdfe203',
                    'label' => 'Menu Highlights',
                    'name' => 'menu_highlights',
                    'type' => 'repeater',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'collapsed' => '',
                    'min' => 0,
                    'max' => 0,
                    'layout' => 'row',
                    'button_label' => '',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_5d382442fe204',
                            'label' => 'Headline',
                            'name' => 'hl',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                        array(
                            'key' => 'field_5d382460fe205',
                            'label' => 'Text',
                            'name' => 'txt',
                            'type' => 'textarea',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'maxlength' => '',
                            'rows' => 4,
                            'new_lines' => 'br',
                        ),
                    ),
                ),
                array(
                    'key' => 'field_5d3f0e84d4533',
                    'label' => 'Preview',
                    'name' => '',
                    'type' => 'tab',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'placement' => 'top',
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_5d3f0e91d4534',
                    'label' => 'Photo',
                    'name' => 'preview_photo',
                    'type' => 'image',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'return_format' => 'id',
                    'preview_size' => 'thumbnail',
                    'library' => 'all',
                    'min_width' => '',
                    'min_height' => '',
                    'min_size' => '',
                    'max_width' => '',
                    'max_height' => '',
                    'max_size' => '',
                    'mime_types' => '',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'location',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => array(
                0 => 'the_content',
                1 => 'discussion',
            ),
            'active' => true,
            'description' => '',
        ));

        acf_add_local_field_group(array(
            'key' => 'group_5cf4ee5d0f598',
            'title' => 'Test',
            'fields' => array(
                array(
                    'key' => 'field_5cf4ee73f836d',
                    'label' => 'Verfügbarkeit',
                    'name' => 'product_settings_availability',
                    'type' => 'true_false',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'message' => 'Blendet den kaufen Button auf der Shop Single Page aus.',
                    'default_value' => 0,
                    'ui' => 1,
                    'ui_on_text' => '',
                    'ui_off_text' => '',
                ),
                array(
                    'key' => 'field_5cf4ee61f836c',
                    'label' => 'Beschreibung für ausverkaufte(s) Produkt(e)',
                    'name' => 'product_settings_text',
                    'type' => 'textarea',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'maxlength' => '',
                    'rows' => 4,
                    'new_lines' => 'br',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'post',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => false,
            'description' => '',
        ));

        acf_add_local_field_group(array(
            'key' => 'group_5cc6f1a5a5f16',
            'title' => 'About',
            'fields' => array(
                array(
                    'key' => 'field_5cc6f1a5a92ea',
                    'label' => 'Hero',
                    'name' => '',
                    'type' => 'tab',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'placement' => 'left',
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_5cc6f1a5a9355',
                    'label' => 'Hero',
                    'name' => 'hero',
                    'type' => 'clone',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'clone' => array(
                        0 => 'group_module_hero_simple_opacity_overlay',
                    ),
                    'display' => 'seamless',
                    'layout' => 'block',
                    'prefix_label' => 0,
                    'prefix_name' => 1,
                ),
                array(
                    'key' => 'field_5cc6f1a5a93bf',
                    'label' => 'Hero Teaser Text',
                    'name' => 'hero-teaser-txt',
                    'type' => 'textarea',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'maxlength' => '',
                    'rows' => 8,
                    'new_lines' => 'br',
                ),
                array(
                    'key' => 'field_5cc6f1a5a9493',
                    'label' => 'Content',
                    'name' => '',
                    'type' => 'tab',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'placement' => 'left',
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_5cc6f1a5a94fd',
                    'label' => 'Content',
                    'name' => 'content',
                    'type' => 'clone',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'clone' => array(
                        0 => 'group_5cb091a6b12f3',
                    ),
                    'display' => 'seamless',
                    'layout' => 'block',
                    'prefix_label' => 0,
                    'prefix_name' => 1,
                ),
                array(
                    'key' => 'field_5cc6f1a5a9778',
                    'label' => 'Contact',
                    'name' => '',
                    'type' => 'tab',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'placement' => 'left',
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_5cc6f1a5a97e1',
                    'label' => 'Contact Headline',
                    'name' => 'contact_hl',
                    'type' => 'textarea',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'maxlength' => '',
                    'rows' => 2,
                    'new_lines' => 'br',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_template',
                        'operator' => '==',
                        'value' => 'page-templates/tpl-about.php',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => array(
                0 => 'the_content',
                1 => 'discussion',
            ),
            'active' => true,
            'description' => '',
        ));

        acf_add_local_field_group(array(
            'key' => 'group_5cc2f1601dc1c',
            'title' => '_LP01',
            'fields' => array(
                array(
                    'key' => 'field_5cc2f18b6b124',
                    'label' => 'Hero',
                    'name' => '',
                    'type' => 'tab',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'placement' => 'left',
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_5cc2f1cb644be',
                    'label' => 'Hero',
                    'name' => 'hero',
                    'type' => 'clone',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'clone' => array(
                        0 => 'group_module_hero_simple_opacity_overlay',
                    ),
                    'display' => 'seamless',
                    'layout' => 'block',
                    'prefix_label' => 0,
                    'prefix_name' => 1,
                ),
                array(
                    'key' => 'field_5cc2fb903bfa4',
                    'label' => 'Hero Teaser Image',
                    'name' => 'hero-teaser-image',
                    'type' => 'image',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'return_format' => 'array',
                    'preview_size' => 'thumbnail',
                    'library' => 'all',
                    'min_width' => '',
                    'min_height' => '',
                    'min_size' => '',
                    'max_width' => '',
                    'max_height' => '',
                    'max_size' => '',
                    'mime_types' => '',
                ),
                array(
                    'key' => 'field_5cc2fba83bfa5',
                    'label' => 'Hero Teaser Link',
                    'name' => 'hero-teaser-link',
                    'type' => 'link',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'return_format' => 'array',
                ),
                array(
                    'key' => 'field_5cc2f1a0644ba',
                    'label' => 'Teaser 1',
                    'name' => '',
                    'type' => 'tab',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'placement' => 'left',
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_5cc2f1f9644bf',
                    'label' => 'Teaser 1',
                    'name' => 'teaser_1',
                    'type' => 'clone',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'clone' => array(
                        0 => 'group_5cb091a6b12f3',
                    ),
                    'display' => 'seamless',
                    'layout' => 'block',
                    'prefix_label' => 0,
                    'prefix_name' => 1,
                ),
                array(
                    'key' => 'field_5cc2f1b0644bb',
                    'label' => 'Products',
                    'name' => '',
                    'type' => 'tab',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'placement' => 'left',
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_5cc30e9f1b966',
                    'label' => 'Headline',
                    'name' => 'products_hl',
                    'type' => 'textarea',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'maxlength' => '',
                    'rows' => 2,
                    'new_lines' => 'br',
                ),
                array(
                    'key' => 'field_5cc2f21e644c1',
                    'label' => 'Products',
                    'name' => 'products',
                    'type' => 'relationship',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'post_type' => array(
                        0 => 'product',
                    ),
                    'taxonomy' => '',
                    'filters' => array(
                        0 => 'search',
                        1 => 'taxonomy',
                    ),
                    'elements' => '',
                    'min' => '',
                    'max' => '',
                    'return_format' => 'id',
                ),
                array(
                    'key' => 'field_5cc2f1b9644bc',
                    'label' => 'Teaser 2',
                    'name' => '',
                    'type' => 'tab',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'placement' => 'left',
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_5cc2f214644c0',
                    'label' => 'Teaser 2',
                    'name' => 'teaser_2',
                    'type' => 'clone',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'clone' => array(
                        0 => 'group_5cb091a6b12f3',
                    ),
                    'display' => 'seamless',
                    'layout' => 'block',
                    'prefix_label' => 0,
                    'prefix_name' => 1,
                ),
                array(
                    'key' => 'field_5cc2f1c3644bd',
                    'label' => 'Instagram',
                    'name' => '',
                    'type' => 'tab',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'placement' => 'left',
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_5cc30f3e1b96a',
                    'label' => 'Headline (Kopie)',
                    'name' => 'instagram_hl',
                    'type' => 'textarea',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'maxlength' => '',
                    'rows' => 2,
                    'new_lines' => 'br',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_template',
                        'operator' => '==',
                        'value' => 'page-templates/tpl-lp-1.php',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => array(
                0 => 'the_content',
                1 => 'discussion',
            ),
            'active' => true,
            'description' => '',
        ));

        acf_add_local_field_group(array(
            'key' => 'group_5cb0942c468cf',
            'title' => 'Shop Inhalt',
            'fields' => array(
                array(
                    'key' => 'field_5cb0943004e51',
                    'label' => 'Clone',
                    'name' => 'clone',
                    'type' => 'clone',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'clone' => array(
                        0 => 'group_5cb091a6b12f3',
                    ),
                    'display' => 'seamless',
                    'layout' => 'block',
                    'prefix_label' => 0,
                    'prefix_name' => 1,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'page',
                        'operator' => '==',
                        'value' => '5',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ));

        acf_add_local_field_group(array(
            'key' => 'group_5cb091a6b12f3',
            'title' => 'MODULE_Content_Repeater',
            'fields' => array(
                array(
                    'key' => 'field_5cb09284241ae',
                    'label' => 'Content Blocks',
                    'name' => 'items',
                    'type' => 'repeater',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'collapsed' => 'field_5cb092ac241af',
                    'min' => 0,
                    'max' => 0,
                    'layout' => 'block',
                    'button_label' => '',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_5cb092ac241af',
                            'label' => 'Image',
                            'name' => 'image',
                            'type' => 'image',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'return_format' => 'array',
                            'preview_size' => 'thumbnail',
                            'library' => 'all',
                            'min_width' => '',
                            'min_height' => '',
                            'min_size' => '',
                            'max_width' => '',
                            'max_height' => '',
                            'max_size' => '',
                            'mime_types' => '',
                        ),
                        array(
                            'key' => 'field_5cb092b5241b0',
                            'label' => 'Background Color',
                            'name' => 'bgc',
                            'type' => 'color_picker',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '50',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                        ),
                        array(
                            'key' => 'field_5cb0966280584',
                            'label' => 'Full Size Background',
                            'name' => 'fs_bg',
                            'type' => 'true_false',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '50',
                                'class' => '',
                                'id' => '',
                            ),
                            'message' => '',
                            'default_value' => 0,
                            'ui' => 0,
                            'ui_on_text' => '',
                            'ui_off_text' => '',
                        ),
                        array(
                            'key' => 'field_5cb092cf241b1',
                            'label' => 'Trademark',
                            'name' => 'trademark',
                            'type' => 'image',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'return_format' => 'array',
                            'preview_size' => 'thumbnail',
                            'library' => 'all',
                            'min_width' => '',
                            'min_height' => '',
                            'min_size' => '',
                            'max_width' => '',
                            'max_height' => '',
                            'max_size' => '',
                            'mime_types' => '',
                        ),
                        array(
                            'key' => 'field_5cb092ed241b2',
                            'label' => 'Headline / Logo',
                            'name' => 'headline_logo',
                            'type' => 'radio',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'choices' => array(
                                'hl' => 'Headline',
                                'logo' => 'Logo',
                            ),
                            'allow_null' => 0,
                            'other_choice' => 0,
                            'default_value' => '',
                            'layout' => 'vertical',
                            'return_format' => 'value',
                            'save_other_choice' => 0,
                        ),
                        array(
                            'key' => 'field_5cb093ae241b3',
                            'label' => 'Headline',
                            'name' => 'hl',
                            'type' => 'textarea',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => array(
                                array(
                                    array(
                                        'field' => 'field_5cb092ed241b2',
                                        'operator' => '==',
                                        'value' => 'hl',
                                    ),
                                ),
                            ),
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'maxlength' => '',
                            'rows' => 2,
                            'new_lines' => 'br',
                        ),
                        array(
                            'key' => 'field_5cb093c9241b4',
                            'label' => 'Logo',
                            'name' => 'logo',
                            'type' => 'image',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => array(
                                array(
                                    array(
                                        'field' => 'field_5cb092ed241b2',
                                        'operator' => '==',
                                        'value' => 'logo',
                                    ),
                                ),
                            ),
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'return_format' => 'array',
                            'preview_size' => 'thumbnail',
                            'library' => 'all',
                            'min_width' => '',
                            'min_height' => '',
                            'min_size' => '',
                            'max_width' => '',
                            'max_height' => '',
                            'max_size' => '',
                            'mime_types' => '',
                        ),
                        array(
                            'key' => 'field_5cb093df241b5',
                            'label' => 'Content',
                            'name' => 'content',
                            'type' => 'wysiwyg',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'tabs' => 'all',
                            'toolbar' => 'full',
                            'media_upload' => 1,
                            'delay' => 0,
                        ),
                        array(
                            'key' => 'field_5cb093f1241b6',
                            'label' => 'Link',
                            'name' => 'link',
                            'type' => 'link',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'return_format' => 'array',
                        ),
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_template',
                        'operator' => '==',
                        'value' => 'page-templates/tpl-modules.php',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ));

        acf_add_local_field_group(array(
            'key' => 'group_5cac8996290d4',
            'title' => 'Product data',
            'fields' => array(
                array(
                    'key' => 'field_5cac899b83f74',
                    'label' => 'Image',
                    'name' => 'image',
                    'type' => 'image',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'return_format' => 'array',
                    'preview_size' => 'thumbnail',
                    'library' => 'all',
                    'min_width' => '',
                    'min_height' => '',
                    'min_size' => '',
                    'max_width' => '',
                    'max_height' => '',
                    'max_size' => '',
                    'mime_types' => '',
                ),
                array(
                    'key' => 'field_product_color',
                    'label' => 'Product-color',
                    'name' => 'product_color',
                    'type' => 'color_picker',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '#fff',
                ),
                array(
                    'key' => 'field_5d41936e9afda',
                    'label' => 'Produkttemplate',
                    'name' => 'product_template',
                    'type' => 'radio',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'choices' => array(
                        1 => 'Café',
                        2 => 'Other',
                    ),
                    'allow_null' => 0,
                    'other_choice' => 0,
                    'default_value' => '',
                    'layout' => 'vertical',
                    'return_format' => 'value',
                    'save_other_choice' => 0,
                ),
                array(
                    'key' => 'field_5cac8e6d83f76',
                    'label' => 'Gebiet / Region',
                    'name' => 'gebiet_region',
                    'type' => 'taxonomy',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_5d41936e9afda',
                                'operator' => '==',
                                'value' => '1',
                            ),
                        ),
                    ),
                    'wrapper' => array(
                        'width' => '50',
                        'class' => '',
                        'id' => '',
                    ),
                    'taxonomy' => 'product_region',
                    'field_type' => 'select',
                    'allow_null' => 0,
                    'add_term' => 1,
                    'save_terms' => 0,
                    'load_terms' => 0,
                    'return_format' => 'object',
                    'multiple' => 0,
                ),
                array(
                    'key' => 'field_5cac89a983f75',
                    'label' => 'Bohnenart',
                    'name' => 'bohnenart',
                    'type' => 'taxonomy',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_5d41936e9afda',
                                'operator' => '==',
                                'value' => '1',
                            ),
                        ),
                    ),
                    'wrapper' => array(
                        'width' => '50',
                        'class' => '',
                        'id' => '',
                    ),
                    'taxonomy' => 'product_flavor',
                    'field_type' => 'select',
                    'allow_null' => 0,
                    'add_term' => 1,
                    'save_terms' => 0,
                    'load_terms' => 0,
                    'return_format' => 'object',
                    'multiple' => 0,
                ),
                array(
                    'key' => 'field_5cac915ddeb31',
                    'label' => 'Geschmack',
                    'name' => 'geschmack',
                    'type' => 'group',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_5d41936e9afda',
                                'operator' => '==',
                                'value' => '1',
                            ),
                        ),
                    ),
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'layout' => 'block',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_5cac915ddeb32',
                            'label' => 'Image',
                            'name' => 'image',
                            'type' => 'image',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'return_format' => 'array',
                            'preview_size' => 'thumbnail',
                            'library' => 'all',
                            'min_width' => '',
                            'min_height' => '',
                            'min_size' => '',
                            'max_width' => '',
                            'max_height' => '',
                            'max_size' => '',
                            'mime_types' => '',
                        ),
                        array(
                            'key' => 'field_5cac915ddeb33',
                            'label' => 'Text',
                            'name' => 'text',
                            'type' => 'textarea',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'maxlength' => '',
                            'rows' => 4,
                            'new_lines' => 'br',
                        ),
                    ),
                ),
                array(
                    'key' => 'field_5cac8f6f9fb14',
                    'label' => 'Herkunft',
                    'name' => 'herkunft',
                    'type' => 'group',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_5d41936e9afda',
                                'operator' => '==',
                                'value' => '1',
                            ),
                        ),
                    ),
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'layout' => 'block',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_5cac8f839fb15',
                            'label' => 'Image',
                            'name' => 'image',
                            'type' => 'image',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'return_format' => 'array',
                            'preview_size' => 'thumbnail',
                            'library' => 'all',
                            'min_width' => '',
                            'min_height' => '',
                            'min_size' => '',
                            'max_width' => '',
                            'max_height' => '',
                            'max_size' => '',
                            'mime_types' => '',
                        ),
                        array(
                            'key' => 'field_5cac8f8c9fb16',
                            'label' => 'Text',
                            'name' => 'text',
                            'type' => 'textarea',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'maxlength' => '',
                            'rows' => 4,
                            'new_lines' => 'br',
                        ),
                    ),
                ),
                array(
                    'key' => 'field_5cac9185deb35',
                    'label' => 'Lieferung',
                    'name' => 'lieferung',
                    'type' => 'group',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_5d41936e9afda',
                                'operator' => '==',
                                'value' => '1',
                            ),
                        ),
                    ),
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'layout' => 'block',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_5cac9185deb36',
                            'label' => 'Image',
                            'name' => 'image',
                            'type' => 'image',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'return_format' => '',
                            'preview_size' => 'thumbnail',
                            'library' => '',
                            'min_width' => '',
                            'min_height' => '',
                            'min_size' => '',
                            'max_width' => '',
                            'max_height' => '',
                            'max_size' => '',
                            'mime_types' => '',
                        ),
                        array(
                            'key' => 'field_5cac9185deb37',
                            'label' => 'Text',
                            'name' => 'text',
                            'type' => 'textarea',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'maxlength' => '',
                            'rows' => 4,
                            'new_lines' => 'br',
                        ),
                    ),
                ),
                array(
                    'key' => 'field_5d419468dfd94',
                    'label' => 'Info Accordions',
                    'name' => 'info_accordions',
                    'type' => 'repeater',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_5d41936e9afda',
                                'operator' => '==',
                                'value' => '2',
                            ),
                        ),
                    ),
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'collapsed' => '',
                    'min' => 0,
                    'max' => 3,
                    'layout' => 'row',
                    'button_label' => '',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_5d419491dfd95',
                            'label' => 'Image',
                            'name' => 'image',
                            'type' => 'image',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'return_format' => 'array',
                            'preview_size' => 'thumbnail',
                            'library' => 'all',
                            'min_width' => '',
                            'min_height' => '',
                            'min_size' => '',
                            'max_width' => '',
                            'max_height' => '',
                            'max_size' => '',
                            'mime_types' => '',
                        ),
                        array(
                            'key' => 'field_5d419496dfd96',
                            'label' => 'Title',
                            'name' => 'title',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                        array(
                            'key' => 'field_5d41949bdfd97',
                            'label' => 'Text',
                            'name' => 'text',
                            'type' => 'textarea',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'maxlength' => '',
                            'rows' => '',
                            'new_lines' => 'br',
                        ),
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'product',
                    ),
                ),
            ),
            'menu_order' => 5,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ));

        endif;

?>