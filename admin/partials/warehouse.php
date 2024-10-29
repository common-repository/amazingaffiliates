<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<?php $amazingaffiliates_page = "edit";  ?>

<main class="amazingaffiliates_admin_page" data-ajax="<?php echo esc_url( get_site_url() ); ?>/wp-admin/admin-ajax.php" data-nonce="<?php echo esc_attr( wp_create_nonce( 'workshop-warehouse' ) ); ?>" >
	
	<div id="navbar" >
		<?php require( AMAZINGAFFILIATES_PLUGIN_URI . '/admin/partials/navbar.php' ); ?>
	</div>
	
	<div id="header" >
		
		<h1 class="amazingaffiliates_admin_page_title">Amazing Affiliates Warehouse</h1>
		<h2>Set a new "default" product title</h2>
		<p>Here you can directly modify the default product title of any product. Just click the edit button next to the title and put your new personalized title on the green "Custom Title" Field. In this way, the product title will be automatically updated on all the blog posts where the product is inserted.</p>
		
	</div>
	
	<div id="workshop_forge"  style="display:none;">
		<input id="asin_purifier" type="text" placeholder="Paste the ASIN or the link">
		<button onclick="clearAsinCrucible();">Clear</button>
		<ol id="asins_crucible" data-asin >
		</ol>
		<button id="insert_products" >Insert products</button>
	</div>
	<div id="consolebox"  style="display:none;">
		<div id="console">			
		</div>
		<button id="expand" >+ More +</button>
	</div>
	
	<div class="warehouse_selectors">
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
				<input name="warehouse_asin_selector" id="warehouse_asin_selector" type="text" placeholder="Search by ASIN:" >
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