<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<?php /* inputs set up */ ?>
<?php
$shortcoded                 = $inputs['shortcoded'];
$product_id 				= $inputs['productid'];
$product_chosen             = ( $product_id != '' );
$search						= $inputs['search'];
$custom_title				= $inputs['customtitle'];
$custom_content_before		= $inputs['customcontentbefore'];
$show_details				= $inputs['showdetails'];
$show_price					= $inputs['noprice'];
$show_buy_button 			= $inputs['nobuybutton'];
$wrapper_title 				= $inputs['wrappertitle'];
$wrapper_color	 			= $inputs['wrappercolor'];
$rating						= $inputs['rating'];
?>

<?php /* outerbox - search id panel */ ?>
<?php if( current_user_can( 'edit_posts' ) AND !is_preview() AND !is_single() AND $shortcoded == 0 AND ! $product_chosen  ) : ?>

	<div class="amazing_product outerbox">
        
        <p class="setup" >Search and click the product to insert</p>
        
        <div class="searchbox">
            <button onclick="searchClear();" >Clear</button>
            <textarea
            class="searchbar"
            placeholder="Search a product by its title, ASIN or product ID"
            onchange="searchInput(this);" ><?php echo esc_html( $search ); ?></textarea>
            <button onclick="searchGo();" >Search</button>
        </div>
        
        <?php
        $product_filter = array();
        $product_filter ['showposts'] = 5;
        $product_filter ['post_type'] = 'amazing_product';
        
        if( is_numeric( $search ) ) {
            $product_filter['p'] = intval($search);
        }
        else {
            $product_filter['meta_query'] = array(
                array(
                    'key' 		=> 'asin',
                    'value' 	=> $search,
                    'compare' 	=> 'LIKE'
                )
            );
        }
        
        $product = new WP_Query( $product_filter );
        
        if( ! $product->have_posts() ) {
            
            $product_filter['meta_query'] = array();
            $product_filter['p'] = '';
            $product_filter['s'] = $search;
            
            $product = new WP_Query( $product_filter );
            
        }
        
        ?>
        
        <?php // search text
        $searchtext = '';
        if(  $product->have_posts() ) {
            $searchtext = 'These are the latest products added to the database:';
            if( ! empty($search) ) {
                $searchtext = 'You are now searching for: ' . esc_html( $search );	
            }
            ?>
                <p class="setuptip"><?php echo esc_html( $searchtext ); ?></p>
            <?php
        }
        
        ?>
        
        <div class="entrylist">
            <?php if(  $product->have_posts() ) : ?>
                <?php for($i=0;$i<4;$i++) : ?>
                    
                    <?php $product->the_post(); ?>
                    
                    <?php $queried_product_id = get_the_ID(); ?>
                    
                    <?php if(empty($queried_product_id)) continue; ?>
                    
                    <?php
                    $title 	= get_post_meta($queried_product_id, 'custom_title', true);
                    $asin 	= get_post_meta($queried_product_id, 'asin', true);
                    if( empty($title) ) $title = get_the_title();
                    $edit_url = get_edit_post_link();
                    $thumbnail = wp_get_attachment_image(get_post_thumbnail_id($queried_product_id),"medium","",array( "class" => "entryimg" ));
                    if(empty($thumbnail)){
                        $thumbnail = wp_get_attachment_image(get_post_meta($queried_product_id, 'primary_img', true),"medium","",array( "class" => "entryimg" ));
                        if(empty($thumbnail)){
                           $thumbnail = '<img width="300" height="300" src="" class="entryimg product_img no_img_found" alt="' . __('IMG not found', 'amazingaffiliates') . '" >';
                        }
                    }
                    $availability = sanitize_text_field( get_post_meta( $queried_product_id, 'availability', true) );
                    switch ($availability) 	{
						case "Now" : 			$availability_color = 'limegreen';		break;	
						case "Out of Stock" : 	$availability_color = 'tomato';			break;
						default :				$availability_color = 'gold';			break;
					}
                    ?>
                        
                    <div class="entrybox" style="border-color:<?php echo esc_attr( $availability_color ); ?>" onclick="document.getElementById('productid').value = <?php echo esc_attr( $queried_product_id ); ?>; jQuery('#productid').click();">
                        <?php echo wp_kses_post( $thumbnail ); ?>
                        <div class="entrydesc">
                            <p class="entryp"><?php echo esc_html( substr($title, 0, 55) ); ?></p>
                            <p class="entryp"><b>ASIN: </b><?php echo esc_attr( $asin ); ?></p>
                            <p class="entryp"><b>ID: </b><?php echo esc_attr( $queried_product_id ); ?></p>
                        </div>
                    </div>
                    
                <?php endfor; ?>
                
                <p class="setuptip">
                    <big>You can add a new product in the <big>
                        <a target=_blank" class="linktoworkshop" href="<?php echo esc_url( get_admin_url() ); ?>admin.php?page=amazingaffiliates_workshop" >Workshop</a>
                    </big></big>
                </p>


            <?php else: ?>
                
                <p class="setuptip">Sorry, no products found with "<?php echo esc_html( $search ); ?>"<br><br><big>If you have the link or the ASIN of the product, you can add it in the <big><a target=_blank" class="linktoworkshop" href="<?php echo esc_url( get_admin_url() ); ?>admin.php?page=amazingaffiliates_workshop" >Workshop</a></big></big></p>
                
            <?php endif; ?>
        </div>
        
	</div>
	
	<?php wp_reset_postdata(); ?>
	
<?php endif; ?>

<?php /* innerbox - actual product block wth product loaded */ ?>
<?php if( $product_chosen ): ?>

    <?php /* product data setup */
	$title						= $custom_title;
	if(empty($title)) $title	= get_post_meta($product_id, 'custom_title', true );
	if(empty($title)) $title 	= get_the_title ($product_id);
	
	$thumbnail   				= wp_get_attachment_image(get_post_thumbnail_id($product_id),"medium","",array( "class" => "product_img" ));
	if(empty($thumbnail)) $thumbnail = wp_get_attachment_image(get_post_meta($product_id, 'primary_img', true),"medium","",array( "class" => "product_img" ));
	
	$affiliate_link				= get_post_meta($product_id, 'affiliate_link', true);
	$stock						= get_post_meta($product_id, 'stock', true);
	$offer						= get_post_meta($product_id, 'offer', true);
	$discount					= get_post_meta($product_id, 'discount', true);
	$current_price 				= get_post_meta($product_id, 'current_price', true);
	$list_price 				= get_post_meta($product_id, 'list_price', true);

	$buy_button_text = __('Go to Amazon', 'amazingaffiliates');
	$buy_button_text_custom_default = sanitize_text_field( get_option('amazingaffiliates_settings_product_block_buybutton_default_text') );
    if( $buy_button_text_custom_default ) $buy_button_text = $buy_button_text_custom_default;
    
	$wrapper_padding = 'padding:3px;';
	if( empty($wrapper_color) ) $wrapper_color = "lightgray";
	$wrapper_bg = 'background-color:' . $wrapper_color .';';
    if( $wrapper_color == "none" ) {
        $wrapper_padding = 'padding:1px;';
        $wrapper_bg = 'background-color:unset;';    
    }
    ?>
    
    <?php /* wrapper */ ?>
    <div class="amazing_product wrapper" style="<?php echo esc_attr( $wrapper_bg ); echo esc_attr( $wrapper_padding ); ?>">
        
        <?php if($wrapper_title != "" AND $wrapper_color !="none") : ?>
            <p class="wrappertext"><?php echo esc_html( $wrapper_title ); ?></p>
        <?php endif; ?>
        
        <?php /* product_block */ ?>
        <div class="product_block" style="background-color:white;"><?php /* block */ ?>
            
            <?php /* thumbnail */ ?>
            <div class="product_thumbnail" >
                <a  href="<?php echo esc_url( $affiliate_link ); ?>"
                    target="_blank" rel="sponsored nofollow noopener"
                    title="<?php /* translators: browse other images */ echo esc_attr( __('Browse other images', 'amazingaffiliates') ); ?>"
                    >
                    <?php echo wp_kses_post( $thumbnail ); ?>
                </a>
            </div>
            
            <?php /* info */ ?>
            <div class="product_info">    
                
                <?php /* title */ ?>
                <a href="<?php echo esc_url( $affiliate_link ); ?>" target="_blank" rel="sponsored nofollow noopener" title="<?php /* translators: %s: remains %s */ echo esc_attr( sprintf( __('Visit %s on Amazon!', 'amazingaffiliates'), $title) ); ?>" >
                	<p class="product_title"><?php echo esc_html( $title ); ?></p>
                </a>
                
                <?php /* content */ ?>
                <div class="product_content"> 
                    
                    <?php 	echo '<p class="custom_content_before" >' . esc_html( $custom_content_before ) . '</p>'; ?>
                    
                    <?php if( $show_details != 0 ) : ?>
                        <?php
                        $details_output = '';
                        
                        $details = get_post_meta( $product_id, 'custom_details', true );
                        if( empty($details) ) $details = get_post_meta($product_id, 'details', true);
                        
                        if( $show_details != -1 ) { 
                            $explode_filter_clear = array( "<li>","<ul>","</ul>","" );
                            $cleared_details = str_replace( $explode_filter_clear  , "", $details );
                            $rows_raw = explode( "</li>", $cleared_details );
                            $rows = array_filter( $rows_raw );
                            $details_output	= '<ul>';
                            for	($x = 0; $x < $show_details; $x++) {
                                if	( ! empty($rows[$x]) ) $details_output .= '<li>' . $rows[$x] . '</li>';
                            }
                            $details_output 		.= '</ul>';
                        }
                        else{ $details_output = $details; }
                        echo wp_kses_post( $details_output );
                        ?>
                    <?php endif; ?>
                    
                </div>
                
                <?php /* price */ ?>
                <?php if( empty($show_price) AND ! empty( $current_price )  ) : ?>
                    
                    <?php if( ! empty($list_price) AND $list_price > $current_price ): ?>
                        <?php $current_price_prefix = __('Offer', 'amazingaffiliates'); ?>
                        <p class="product_list_price" ><?php echo esc_html( __('List Price', 'amazingaffiliates') ); ?> : <span class="product_barred_price"><?php echo esc_html( $list_price ); ?> €</span></p>
                    <?php else: ?>
                        <?php $current_price_prefix = __('New starting from', 'amazingaffiliates'); ?>
                    <?php endif; ?>
                    
                    <?php 
                    $exploded_price = explode("." , $current_price);
                    if(empty($exploded_price[1])) $exploded_price[1] = "00";
                    ?>
                    
                    <p class="product_current_price">
                        <?php echo esc_html( $current_price_prefix ); ?>: <span class="product_highlighted_price" ><?php echo esc_html( $exploded_price[0] ); ?>.<small><?php echo esc_html( $exploded_price[1] ); ?></small> €</span>
                    </p>
                    
                <?php endif; ?>
                
                <?php /* buy_button */ ?>
                <?php
                /* translators: %s is %s */
                $buy_button_title = sprintf( __('Visit %s on Amazon!', 'amazingaffiliates'), $title);
                ?>
                <?php if ( empty($show_buy_button) ) : ?>
                <a  class="product_buybutton orange jello"
                    href="<?php echo esc_url( $affiliate_link ); ?>"
                    target="_blank"
                    rel="sponsored nofollow noopener"
                    title="<?php echo esc_attr( $buy_button_title ); ?>"
                    ><?php echo esc_html( $buy_button_text ); ?></a>
                <?php endif; ?>
                
            </div>
            
            <?php // automatic offer banner ?>
            <?php if( get_option('amazingaffiliates_settings_product_block_automatic_offer_banner_display') == 1 AND get_option('amazingaffiliates_settings_product_block_automatic_offer_banner_threshold') <= $discount AND $offer == 1 AND $stock >= 0.5 ): ?>
                
                <div class="offer_flip" >
                    <div class="offer_front"><?php echo esc_html( __('Today on sale with a special price!', 'amazingaffiliates') ); ?></div>
                    <div class="offer_rear"><?php echo esc_html( __('Take advantage of this special offer now!', 'amazingaffiliates') ); ?></div>
                </div>
                
            <?php endif; ?>
            
        </div>
        
    </div>

<?php endif; ?>

<?php if( $product_chosen ): ?>
    
    <?php /* bottom editor bar */ ?>
    <?php if( current_user_can( 'edit_posts' ) AND !is_preview() AND !is_single() AND $shortcoded == 0 AND !is_archive() AND !is_home() ): ?>
        
        <?php require( AMAZINGAFFILIATES_PLUGIN_URI . 'public/blocks/product/assets/back_end_icons.php' ); ?>
        
        <?php /* product data setup */
        $asin	= get_post_meta($product_id, 'asin', true );
        $availability_msg = get_post_meta( $product_id, 'availability_msg', true);
        $availability = get_post_meta( $product_id, 'availability', true);
        switch ($availability) {    case "Now" : 			$availability_color = 'ForestGreen';	break;	
                			        case "Out of Stock" : 	$availability_color = 'tomato';	        break;
                				    default :				$availability_color = 'gold';	        break;
        }
        ?>
        
        <div class="amazing_product_editorbar">
            
            <button class="product_asin input tocopy" value="<?php echo esc_attr( $asin ); ?>" data-tagline="ASIN copied!" data-prefix="ASIN: ">ASIN: <?php echo esc_attr( $asin ); ?></button>
            <button class="product_id input tocopy" value="<?php echo esc_attr( $product_id ); ?>" data-tagline="ID copied!"  data-prefix="ID: ">ID: <?php echo esc_attr( $product_id ); ?></button>
			
			<button class="product_availability" onclick="window.open('<?php echo esc_url( $affiliate_link ); ?>')" style="cursor:pointer;background-color:<?php echo esc_attr( $availability_color ); ?>">
				<img alt="" width="20" height="20" title="See on Amazon" src="<?php echo esc_attr( $amazon_icon ); ?>" >
				<?php echo "  " . esc_html( $availability_msg ); ?>
				<span> [➚]</span>
            </button>
            
			<a class="product_edit" target="_blank" rel="noopener" href="<?php echo esc_url( site_url() . '/wp-admin/post.php?post=' . $product_id . '&action=edit' ); ?>" >
				<img alt="" width="28" height="28" src="<?php echo esc_attr( AMAZINGAFFILIATES_PLUGIN_URL . '/admin/img/edit.jpg' ); ?>" >
			</a>
            
		</div>
        	
    <?php endif; ?>

<?php endif; ?>