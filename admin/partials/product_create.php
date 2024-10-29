<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<?php

$response = array();
$asin_array = explode("," , $asin);
$i = 0;
foreach($asin_array as $asin_single) {
        $asin_filter = array(
            'showposts'   => 1,
            'post_type'   => $this->plugin['prefix'] . '_product',
            'meta_query'  => array(
                 array(
                    'key'     => 'asin',
                    'value'   => $asin_single,
                    'compare' => '='
                )
            )
        );
        $existing_product = new WP_Query( $asin_filter );

        if( $existing_product->have_posts() ) {
            $response[$i++] = $asin_single . '&' . $existing_product->posts[0]->ID . '#' . 'Product ' . $asin_single . ' already exists in the database with the id [' . $existing_product->posts[0]->ID . ']! ';
        }
        else {
            $now_time = time();
            $prod_arg = array(
                'meta_input'   => array(
                    'creation_date' => $now_time,
                    'asin' => $asin_single
                ),
				'post_title'    => $asin_single,
                'post_content'  => '',
                'post_status'   => 'publish', 
                'post_type'     => $this->plugin['prefix'] . '_product'
            );
            $prod_id = wp_insert_post( $prod_arg );
            $response[$i++] = $asin_single . '&' . $prod_id . '#' . 'Product ' . $asin_single . ' successfully created with id = [' . $prod_id . ']! ';
        } 

        wp_reset_postdata();
}

return $block;