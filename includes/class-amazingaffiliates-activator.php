<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    AmazingAffiliates
 * @subpackage AmazingAffiliates/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    AmazingAffiliates
 * @subpackage AmazingAffiliates/includes
 * @author     pizza2mozzarella <pizzacondoppiamozzarella@gmail.com>
 */
class AmazingAffiliates_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
	    


  
        /**
         * Flush rewrite rules for custom post registration
         */
        flush_rewrite_rules();
        delete_option( 'rewrite_rules' );
                
        /**
         * Cronjob activation for automatic update with apis
         */
        if ( ! wp_next_scheduled( 'amazingaffiliates_product_update_cron' ) ) {
            	        
            wp_schedule_event( time(), 'amazingaffiliates_product_update_cron_interval', 'amazingaffiliates_product_update_cron' );
            
        }
        
    }

}