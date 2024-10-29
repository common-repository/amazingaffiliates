<?php 

if ( ! defined( 'ABSPATH' ) ) exit; 

$custom_post_types = array(
    '_product' => array(
        'slug'              => $this->plugin['prefix'] . '_product',
        'name'              => 'Products',
        'singular_name'     => 'Product',
        'description'       => 'A product post type to store the product info in the wp database',
        'public'      		=> boolval((int) get_option("amazingaffiliates_settings_product_pages_public_status")),
        'taxonomies'		=> array( $this->plugin['prefix'] . '_product_category' ),
        'has_archive' 		=> true,
        'show_in_rest'		=> true,
        'menu_icon' 		=> 'dashicons-amazon',
        'supports'			=> array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
        'delete_with_user' 	=> false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => boolval((int) get_option("amazingaffiliates_settings_product_pages_public_status")),
        'show_ui'               => true,
        'show_in_nav_menus'     => true,
        'show_in_rest'          => true
    )
);