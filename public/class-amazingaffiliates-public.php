<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * The public-facing functionality of the plugin.
 * Defines the plugin name, version, and two examples hooks for how to enqueue the public-facing stylesheet and JavaScript.
 *
 * @link       http://example.com
 * @since      1.0.0
 *  
 * @package    AmazingAffiliates
 * @subpackage AmazingAffiliates/public
 * @author     pizza2mozzarella <pizzacondoppiamozzarella@gmail.com>
 */
class AmazingAffiliates_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string    $plugin_name    The name of the plugin.
	 * @param    string    $version        The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'product_block_frontend_style', plugin_dir_url( __FILE__ ) . 'blocks/product/block.css', array(), microtime(), 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
//		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/plugin-name-public.js', array( 'jquery' ), microtime(), false );
	}
	
    /**
	 * Plugin custom blocks
	 *
	 * @since    1.0.0
	 */
    public function register_shortcode_blocks() {
        
        add_shortcode('amazingaffiliates_product' , 'shortcode_product_block');
        
        function shortcode_product_block($atts) {
            
            $default = array(
                'shortcoded'                    => 1,
                'productid' 					=> '',
                'search'						=> '',
                'customtitle' 					=> '',
                'customcontentbefore' 			=> '',
                'showdetails'					=> 0,
                'noprice' 						=> false,
                'nobuybutton' 					=> false,
                'wrappertitle' 					=> '',
                'wrappercolor' 					=> '',
            );
            
            $inputs = shortcode_atts($default, $atts);
			
            ob_start();
			
            require( plugin_dir_path( __FILE__ ) . 'blocks/product/product_block.php' );
            
            $block = ob_get_clean();
            
            return $block;
        }
        
    }
    
    public function product_block() {
        // automatically load dependencies and version
        $asset_file = include( plugin_dir_path( __FILE__ ) . 'blocks/product/index.asset.php');
        
        wp_register_script(
            'product_block_script',
            plugins_url( 'blocks/product/block.js', __FILE__ ),
            $asset_file['dependencies'],
//          $asset_file['version']
			microtime(),
			array( 'async', true )
        );
        
        register_block_type(
            'amazingaffiliates/product',
            array(
                'api_version' => 3,
                'category' => 'text',
                'attributes'  => array(
                    'refresh'				=> array( 'type' => 'boolean', 	'default' => false ),
                    'productid'  			=> array( 'type' => 'string', 	'default' => '' ),
                    'search'  				=> array( 'type' => 'string', 	'default' => '' ),
                    'wrappertitle'  		=> array( 'type' => 'string', 	'default' => '' ),
                    'wrappercolor'  		=> array( 'type' => 'string', 	'default' => '' ),
                    'customtitle'   		=> array( 'type' => 'string', 	'default' => '' ),					
                    'customcontentbefore' 	=> array( 'type' => 'string', 	'default' => '' ),
                    'showdetails'			=> array( 'type' => 'integer', 	'default' => 3 ),
                    'noprice'				=> array( 'type' => 'boolean', 	'default' => false ),
                    'nobuybutton'			=> array( 'type' => 'boolean', 	'default' => false )
                ),
                'editor_script'             => 'product_block_script',
                'render_callback'           => 'product_block_callback',
                'skip_inner_blocks'         => true
            )
        );
        
        function product_block_callback( $block_attributes, $content ) {
            	
            $default = array(
                'shortcoded'                => 0,
                'productid' 				=> '',
                'search'					=> '',
                'customtitle' 				=> '',
                'customcontentbefore'		=> '',
                'showdetails'				=> 3,
                'noprice' 					=> false,
                'nobuybutton' 				=> false,
                'wrappertitle' 				=> '',
                'wrappercolor' 				=> ''
            );
            
            $atts = array(
                'productid' 				=> $block_attributes['productid'],
                'search'					=> $block_attributes['search'],
                'customtitle' 				=> $block_attributes['customtitle'],
                'customcontentbefore' 		=> $block_attributes['customcontentbefore'],
                'showdetails'				=> $block_attributes['showdetails'],
                'noprice' 					=> $block_attributes['noprice'],
                'nobuybutton' 				=> $block_attributes['nobuybutton'],
                'wrappertitle' 				=> $block_attributes['wrappertitle'],
                'wrappercolor' 				=> $block_attributes['wrappercolor']
            );
            
            $inputs = shortcode_atts($default, $atts);
            
			ob_start();
			
            require( plugin_dir_path( __FILE__ ) . 'blocks/product/product_block.php' );
            
            $block = ob_get_clean();
            
            return $block;
            
        }
        
    }
    
    public function product_pages_automatic_content_filter_hook() {
        
        function product_pages_automatic_content_filter($content) {
            
            if ( get_post_type( get_the_ID() ) == 'amazing_product' && boolval((int) get_option("amazingaffiliates_settings_product_pages_automatic_content")) && is_singular() && in_the_loop() && is_main_query() ) {
                $automatic_blocks = '<!-- wp:amazingaffiliates/product {"productid":"' . get_the_ID() .'","showdetails":-1,"showdescription":-1,"showtable":-1} /-->';
                return do_blocks($automatic_blocks) . $content;
            }
            else {
                return $content;
            }
            
        }
        add_filter( 'the_content', 'product_pages_automatic_content_filter' );
        
        function product_pages_custom_title_filter( $title ) {
            $custom_title = get_post_meta( get_the_ID(), 'custom_title' , true);
            if(empty($custom_title)) $custom_title = $title;
            return $custom_title;
        }
        add_filter( 'the_title', 'product_pages_custom_title_filter' );
        
    }
    
    public function post_with_product_block_automatic_footer_filter_hook() {
        
        function post_with_product_block_automatic_footer_filter($content) {
            
            if ( str_contains($content, 'amazing_product') ) {
                $referral = '
                    <a  target="_blank"
                        rel="noopener"
                        href="https://wordpress.org/plugins/amazingaffiliates/"
                    >Amazing Affiliates</a>
                ';
                $last_line = '
                    <i  id="amazingaffiliates_disclosure"
                        style="color:gray;"
                    >Affiliation links, images and data of the products featured in this page are obtained from Amazon Product Advertising API through ' . $referral . '</i>
                ';
                return $content . $last_line;
            }
            else {
                return $content;
            }
            
        }
        add_filter( 'the_content', 'post_with_product_block_automatic_footer_filter' );
        
    }
    
}