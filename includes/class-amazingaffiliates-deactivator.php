<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Fired during plugin deactivation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    AmazingAffiliates
 * @subpackage AmazingAffiliates/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    AmazingAffiliates
 * @subpackage AmazingAffiliates/includes
 * @author     pizza2mozzarella <pizzacondoppiamozzarella@gmail.com>
 */
class AmazingAffiliates_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
        
        /**
         * Flush rewrite rules for custom post types
         */
        flush_rewrite_rules();
        
        /**
         * Deactivate plugin cronjobs
         */
        wp_clear_scheduled_hook( 'amazingaffiliates_product_update_cron' );
        
	}

}