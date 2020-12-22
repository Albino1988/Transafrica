<?php
/**
 * Plugin Name: aThemeArt Theme Helper
 * Plugin URI: http://athemeart.com/
 * Description: Import aThemeArt official themes demo content, widgets and theme settings with just one click..
 * Version: 1.0.2
 * Author: aThemeart
 * Author URI: https://athemeart.com
 * License: GPLv3 or later
 * Text Domain: athemeart-theme-helper
 * Domain Path: /languages/
 *
 * @package athemeart-theme-helper
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * The main plugin class
 */
final class aThemeArt_Theme_Helper {
	public $title_dir_url;
	/**
	 * The single instance of the class
	 *
	 * @var ATA_WC_Variation_Swatches
	 */
	protected static $instance = null;

	/**
	 * Main instance
	 *
	 * @return ATA_WC_Variation_Swatches
	 */
	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
	/**
	* Class constructor.
	*/
	public function __construct() {
	 	$this->title_dir_url = plugin_dir_url( __FILE__ );
		$this->includes();
		$this->init_hooks();
		add_action( 'admin_enqueue_scripts', array(  $this, 'scripts' ) );
	}
	
	/**
	 * Include required core files used in admin and on the frontend.
	 */
	public function includes() {
		
		if( ! function_exists( 'cs_framework_init' ) && ! class_exists( 'CSFramework' ) ) {
			require_once plugin_dir_path( __FILE__ ) .'/vendors/codestar-framework/cs-framework.php';
		}
		if( ! class_exists( 'OCDI_Plugin' ) ) {
			require_once plugin_dir_path( __FILE__ ) .'/vendors/one-click-demo-import/one-click-demo-import.php';
		}
		if ( ! class_exists( 'TGM_Plugin_Activation' ) ) {
			require_once plugin_dir_path( __FILE__ ) .'/inc/class-tgm-plugin-activation.php';
		}
		add_filter( 'cs_shortcode_options', '__return_false' );
		add_filter( 'cs_customize_options', '__return_false' );
		add_filter( 'cs_metabox_options', '__return_false' );
		add_filter( 'cs_framework_settings', '__return_false' );
		add_filter( 'cs_framework_options', '__return_false' );
		add_filter('cs_shortcode_options', '__return_false');
		
		$theme = wp_get_theme();
		$lowername = strtolower( str_replace(' ', '', $theme ) );
		
		if( $lowername == 'businessconsultantfinder' || $theme == 'Business Consultant Finder' ){
			
			require_once plugin_dir_path( __FILE__ ) .'/demo-data/businessconsultantfinder.php';
		}
		
		
	}

	/**
	 * Initialize hooks
	 */
	public function init_hooks() {
		add_action( 'init', array( $this, 'load_textdomain' ) );
	
	}
	

	/**
	 * Load plugin text domain
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'athemeart-theme-helper', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
	
	/**
     * Register scripts
     *
	 * @param $id
	 */
    function scripts($id)
    {
       
        wp_enqueue_style('athemeart-admin', plugin_dir_url( __FILE__ ) . '/css/dashboard.css', false, '');
        
    }

}


/**
 * Main instance of plugin
 *
 * @return ATA_WC_Variation_Swatches
 */
function aThemeArt_Theme_Helper() {
	return aThemeArt_Theme_Helper::instance();
}

add_action( 'plugins_loaded', 'aThemeArt_Theme_Helper' );




