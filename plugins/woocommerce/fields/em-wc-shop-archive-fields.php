<?php

if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_shop_archive_hero_simple',
        'title' => 'Shop Archive',
        'fields' => array(
            array(
                'key' => 'field_5c62971ffc684',
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
                'key' => 'field_5c629be0939a7',
                'label' => 'Hide Intro Hero Section?',
                'name' => 'intro_hide',
                'type' => 'true_false',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'message' => '',
                'default_value' => 0,
                'ui' => 1,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ),
            array(
                'key' => 'field_5c629738fc685',
                'label' => 'Intro Hero',
                'name' => 'intro_hero',
                'type' => 'clone',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_5c629be0939a7',
                            'operator' => '!=',
                            'value' => '1',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'clone' => array(
                    0 => 'group_module_hero_simple_opacity_overlay',
                ),
                'display' => 'group',
                'layout' => 'block',
                'prefix_label' => 0,
                'prefix_name' => 1,
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'page',
                    'operator' => '==',
                    'value' => wc_get_page_id( 'shop' )
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => array (
            0 => 'the_content',
            1 => 'excerpt',
        ),
        'active' => 1,
        'description' => '',
    ));

    acf_add_local_field_group(array(
        'key' => 'group_product_cat_hero_simple',
        'title' => 'Product Cat',
        'fields' => array(
            array(
                'key' => 'product_cat_intro_hide',
                'label' => 'Hide Intro Hero Section?',
                'name' => 'intro_hide',
                'type' => 'true_false',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'message' => '',
                'default_value' => 0,
                'ui' => 1,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ),
            array(
                'key' => 'product_cat_intro_hero',
                'label' => 'Intro Hero',
                'name' => 'intro_hero',
                'type' => 'clone',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'product_cat_intro_hide',
                            'operator' => '!=',
                            'value' => '1',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'clone' => array(
                    0 => 'group_module_hero_simple',
                ),
                'display' => 'group',
                'layout' => 'block',
                'prefix_label' => 0,
                'prefix_name' => 1,
            ),
        ),
        'location' => array (
            array(
                array(
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'product_cat',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => 1,
        'description' => '',
    ));

endif;