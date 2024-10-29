<?php 

if ( ! defined( 'ABSPATH' ) ) exit; 

$custom_taxonomies = array(
    '_product_category' => array(
        'post_type'         => $this->plugin['prefix'] . '_product',
        'taxNameSingular' 	=> 'Product Category',
        'taxNamePlural' 	=> 'Product Categories',
        'taxSlug' 			=> $this->plugin['prefix'] . '_product_category',
        'taxHierarchical'	=> true,
        'taxColor'			=> 'LightSkyBlue'
    ),
    '_product_tag' => array(
        'post_type'         => $this->plugin['prefix'] . '_product',
        'taxNameSingular' 	=> 'Product Tag',
        'taxNamePlural' 	=> 'Product Tags',
        'taxSlug' 			=> $this->plugin['prefix'] . '_product_tag',
        'taxHierarchical'	=> false,
        'taxColor'			=> 'Pink'
    )
);