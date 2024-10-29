<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<?php
    ob_start();
?>

<?php

/* setting up asin payload */
echo esc_attr( $asin );

/* finding the attachments */
$thumbnail_id = "";
require_once(ABSPATH . 'wp-admin/includes/media.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');
$attachment_finder = array(	'showposts' => 1,
							'post_type' => 'attachment',
							'post_mime_type' =>'image',
							's' => '[DONT TOUCH THIS FIELD] image for ASIN ' . $asin
);
$attachment = new WP_Query( $attachment_finder );
if		( 	count( $attachment->posts ) >= 1 )
		{ 	$thumbnail_id = $attachment->posts[0]->ID;  }
wp_reset_postdata();

/* finding the id */
$prod_id = "";
$prod_finder = array(	'showposts' => 1,
                        'post_type' => $this->plugin['prefix'] . '_product',
                        'meta_query'  => array(	array(	'key'     => 'asin',
                                                        'value'   => $asin,
                                                        'compare' => '='		 )	)
);
$product = new WP_Query( $prod_finder );
if		( 	count( $product->posts ) >= 1 )
		{ 	$prod_id = $product->posts[0]->ID;  }
else	{	echo 'Product not found in the database!'; return; }
wp_reset_postdata();

$thumbnail_id = get_post_thumbnail_id($prod_id);

/* trashing all */
if($thumbnail_id != "") wp_trash_post( $thumbnail_id );
if($prod_id != "") wp_trash_post( $prod_id );

?>

<?php
$block = ob_get_clean();
$block = 'prova';
?>