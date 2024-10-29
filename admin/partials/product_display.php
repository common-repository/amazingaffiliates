<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<?php ob_start(); ?>

<?php if( isset( $_REQUEST['nonce'] ) ) : ?>

	<?php if( wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['nonce'] ) ), 'workshop-warehouse' ) ) : ?>

		<?php
        $showposts = 25;
		if( isset( $_REQUEST['entries'] ) )     $showposts = intval($_REQUEST['entries']);
		$mode = 'warehouse';
		if( isset( $_REQUEST['mode'] ) )        $mode = sanitize_text_field( wp_unslash( $_REQUEST['mode'] ) );
		$search_title = '';
		if( isset( $_REQUEST['title'] ) )       $search_title = sanitize_text_field( wp_unslash( $_REQUEST['title'] ) );
		$asin = '';
		if( isset( $_REQUEST['asin'] ) )        $asin = sanitize_text_field( wp_unslash( $_REQUEST['asin'] ) );
		
		$product_filter = array(
			'post_type'   				=> 'amazing_product',
			'showposts' 				=> $showposts,
			'no_found_rows' 			=> 'true',
			'update_post_term_cache' 	=> false,                        
		); 
		$product_filter['tax_query'] = array( 'relation' => 'AND' );
		$i = 1;
		$taxonomy_filters = array();
		foreach(AmazingAffiliates_Admin::$amazingaffiliates_tax_index as $taxonomy){         
			if(empty($_REQUEST[$taxonomy['taxSlug']])) continue;
			$product_filter['tax_query'][$i] = array(
				'taxonomy' => $taxonomy['taxSlug'],
				'field' => 'term_id',
				'terms' => array_map( 'sanitize_key' , wp_unslash( $_REQUEST[$taxonomy['taxSlug']] ) ),
				'include_children' => $taxonomy['taxHierarchical'],
				'operator' => 'AND'
			); 
			$i++;
		}	
		if(!empty($asin)) {
			$product_filter['meta_query'][0] = array(
				'key'     => 'asin',
				'value'   => $asin,
				'compare' => 'LIKE',
			);
		}
		if(!empty($search_title)) {
			$product_filter['meta_query'][1] = array(
				'key'     => 'custom_title',
				'value'   => $search_title,
				'compare' => 'LIKE',
			);
		}

		$entries = array();
		$i = 0;

		$product = new WP_Query( $product_filter ); 
		if( $product->have_posts() ) {
			while( $product->have_posts() )	{
				$product->the_post(); 
				$entries[$i++] = get_the_ID();
			}
		}
		else{
			echo 'No results found matching the filters';
		}

		?>

		<?php
			if('workshop' == $mode) require( AMAZINGAFFILIATES_PLUGIN_URI . '/admin/partials/product_display_workshop.php' );
			if('warehouse' == $mode) require( AMAZINGAFFILIATES_PLUGIN_URI . '/admin/partials/product_display_warehouse.php' );
		?>

	<?php endif; ?>

<?php endif; ?>

<?php 

$block = ob_get_clean();

echo wp_json_encode($block);