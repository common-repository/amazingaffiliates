<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<div id="latest_products" >

	<?php

	require( AMAZINGAFFILIATES_PLUGIN_URI . 'public/blocks/product/assets/back_end_icons.php' );

	foreach($entries as $entry): ?>

			<?php 	

					$currency					= '€';
					$current_price				= @get_post_meta( $entry, 'current_price', true);
					$list_price					= @get_post_meta( $entry, 'list_price', true);
					$discount					= @get_post_meta( $entry, 'discount', true);
					$offer						= @get_post_meta( $entry, 'offer', true);
					$offer_msg					= array( 1 => 'On sale!' );
					$stock						= @get_post_meta( $entry, 'stock', true);
					$condition_value			= @get_post_meta( $entry, 'condition-value', true);
					$merchant_info_name			= @get_post_meta( $entry, 'merchant_info-name', true);
                    
					$product_taxonomies			= array();
					$tax_index = AmazingAffiliates_Admin::$amazingaffiliates_tax_index;
					foreach($tax_index as $taxonomy) {
						$product_taxonomies[$taxonomy['taxSlug']]['list'] = get_the_terms( $entry, $taxonomy['taxSlug'] );
						$product_taxonomies[$taxonomy['taxSlug']]['taxNamePlural'] = $taxonomy['taxNamePlural'];
						$product_taxonomies[$taxonomy['taxSlug']]['taxColor'] = $taxonomy['taxColor'];
					}

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
                                data-tagline="ID copied!" 
                                data-prefix="ID: "
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
						
						
						
						<p class="info">
							<span style="color:lightgray;text-decoration:line-through" >
								<?php echo esc_html( $list_price . $currency ); ?>
							</span>
							<span> -<?php echo esc_html( $discount ); ?>% </span>
							<b style="color:green;" ><?php echo esc_html( $current_price . $currency ); ?></b>
							<span><?php echo esc_html( $offer_msg[$offer] ); ?></span>
						</p>
						
						<p class="info">
                            
							<?php foreach($product_taxonomies as $product_taxonomy): ?>
								
								<?php foreach($product_taxonomy['list'] as $product_taxonomy_entry) : ?>
									
									<span class="taxonomy_label"
										  style="background-color:<?php echo esc_attr( $product_taxonomy['taxColor'] ); ?>"
										  title="This product is tagged with [<?php echo esc_attr( $product_taxonomy_entry->name ); ?>]"
									>
										<?php echo esc_html( $product_taxonomy_entry->name ); ?>
									</span>
                                    
								<?php endforeach; ?>
                                
							<?php endforeach; ?>
							
						</p>
						
						
												
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

	<?php endforeach; ?>
</div>