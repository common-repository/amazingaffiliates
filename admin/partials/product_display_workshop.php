<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<?php //main entry

for($i=0;$i<1;$i++) {

	$entry = $entries[0];

	$creation_date	= sanitize_text_field( get_post_meta( $entry, 'creation_date', true) );
	$last_update	= sanitize_text_field( get_post_meta( $entry, 'last_update', true) );
	$now			= time();
	$delta			= $now - intval($last_update);
	$delta_create	= $now - intval($creation_date);
	
	$asin			= sanitize_text_field( get_post_meta( $entry, 'asin', true) );

	$default = array(
		'shortcoded'                    => 0,
		'productid' 					=> '',
		'search'						=> '',
		'customtitle' 					=> '',
		'customcontentbefore' 		=> '',
		'showdetails'					=> 3,
		'showdescription'				=> 0,
		'showtable'					=> 0,
		'customcontentafter' 			=> '',	
		'noprice' 						=> false,
		'nobuybutton' 				=> false,
		'wrappertitle' 				=> '',
		'wrappercolor' 				=> '',
		'rating' 						=> 0,
	);

	$atts = array(
		'shortcoded'                    => 0,
		'productid' 					=> $entry,
		'search'                        => '',
		'rating' 						=> -1,
		'showdetails'					=> 3,
		'wrappercolor' 				=> 'limegreen',
		'wrappertitle' 				=> 'Added: ' . intval( $delta_create / 60 / 60 / 24 ) . ' days ago - Updated: ' . intval( $delta / 60 ) . ' minutes ago',
	);

	$inputs = shortcode_atts($default, $atts);

	?>

	<div class="product_container product_block">
	    
        <div class="product_toolbar">
			<button
				class="product_update"
				onclick="product_update('<?php echo esc_html( $asin ); ?>' , '<?php echo esc_html( $entry ); ?>' , this);" 
				data-asin="<?php echo esc_attr( $asin ); ?>" data-prod_id="<?php echo esc_attr( $entry ); ?>"
				title="Force refresh this product wth the Amazon APIs"
			>
				<img alt="" width="28" height="28" src="<?php echo esc_attr( AMAZINGAFFILIATES_PLUGIN_URL . '/admin/img/update.jpg' ); ?>" >
			</button>
			<a 
                class="product_edit"
                target="_blank"
                rel="noopener"
                href="<?php echo esc_url( site_url() . '/wp-admin/post.php?post=' . $entry . '&action=edit' ); ?>"
                title="Edit this product"
            >
				<img alt="" width="28" height="28" src="<?php echo esc_attr( AMAZINGAFFILIATES_PLUGIN_URL . '/admin/img/edit.jpg' ); ?>" >
			</a>
			<button
                class="product_delete"
                onclick="product_delete(this);"
                data-asin="<?php echo esc_attr( $asin ); ?>"
                title="Delete this product from your database"
            >
				<img alt="" width="28" height="28" src="<?php echo esc_attr( AMAZINGAFFILIATES_PLUGIN_URL . '/admin/img/delete.jpg' ); ?>" >
			</button>
		</div>

		<?php require( AMAZINGAFFILIATES_PLUGIN_URI . '/public/blocks/product/product_block.php' );	?>

	</div>
	<?php

}

?>

<div id="latest_products" >
	
	<?php   require( AMAZINGAFFILIATES_PLUGIN_URI . 'public/blocks/product/assets/back_end_icons.php' ); ?>
	
	<?php
	
		$i = 0;
		foreach($entries as $entry) {

			if($i++==0) continue;

			$creation_date	= sanitize_text_field( get_post_meta( $entry, 'creation_date', true) );
			$last_update	= sanitize_text_field( get_post_meta( $entry, 'last_update', true) );
			$now			= time();
			$delta			= $now - intval($last_update);			
			$delta_create	= $now - intval($creation_date);
			$asin			= sanitize_text_field( get_post_meta( $entry, 'asin', true) );
			
			$availability = sanitize_text_field( get_post_meta( $entry, 'availability', true) );
			$availability_msg = sanitize_text_field( get_post_meta( $entry, 'availability_msg', true) );
			if( empty($availability_msg) ) $availability_msg = "Stock issues to be checked";
			switch ($availability) 	{
				case "Now" : 			$availability_color = 'limegreen';		break;	
				case "Out of Stock" : 	$availability_color = 'tomato';			break;
				default :				$availability_color = 'gold';			break;
			}
			
			?>

			<div class="product_container">
			    
                <div class="product_toolbar">
					<button
						class="product_update"
						onclick="product_update('<?php echo esc_html( $asin ); ?>' , '<?php echo esc_html( $entry ); ?>' , this);" 
						data-asin="<?php echo esc_attr( $asin ); ?>" data-prod_id="<?php echo esc_attr( $entry ); ?>"
						title="Force refresh this product information with the Amazon APIs"
					>
						<img alt="" width="28" height="28" src="<?php echo esc_attr( AMAZINGAFFILIATES_PLUGIN_URL . '/admin/img/update.jpg' ); ?>" >
					</button>
					<a
                        class="product_edit"
                        target="_blank" rel="noopener"
                        href="<?php echo esc_url( site_url() . '/wp-admin/post.php?post=' . $entry . '&action=edit' ); ?>"
                        title="Edit this product"
                    >
						<img alt="" width="28" height="28" src="<?php echo esc_attr( AMAZINGAFFILIATES_PLUGIN_URL . '/admin/img/edit.jpg' ); ?>" >
					</a>
					<button
                        class="product_delete"
                        onclick="product_delete(this);"
                        data-asin="<?php echo esc_attr( $asin ); ?>"
                        title="Delete this product from your database"
                    >
						<img alt="" width="28" height="28" src="<?php echo esc_attr( AMAZINGAFFILIATES_PLUGIN_URL . '/admin/img/delete.jpg' ); ?>" >
					</button>
				</div>
				 
				<div class="product_tile" style="background-color:<?php echo esc_attr( $availability_color ); ?>;">
					<p class="tile_title" style="background-color:<?php echo esc_attr( $availability_color ); ?>;" >
						<small>Added: <?php echo esc_html( intval($delta_create / 60 / 60 / 24) ); ?> days ago</small><br>
						<small>Updated:  <?php echo esc_html( intval($delta / 60) ); ?> minutes ago</small><br>
					</p>
					
					<div class="inside_tile">

						<div class="product_tile_editorbar">
							<button 
                                class="input tocopy"
                                value="<?php echo esc_attr( $asin ); ?>"
                                data-tagline="ASIN copied!"
                                data-prefix="ASIN: "
                                title="Click to copy the ASIN"
                            >
								<span>ASIN: </span><?php echo esc_attr( $asin ); ?>
							</button>
							<button
                                class="input tocopy"
                                value="<?php echo esc_attr( $entry ); ?>"
                                data-tagline="ID copied!" data-prefix="ID: "
                                title="Click to copy the ID"
                            >
								<span>ID: </span><?php echo esc_attr( $entry ); ?>
							</button>
						</div>

						<?php
						$title	= get_post_meta($entry, 'custom_title', true );
						if(empty($title)){ $title 	= get_the_title ($entry); }
						$title = substr( $title, 0, 72 );
						if(strlen($title)>69) $title .= "...";
						$link	= explode( '?' , get_post_meta($entry, 'affiliate_link', true) );
						$edit_link = site_url() . '/wp-admin/post.php?post=' . $entry . '&action=edit';
						?>
						<a class="product_card" href="<?php echo esc_url( $edit_link ); ?>" target="_blank" rel="noopener" title="Edit this product">
							<span>
							    <?php echo esc_html( $title ); ?>
							    <img class="edittextbutton" alt="" width="28" height="28" src="<?php echo esc_attr( AMAZINGAFFILIATES_PLUGIN_URL . '/admin/img/edit.jpg' ); ?>" >
							</span>
                            <?php echo wp_get_attachment_image(get_post_thumbnail_id($entry),"thumbnail","",array( "class" => "product_img2" )); ?>
						</a>
						
						<div class="product_tile_editorbar">
							<a class="availabilitybutton" style="background-color:<?php echo esc_attr( $availability_color ); ?>"
							   href="<?php echo esc_url( $link[0] . '?' . $link[1] ); ?>" target="_blank" rel="noopener" title="See the product on Amazon"
							   >
								<img alt="" width="20" height="20" title="See on Amazon" src="<?php echo esc_attr( $amazon_icon ); ?>" >
								<?php echo "  " . esc_html( $availability_msg ); ?>
								<span> [➚]</span>
							</a>
						</div>

					</div>
					
				</div>
                
				
			</div>
			<?php

		}

	?>
	
</div>