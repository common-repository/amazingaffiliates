<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    AmazingAffiliates
 * @subpackage AmazingAffiliates/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    AmazingAffiliates
 * @subpackage AmazingAffiliates/includes
 * @author     pizzacondoppiamozzarella <pizzacondoppiamozzarella@gmail.com>
 */
class AmazingAffiliates_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'amazingaffiliates',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}

}