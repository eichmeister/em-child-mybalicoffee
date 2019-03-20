<?php

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
                'logo_header' => get_stylesheet_directory_uri().'/assets/images/logo.png',
                'logo_footer' => get_stylesheet_directory_uri().'/assets/images/logo.png',  
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

        if (is_page_template('page-templates/tpl-lp-1.php')) {

    		// LP01
    		
    		wp_enqueue_style( 'style-lp-1-css', get_stylesheet_directory_uri()."/assets/css/style-lp-1.css" );
    		wp_enqueue_style( 'style-odometer-css', get_template_directory_uri()."/assets/css/lib/odometer_default.css" );
    		wp_enqueue_script( 'page-lp-1-js', get_stylesheet_directory_uri()."/assets/js/page-lp-1.js", array(), '1.0.0', true );

            wp_enqueue_script( 'odometer-js', get_template_directory_uri()."/assets/js/lib/odometer.min.js", array(), '1.0.0', true );
            wp_enqueue_script( 'typed-js', get_template_directory_uri()."/assets/js/lib/typed.min.js", array(), '1.0.0', true );

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

        <!--
        <script>    (function(d)  {        var  config  =  {            kitId:  'cur4mtc',            scriptTimeout:  3000,            async:  true        },       h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='https://use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)    })(document);</script>
        -->

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

?>