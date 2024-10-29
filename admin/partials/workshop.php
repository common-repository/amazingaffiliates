<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<?php $amazingaffiliates_page = "insert";  ?>

<main class="amazingaffiliates_admin_page" data-ajax="<?php echo esc_url( get_site_url() ); ?>/wp-admin/admin-ajax.php" data-nonce="<?php echo esc_attr( wp_create_nonce( 'workshop-warehouse' ) ); ?>" >
	
	<div id="navbar" >
		<?php require( AMAZINGAFFILIATES_PLUGIN_URI . '/admin/partials/navbar.php' ); ?>
	</div>
	
	<div id="header" >
		
		<h1 class="amazingaffiliates_admin_page_title">Amazing Affiliates Workshop</h1>
		<h2>Insert products just by copying the ASIN or product URL</h2>
		<p>Here you can insert your Amazon product by using either the Asin or the product link. Once inserted, the product will be automatically registered to the "Amazing Affiliates Warehouse". To display the product on your blog post just copy the product id and paste it on the dedicated field of the "Amazing Product"  Gutenberg Block on the desired post.</p>
		
	</div>
	
	<div id="workshop_forge">
		<input id="asin_purifier" type="text" placeholder="Paste the ASIN or the link">
		<button onclick="clearAsinCrucible();">Clear</button>
		<ol id="asins_crucible" data-asin >
		</ol>
		<button id="insert_products" >Insert products</button>
	</div>
	<div id="consolebox" >
		<div id="console">			
		</div>
		<button id="expand" >+ More +</button>
	</div>
	
	<div class="warehouse_selectors" style="display:none;">
			<div class="warehouse_selector_wrapper" >
				<div class="warehouse_selector labeled" >
					<label for="warehouse_entries_selector">Entries:</label>
					<select name="warehouse_entries_selector" id="warehouse_entries_selector" >
							 <option value="25" selected >Show 25 entries</option>
							 <option value="50" >Show 50 entries</option>
							 <option value="100" >Show 100 entries</option>
					</select>
				</div>
				<div class="warehouse_selector labeled" >
					<label for="warehouse_asin_selector">ASIN:</label>
					<input name="warehouse_asin_selector" id="warehouse_asin_selector" type="text" placeholder="Search by ASIN or url:" >
				</div>
				<div class="warehouse_selector labeled" >
					<label for="warehouse_title_selector">Title:</label>
					<input name="warehouse_title_selector" id="warehouse_title_selector" type="text" placeholder="Search by title:" >
				</div>
			</div>
            <div class="warehouse_selector_wrapper" >
                
                <?php foreach(AmazingAffiliates_Admin::$amazingaffiliates_tax_index as $taxonomy) : ?>
                    
                    <div class="warehouse_selector labeled" >
                        
                        <label><?php echo esc_html( $taxonomy['taxNameSingular'] ); ?>:</label>
                        <div id="warehouse_<?php echo esc_attr( $taxonomy['taxSlug'] ); ?>_selector" >
                            
                            <?php
                            $tax_args = array(
                                'taxonomy' => $taxonomy['taxSlug'],
                                'orderby' => 'name',
                                'order' => 'ASC',
                                'hide_empty' => false
                            );
                            $taxonomy_entries = get_terms( $tax_args );
                            ?>
                            
                            <?php foreach  ($taxonomy_entries as $taxonomy_entry) : ?>
                                
                                <input  type="checkbox"
                                    name="warehouse_<?php echo esc_attr( $taxonomy['taxSlug'] ); ?>_selector"
                                    id="<?php echo esc_html( $taxonomy_entry->slug ); ?>_checkbox"
                                    value="<?php echo esc_attr( $taxonomy_entry->term_id ); ?>"
                                >
                                
                                <label for="<?php echo esc_html( $taxonomy_entry->slug ); ?>_checkbox">
                                    <?php echo esc_html( $taxonomy_entry->name ); ?>
                                </label>
                                
                            <?php endforeach; ?>
                            
                        </div>
                        
                    </div>
                    
                <?php endforeach; ?>
                	
            </div>
		</div>
	
	<section>
		
		<div id="product_display" ></div>
		
	</section>

</main>