<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<?php

// setting up asin payload
$asin_payload 	= ''; 
if(count($product_batch)==0) return;
$asin_payload = implode( "," , $product_batch);
$asin_payload = wp_json_encode($product_batch);

$country		=  json_decode( sanitize_text_field( get_option('amazingaffiliates_settings_api_country') ) );

// setting up API payload
$partner_tag 	= sanitize_text_field( get_option('amazingaffiliates_settings_api_partner_tag') );
$partner_type 	= "Associates";
$marketplace	= $country->amazon_domain;
$payload =	"{"
            ." \"ItemIds\": " . $asin_payload . ","
            ." \"Resources\": ["
            ."  \"ItemInfo.Features\","
      		."  \"Images.Primary.Large\","
            ."  \"ItemInfo.Title\","
            ."  \"ItemInfo.ByLineInfo\","
            ."  \"ItemInfo.ManufactureInfo\","
            ."  \"Offers.Listings.Availability.Message\","
            ."  \"Offers.Listings.Availability.Type\","
			."	\"Offers.Listings.Condition\","
            ."  \"Offers.Listings.DeliveryInfo.IsAmazonFulfilled\","
			."	\"Offers.Listings.MerchantInfo\","
            ."  \"Offers.Listings.Price\","
            ."  \"Offers.Listings.SavingBasis\""
            ." ],"
            ." \"PartnerTag\": \"" . $partner_tag  . "\","
            ." \"PartnerType\": \"" . $partner_type  . "\","
            ." \"Marketplace\": \"" . $marketplace  . "\""
            ."}";

// setting up class AwsV4 variables 
$serviceName = "ProductAdvertisingAPI";
$region     = $country->region;
$accessKey  = sanitize_text_field( get_option('amazingaffiliates_settings_api_accessKey') );
$secretKey  = sanitize_text_field( get_option('amazingaffiliates_settings_api_secretKey') );
$host       = $country->pa_endpoint;
$uriPath    = "/paapi5/getitems";

// initializing class AwsV4
require_once( plugin_dir_path( __FILE__ ) . 'PAAPI5_class_AwsV4.php' );

$awsv4 = new AmazingAffiliates_custom_AwsV4 ($accessKey, $secretKey);
$awsv4->setRegionName($region);
$awsv4->setServiceName($serviceName);
$awsv4->setPath ($uriPath);
$awsv4->setPayload ($payload);
$awsv4->setRequestMethod ("POST");
$awsv4->addHeader ('content-encoding', 'amz-1.0');
$awsv4->addHeader ('content-type', 'application/json; charset=utf-8');
$awsv4->addHeader ('host', $host);
$awsv4->addHeader ('x-amz-target', 'com.amazon.paapi5.v1.ProductAdvertisingAPIv1.GetItems');
$headers = $awsv4->getHeaders ();
$headerString = "";
foreach ( $headers as $key => $value ) {
	$headerString .= $key . ': ' . $value . "\r\n";
} 
$params = array (
    'http' => array (
        'header' => $headerString,
		'method' => 'POST',
		'content' => $payload
	)
); 
$stream = stream_context_create( $params ); 

// original amazon code that uses fopen() to access the external resources on the amazon server but with this you get:
// WordPress.WP.AlternativeFunctions.file_system_operations_fopen	"File operations should use WP_Filesystem methods instead of direct PHP filesystem calls. Found: fopen()."
/*
$fp = fopen( 'https://'.$host.$uriPath, 'rb', false, $stream );

if 	(! $fp) { 
//  @throw new Exception ( "Exception Occured" );
    $update_msg =  'ERROR, Failed to fopen the api URL';    
}

// calling the API 
if($fp === false) 	{
    $update_msg =  'ERROR, Failed to get a response from the PAAPI5'; 
    return;
}

$response = @stream_get_contents ( $fp );
*/

$full_response = wp_remote_post(
	'https://'.$host.$uriPath, array(
		'headers' => $headers,
		'method' => 'POST',
		'body' => $payload
));
$http_response =  (array) $full_response['http_response'];
$prefix = chr( 0 ) . '*' . chr( 0 );
$response = $http_response[ $prefix . 'response' ]->body;

// JSON decoding of the API response
if(	$response === false	) {
    $update_msg =  'ERROR, Failed to decode the PAAPI5 JSON response';
    return;
}

$itemResult = json_decode($response);

// setting the response object index
$b = 0;

// updating products data
$response_updated_product_batch = array();
foreach($product_batch as $product ) {
    $batch_asin = '';
    $batch_prod_id = ''; 

    /* identifing the product with prod_id, asin, title and image url */
    if( isset( $itemResult->ItemsResult->Items[$b]->ASIN )  ) {
        $batch_asin = $itemResult->ItemsResult->Items[$b]->ASIN;
    }
    
    $existing_product = new WP_Query(
        array(
            'showposts'   => 1,
            'post_type'   => $this->plugin['prefix'] . '_product',
            'meta_query'  => array(
                array(
                    'key'     => 'asin',
                    'value'   => $batch_asin,
                    'compare' => '='
                )
            )
        )
    );
    
    if( $existing_product->have_posts() ) {
        $batch_prod_id = $existing_product->posts[0]->ID;
    }

    wp_reset_postdata();
    
    $response_updated_product_batch[$b] = array( 'id' => $batch_prod_id , 'asin' => $batch_asin );
    
    /* update api response field */
    update_post_meta( $batch_prod_id, 'api_response', $response );
    
    /* signing the update with timestamps */
    $update_time = time();
   	update_post_meta( $batch_prod_id, 'last_update', $update_time);
    
    // increasing the index
    $b++;
    
}

// resetting the index
$b = 0;

// updating the product fields
foreach($response_updated_product_batch as $response_updated_product ) {
    
    $batch_asin = $response_updated_product['asin'];
    $batch_prod_id = $response_updated_product['id'];
    $batch_title = '';
    $batch_img_url = '';
    $batch_url = '';
    $batch_current_price = '';
    $batch_list_price = '';
    $batch_availability = '';
    $batch_availability_msg = '';
    $batch_condition = '';
    $batch_brand = '';
    $batch_oem = '';
    $batch_model_number = '';
    $batch_model = '';
    
    // image upload and binding
    if( isset( $itemResult->ItemsResult->Items[$b]->Images->Primary->Large->URL )  ) {
        
        $batch_img_url = $itemResult->ItemsResult->Items[$b]->Images->Primary->Large->URL;
        
        $img_unique_title = '[DONT TOUCH THIS FIELD] image for ASIN ' . $batch_asin;
        
        $doubles = new WP_Query(
            array(
                'showposts' => 1,
                'post_type' => 'attachment',
                'post_mime_type' =>'image',
                'post_status' => 'inherit',
                'title' => $img_unique_title
            )
        ); 
        
        if( count( $doubles->posts ) < 1 ) {
            require_once(ABSPATH . 'wp-admin/includes/media.php');
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $thumbnail_id = media_sideload_image( $batch_img_url, intval($batch_prod_id), $img_unique_title, 'id' );
        }
        else {
            $thumbnail_id = $doubles->posts[0]->ID;
        }
        
        wp_reset_postdata();
        
        if( empty( get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true ) ) ) {
            update_post_meta( $thumbnail_id, '_wp_attachment_image_alt', $batch_title );
        }
        
        if( is_numeric($thumbnail_id) ) {
            
            update_post_meta( $batch_prod_id, 'primary_img', $thumbnail_id );
            
            if( empty( get_the_post_thumbnail( $batch_prod_id ) ) ) {
                set_post_thumbnail( $batch_prod_id, $thumbnail_id );
            }
            
        }
        
    }
 
    // updating product title and custom title     
    if( isset( $itemResult->ItemsResult->Items[$b]->ItemInfo->Title->DisplayValue )  ) {
        
        $batch_title = $itemResult->ItemsResult->Items[$b]->ItemInfo->Title->DisplayValue;
        
       	wp_update_post( 
            array(
                'ID'            => $batch_prod_id ,
                'post_title'    => $batch_title
            ),
            true
       	);
       	
       	update_post_meta( $batch_prod_id, 'asin', $batch_asin );
       	
       	$custom_title = get_post_meta( $batch_prod_id, 'custom_title', true);
        if( $custom_title == '' ) {
            update_post_meta( $batch_prod_id, 'custom_title', $batch_title);
        }
       	
    }
    
    // updating product affiliate link
    if( isset( $itemResult->ItemsResult->Items[$b]->DetailPageURL )  ) {
        
        $batch_affiliate_link = $itemResult->ItemsResult->Items[$b]->DetailPageURL;
        
       	if($batch_affiliate_link != '') {
            update_post_meta( $batch_prod_id, 'affiliate_link', $batch_affiliate_link);
       	}
        
    }

    // updating current price, list price, currency, offer and discount */
    if( isset( $itemResult->ItemsResult->Items[$b]->Offers->Listings[0]->Price->Amount )  )	{
        
        $batch_current_price = $itemResult->ItemsResult->Items[$b]->Offers->Listings[0]->Price->Amount;
        
        if($batch_current_price != '') {
           update_post_meta( $batch_prod_id, 'current_price', $batch_current_price);
        }
        
    }
    
    if( isset( $itemResult->ItemsResult->Items[$b]->Offers->Listings[0]->Price->DisplayAmount )  )	{
        
        $batch_currency1 = explode( " ", $itemResult->ItemsResult->Items[$b]->Offers->Listings[0]->Price->DisplayAmount);
        
        if($batch_currency1 != '') {
           update_post_meta( $batch_prod_id, 'currency', $batch_currency1[1]);
        }
        
    }
    
    if( isset( $itemResult->ItemsResult->Items[$b]->Offers->Listings[0]->SavingBasis->Amount )  ) {
        
        $batch_list_price = $itemResult->ItemsResult->Items[$b]->Offers->Listings[0]->SavingBasis->Amount;
        
        if( empty( $batch_list_price) OR $batch_list_price < $batch_current_price )	{
            $batch_list_price = $batch_current_price; 
        }
        
        if($batch_list_price != '') {
            update_post_meta( $batch_prod_id, 'list_price', $batch_list_price);
        }
        
    }
    else {
        
        if($batch_current_price != '') {
           update_post_meta( $batch_prod_id, 'list_price', $batch_current_price);
        }
        
    }
    
    if(intval($batch_list_price) > 0) {
        $batch_discount = round(
            ( ( floatval($batch_list_price) - floatval($batch_current_price) ) / floatval($batch_list_price) ) * 100,
            0
        );
    }
    else {
        $batch_discount = 0;
    }
    update_post_meta( $batch_prod_id, 'discount', $batch_discount);
    
    if( $batch_discount > 0 ) {
        $batch_offer = 1;
    }
    else {
        $batch_offer = 0;
    }
    update_post_meta( $batch_prod_id, 'offer', $batch_offer);
    
    // updating availability, availability message, condition and stock status
    if( isset( $itemResult->ItemsResult->Items[$b]->Offers->Listings[0]->Availability->Type )  )	{
        
        $batch_availability = $itemResult->ItemsResult->Items[$b]->Offers->Listings[0]->Availability->Type;
        
      	if($batch_availability != '') {
      	    update_post_meta( $batch_prod_id, 'availability', $batch_availability);
      	}
      	
    }

    if( isset( $itemResult->ItemsResult->Items[$b]->Offers->Listings[0]->Availability->Message )  )	{
        
        $batch_availability_msg = $itemResult->ItemsResult->Items[$b]->Offers->Listings[0]->Availability->Message;
        
      	if($batch_availability_msg != '') {
      	    update_post_meta( $batch_prod_id, 'availability_msg', $batch_availability_msg);
      	}
      	else {
      	    $batch_availability_msg = get_post_meta( $batch_prod_id, 'availability_msg', true);
      	}
      	
    }
    
    if( isset( $itemResult->ItemsResult->Items[$b]->Offers->Listings[0]->Condition->Value )  )	{
        
        $batch_condition = $itemResult->ItemsResult->Items[$b]->Offers->Listings[0]->Condition->Value;
        
      	if($batch_condition != '') {
            update_post_meta( $batch_prod_id, 'condition-value', $batch_condition);
      	}
      	
    }
    

    if( str_contains(strtolower($batch_availability), 'now') AND str_contains(strtolower($batch_condition), 'new') ) {
        $stock = 1;
    }
    elseif( str_contains(strtolower($batch_availability), 'out') ) {
        $stock = 0;
    }
    else {
        $stock = 0.5;
    }  
    update_post_meta( $batch_prod_id, 'stock', $stock );
 
    // updating merchant_info
    if( isset( $itemResult->ItemsResult->Items[$b]->Offers->Listings[0]->MerchantInfo->Name )  ) {
        
        $batch_merchantinfo = $itemResult->ItemsResult->Items[$b]->Offers->Listings[0]->MerchantInfo->Name;
        
      	if($batch_merchantinfo != '') {
            update_post_meta( $batch_prod_id, 'merchant_info-name', $batch_merchantinfo );
      	}
      	
    }
    
    // updating branding info
    if( isset( $itemResult->ItemsResult->Items[$b]->ItemInfo->ByLineInfo->Brand->DisplayValue )  )	{
        
        $batch_brand = $itemResult->ItemsResult->Items[$b]->ItemInfo->ByLineInfo->Brand->DisplayValue;
      	
    }
    
    if( isset( $itemResult->ItemsResult->Items[$b]->ItemInfo->ByLineInfo->Manufacturer->DisplayValue )  )	{
        
      	$batch_oem = $itemResult->ItemsResult->Items[$b]->ItemInfo->ByLineInfo->Manufacturer->DisplayValue;
      	
    }
    
    if( empty( get_post_meta( $batch_prod_id, 'custom_brand', true) ) ) {
        
        if( ! empty( $batch_brand ) ) {
            $batch_custom_brand = $batch_brand;
        }
        else {
            $batch_custom_brand = $batch_oem;
        }
        
    }
    else {
        
        $batch_custom_brand = get_post_meta( $batch_prod_id, 'custom_brand', true);
        
    }
    
    if( isset( $itemResult->ItemsResult->Items[$b]->ItemInfo->ManufactureInfo->ItemPartNumber->DisplayValue )  ) {
        
        $batch_model_number = $itemResult->ItemsResult->Items[$b]->ItemInfo->ManufactureInfo->ItemPartNumber->DisplayValue;
      	
    }
    
    if( isset( $itemResult->ItemsResult->Items[$b]->ItemInfo->ManufactureInfo->Model->DisplayValue )  )	{
        
      	$batch_model = $itemResult->ItemsResult->Items[$b]->ItemInfo->ManufactureInfo->Model->DisplayValue;
        
    }
    
    if( empty( get_post_meta( $batch_prod_id, 'custom_model', true) ) ) {
        
        $batch_custom_model = $batch_model;
        
        if( ! empty( $batch_model ) ) {
            $batch_custom_model = $batch_model;
        }
        else {
            $batch_custom_model = $batch_model_number;
        }
        
    }
    else {
        
        $batch_custom_model = get_post_meta( $batch_prod_id, 'custom_model', true);
        
    }
    
    $branding = array(
        "brand"             => $batch_brand,
        "oem"               => $batch_oem,
        "custom_brand"      => $batch_custom_brand,
        "model_number"      => $batch_model_number,
        "model"             => $batch_model,
        "custom_model"      => $batch_custom_model
    );
    
    if ( ! empty($branding["brand"]) ) {
        update_post_meta( $batch_prod_id, 'brand', $branding["brand"]);
  	}
  	
  	if ( ! empty($branding["oem"]) ) {
      	    update_post_meta( $batch_prod_id, 'oem', $branding["oem"]);
    }
    
    if ( ! empty($branding["custom_brand"]) ) {
      	    update_post_meta( $batch_prod_id, 'custom_brand', $branding["custom_brand"]);
    }
    
    if ( ! empty($branding["model_number"]) ) {
        update_post_meta( $batch_prod_id, 'model_number', $branding["model_number"]);
  	}
  	
	if ( ! empty($branding["model"]) ) {
        update_post_meta( $batch_prod_id, 'model', $branding["model"]);
  	}
  	
  	if ( ! empty($branding["custom_model"]) ) {
        update_post_meta( $batch_prod_id, 'custom_model', $branding["custom_model"]);
    }
    
    // updating details
    if( isset( $itemResult->ItemsResult->Items[$b]->ItemInfo->Features->DisplayValues )  )	{
        
        $batch_details_raw = $itemResult->ItemsResult->Items[$b]->ItemInfo->Features->DisplayValues;
        
      	if ( ! empty($batch_details_raw) ) {
              
            if ( is_array($batch_details_raw) ) {
                
              $batch_details = '<ul>';
              foreach($batch_details_raw as $batch_detail){
                  $batch_details .= '<li>' . $batch_detail . '</li>';
              }
              $batch_details .= '</ul>';
              
            }
            else{
                
              $batch_details = strval($itemResult->ItemsResult->Items[$b]->ItemInfo->Features->DisplayValues);
              
            }
            
            update_post_meta( $batch_prod_id, 'details', $batch_details);
            
      	}
    }
    
    // signing the complete update with timestamps
    $update_time = time();
   	update_post_meta( $batch_prod_id, 'last_update', $update_time);
    
    // increase the index
    $b++;
    
}