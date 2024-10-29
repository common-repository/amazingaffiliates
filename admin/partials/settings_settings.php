<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<?php

	$settings_groups = array(
		"api"               => array(  "name" => "api" ,            "title" => "Amazon APIs Setup" ,            "desc" => "" ),
		"product"           => array(  "name" => "product" ,        "title" => "Product Page Settings" ,        "desc" => "" ),
		"product_block"     => array(  "name" => "product_block" ,  "title" => "Product Block Settings" ,       "desc" => "" )
	);

    $settings = array();
	
	$settings["api"]["country"] = array(
	    "type"      => "config",
	    "name"      => "country",
	    "display"   => "Country",
	    "desc"      => "[IMPORTANT] Select the right Amazon Marketplace you are affiliated with",
	    "options"   => array(
	       array(
        		'name'          => '- SELECT -',
        		'amazon_domain' => '',
        		'pa_endpoint'   => '',
        		'region'        => '',
        	),
        	array(
        		'name'          => 'United States',
        		'amazon_domain' => 'www.amazon.com',
        		'pa_endpoint'   => 'webservices.amazon.com',
        		'region'        => 'us-east-1',
        	),
        	array(
        		'name'          => 'Australia',
        		'amazon_domain' => 'www.amazon.com.au',
        		'pa_endpoint'   => 'webservices.amazon.com.au',
        		'region'        => 'us-west-2',
        	),
        	array(
        		'name'          => 'Belgium',
        		'amazon_domain' => 'www.amazon.com.be',
        		'pa_endpoint'   => 'webservices.amazon.com.be',
        		'region'        => 'eu-west-1',
        	),
        	array(
        		'name'          => 'Brazil',
        		'amazon_domain' => 'www.amazon.com.br',
        		'pa_endpoint'   => 'webservices.amazon.com.br',
        		'region'        => 'us-east-1',
        	),
        	array(
        		'name'          => 'Canada',
        		'amazon_domain' => 'www.amazon.ca',
        		'pa_endpoint'   => 'webservices.amazon.ca',
        		'region'        => 'us-east-1',
        	),
        	array(
        		'name'          => 'China',
        		'amazon_domain' => 'www.amazon.cn',
        		'pa_endpoint'   => 'webservices.amazon.cn',
        		'region'        => 'us-east-1',
        	),
        	array(
        		'name'          => 'Egypt',
        		'amazon_domain' => 'www.amazon.eg',
        		'pa_endpoint'   => 'webservices.amazon.eg',
        		'region'        => 'eu-west-1',
        	),
        	array(
        		'name'          => 'France',
        		'amazon_domain' => 'www.amazon.fr',
        		'pa_endpoint'   => 'webservices.amazon.fr',
        		'region'        => 'eu-west-1',
        	),
        	array(
        		'name'          => 'Germany',
        		'amazon_domain' => 'www.amazon.de',
        		'pa_endpoint'   => 'webservices.amazon.de',
        		'region'        => 'eu-west-1',
        	),
        	array(
        		'name'          => 'India',
        		'amazon_domain' => 'www.amazon.in',
        		'pa_endpoint'   => 'webservices.amazon.in',
        		'region'        => 'eu-west-1',
        	),
        	array(
        		'name'          => 'Italy',
        		'amazon_domain' => 'www.amazon.it',
        		'pa_endpoint'   => 'webservices.amazon.it',
        		'region'        => 'eu-west-1',
        	),
        	array(
        		'name'          => 'Japan',
        		'amazon_domain' => 'www.amazon.co.jp',
        		'pa_endpoint'   => 'webservices.amazon.co.jp',
        		'region'        => 'us-west-2',
        	),
        	array(
        		'name'          => 'Mexico',
        		'amazon_domain' => 'www.amazon.com.mx',
        		'pa_endpoint'   => 'webservices.amazon.com.mx',
        		'region'        => 'us-east-1',
        	),
        	array(
        		'name'          => 'Netherlands',
        		'amazon_domain' => 'www.amazon.nl',
        		'pa_endpoint'   => 'webservices.amazon.nl',
        		'region'        => 'eu-west-1',
        	),
        	array(
        		'name'          => 'Poland',
        		'amazon_domain' => 'www.amazon.pl',
        		'pa_endpoint'   => 'webservices.amazon.pl',
        		'region'        => 'eu-west-1',
        	),
        	array(
        		'name'          => 'Saudi Arabia',
        		'amazon_domain' => 'www.amazon.sa',
        		'pa_endpoint'   => 'webservices.amazon.sa',
        		'region'        => 'eu-west-1',
        	),
        	array(
        		'name'          => 'Sweden',
        		'amazon_domain' => 'www.amazon.se',
        		'pa_endpoint'   => 'webservices.amazon.se',
        		'region'        => 'us-west-1',
        	),
        	array(
        		'name'          => 'Singapore',
        		'amazon_domain' => 'www.amazon.sg',
        		'pa_endpoint'   => 'webservices.amazon.sg',
        		'region'        => 'us-west-2',
        	),
        	array(
        		'name'          => 'Spain',
        		'amazon_domain' => 'www.amazon.es',
        		'pa_endpoint'   => 'webservices.amazon.es',
        		'region'        => 'eu-west-1',
        	),
        	array(
        		'name'          => 'Turkey',
        		'amazon_domain' => 'www.amazon.com.tr',
        		'pa_endpoint'   => 'webservices.amazon.com.tr',
        		'region'        => 'eu-west-1',
        	),
        	array(
        		'name'          => 'United Arab Emirates',
        		'amazon_domain' => 'www.amazon.ae',
        		'pa_endpoint'   => 'webservices.amazon.ae',
        		'region'        => 'eu-west-1',
        	),
        	array(
        		'name'          => 'United Kingdom',
        		'amazon_domain' => 'www.amazon.co.uk',
        		'pa_endpoint'   => 'webservices.amazon.co.uk',
        		'region'        => 'eu-west-1',
        	)
	    )
	);
	
	$settings["api"]["partner_tag"] = array(
	    "type"      => "text",
	    "name"      => "partner_tag",
	    "display"   => "Partner Tag",
	    "desc"      => "[IMPORTANT] Insert your Amazon Affiliate Partner Tag for link affiliation",
	);
	
	$settings["api"]["accessKey"] = array(
	    "type"      => "text",
	    "name"      => "accessKey",
	    "display"   => "Access Key",
	    "desc"      => "[IMPORTANT] Insert your personal Amazon Product API Access Key, you can generate it in you Amazon Affiliates personal dashboard",
	);
	
	$settings["api"]["secretKey"] = array(
	    "type"      => "password",
	    "name"      => "secretKey",
	    "display"   => "Secret Key",
	    "desc"      => "[IMPORTANT] Insert your personal Amazon Product API Secret Key, you can generate it in you Amazon Affiliates personal dashboard",
	);
	
	$settings["product"]["pages_public_status"] = array(
	    "type"      => "select",
	    "name"      => "pages_public_status",
	    "display"   => "Product Pages Visibility on Frontend",
	    "options"   => array(
	        array( "value" => 1,        "innerText" => "Public"         ),
	        array( "value" => 0,        "innerText" => "Private"        )
	    )
	);
	
	$settings["product"]["pages_automatic_content"] = array(
	    "type"      => "select",
	    "name"      => "pages_automatic_content",
	    "display"   => "Auto Add Content to Product Pages",
	    "options"   => array(
	        array( "value" => 1,        "innerText" => "Add a Product Block"        ),
	        array( "value" => 0,        "innerText" => "No"                         )
	    )
	);
	
	$settings["product_block"]["automatic_offer_banner_display"] = array(
	    "type"      => "select",
	    "name"      => "automatic_offer_banner_display",
	    "display"   => "Display an offer banner inside the Product Blocks if product has discount",
	    "options"   => array(
	        array( "value" => 1,        "innerText" => "Show offer banner"        ),
	        array( "value" => 0,        "innerText" => "Hide offer banner"        )
	    )
	);
	
	$settings["product_block"]["automatic_offer_banner_threshold"] = array(
	    "type"      => "number",
	    "name"      => "automatic_offer_banner_threshold",
	    "display"   => "Minimum discount threshold in % to show the offer banner"
	);

	$settings["product_block"]["buybutton_default_text"] = array(
	    "type"      => "text",
	    "name"      => "buybutton_default_text",
	    "display"   => "Your custom default text for the Buy Button"
	);