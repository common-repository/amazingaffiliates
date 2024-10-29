<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/pizza2mozzarella/amazingaffiliates
 * @since             1.0.0
 * @package           AmazingAffiliates
 *
 * @wordpress-plugin
 * Plugin Name:       AMAZING Affiliates
 * Plugin URI:        https://github.com/pizza2mozzarella/amazingaffiliates
 * Description:       AMAZING Affiliates is the WordPress plugin that will boost your Amazon Affiliates Business.
 * Version:           1.0.7
 * Author:            pizza2mozzarella
 * Author URI:        https://github.com/pizza2mozzarella
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       amazingaffiliates
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'AMAZINGAFFILIATES_VERSION', '1.0.7' );
define( 'AMAZINGAFFILIATES_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'AMAZINGAFFILIATES_PLUGIN_URI', plugin_dir_path( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-amazingaffiliates-activatorr.php
 */
function amazingaffiliates_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-amazingaffiliates-activator.php';
	AmazingAffiliates_Activator::activate();
}
register_activation_hook( __FILE__, 'amazingaffiliates_activate' );

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-amazingaffiliates-deactivator.php
 */
function amazingaffiliates_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-amazingaffiliates-deactivator.php';
	AmazingAffiliates_Deactivator::deactivate();
}
register_deactivation_hook( __FILE__, 'amazingaffiliates_deactivate' );

/**
* The core plugin class that is used to define internationalization, admin-specific hooks, and public-facing site hooks.
*/
require plugin_dir_path( __FILE__ ) . 'includes/class-amazingaffiliates.php';
if( defined( 'AMAZINGAFFILIATESPRO_PLUGIN_URI' ) ) {
	require AMAZINGAFFILIATESPRO_PLUGIN_URI . 'includes/class-amazingaffiliatespro.php';
}

/**
 * Begins execution of the plugin.
 * Since everything within the plugin is registered via hooks, then kicking off the plugin from this point in the file does not affect the page life cycle.
 *
 * @since    1.0.0
 */
function amazingaffiliates_run() {
	$plugin = new AmazingAffiliates();
	$plugin->run();
}

if( ! in_array('amazingaffiliatespro/amazingaffiliatespro.php', apply_filters('active_plugins', get_option('active_plugins'))) ) {
	amazingaffiliates_run();
}