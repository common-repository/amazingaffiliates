<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * The core plugin class.
 * 
 * A class definition that includes attributes and functions used across both the public-facing side of the site and the admin area.
 *
 * This is used to define internationalization, admin-specific hooks, and public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current version of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 * @package    AmazingAffiliates
 * @subpackage AmazingAffiliates/includes
 * @author     pizza2mozzarella <pizzacondoppiamozzarella@gmail.com>
 */
 
class AmazingAffiliates {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power the plugin.
	 *
	 * @since    1.0.0
	 * @var      Amazing_Affiliates_Assistant_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'AMAZINGAFFILIATES_VERSION' ) ) {
			$this->version = AMAZINGAFFILIATES_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'amazingaffiliates';
		$this->load_dependencies();
		$this->set_locale();	
		$this->define_admin_hooks_uncore();	
		$this->define_admin_hooks_core();
		$this->define_public_hooks_uncore();
		$this->define_public_hooks_core();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - AmazingAffiliates_Loader. Orchestrates the hooks of the plugin.
	 * - AmazingAffiliates_i18n. Defines internationalization functionality.
	 * - AmazingAffiliates_Admin. Defines all hooks for the admin area.
	 * - AmazingAffiliates_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	protected function load_dependencies() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-amazingaffiliates-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-amazingaffiliates-i18n.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-amazingaffiliates-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-amazingaffiliates-public.php';
		$this->loader = new AmazingAffiliates_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the AmazingAffiliates_i18n class in order to set the domain and to register the hook with WordPress.
	 *
	 * @since    1.0.0
	 */
	protected function set_locale() {
		$plugin_i18n = new AmazingAffiliates_i18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 */
	protected function define_admin_hooks_uncore() {
	    $plugin_admin = new AmazingAffiliates_Admin( $this->get_plugin_name(), $this->get_version() );
	    
	     // custom meta field Ui and functionality		
		$this->loader->add_action( 'init', $plugin_admin, 'register_custom_post_meta' );
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'add_custom_post_meta_metaboxes' );
		$this->loader->add_action( 'save_post', $plugin_admin, 'save_custom_post_meta_metaboxes' );
		// menu page
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'dashboard_page' );
	}
	protected function define_admin_hooks_core() {
	    $plugin_admin = new AmazingAffiliates_Admin( $this->get_plugin_name(), $this->get_version() );
	    
	    // scripts and styles
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		
		// custom post, taxonomies and meta registration
		$this->loader->add_action( 'init', $plugin_admin, 'register_custom_post_types' );
		$this->loader->add_action( 'init', $plugin_admin, 'register_custom_taxonomies' );
		// admin area customizations
		$this->loader->add_action( 'init', $plugin_admin, 'admin_area_customizations' );
		// navbar
		$this->loader->add_action( 'amazingaffiliates_navbar', $plugin_admin, 'navbar' );
		// product insertion page
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'workshop_page' );
		// product editing page
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'warehouse_page' );
		$this->loader->add_action( 'wp_ajax_product_display', $plugin_admin, 'product_display_callback' );
		$this->loader->add_action( 'wp_ajax_product_delete', $plugin_admin, 'product_delete_callback' );
		$this->loader->add_action( 'wp_ajax_product_update', $plugin_admin, 'product_update_callback' );
		$this->loader->add_action( 'wp_ajax_product_create', $plugin_admin, 'product_create_callback' );
		// tutorial and faq page
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'handbook_page' );
		// settings page
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'settings_page' );
		// product info automatic refresh
		$this->loader->add_action( 'cron_schedules', $plugin_admin, 'amazingaffiliates_product_update_cron_custom_schedule' );
		$this->loader->add_action( 'amazingaffiliates_product_update_cron', $plugin_admin, 'amazingaffiliates_product_update_cron_callback' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	protected function define_public_hooks_uncore() {

		$plugin_public = new AmazingAffiliates_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		
		/**
         * Plugin custom actions
         *
         * @since    1.0.0
         */
		// product block
		$this->loader->add_action( 'init', $plugin_public, 'register_shortcode_blocks' );
		$this->loader->add_action( 'init', $plugin_public, 'product_block' );
		// automatic content for product custom post type
        $this->loader->add_action( 'init', $plugin_public, 'product_pages_automatic_content_filter_hook' );
        // WIP automatic footer for posts with product blocks
//        $this->loader->add_action( 'init', $plugin_public, 'post_with_product_block_automatic_footer_filter_hook' );
	}
	protected function define_public_hooks_core() {

		$plugin_public = new AmazingAffiliates_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		
		/**
         * Plugin custom actions
         *
         * @since    1.0.0
         */

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Amazing_Affiliates_Assistant_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}