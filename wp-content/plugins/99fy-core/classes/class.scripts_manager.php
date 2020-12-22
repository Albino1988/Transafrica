<?php

namespace NNfy;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

 /**
 * Scripts Manager
 */
 class NNFy_Scripts{

    private static $instance = null;

    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    function __construct(){
        $this->init();
    }

    public function init() {

        // Admin Scripts
        add_action('admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts' ] );

        // Frontend Scripts
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_frontend_scripts' ] );

    }

    /**
    * Admin Scripts
    */

    public function enqueue_admin_scripts(){
        
        // Admin styles
        wp_enqueue_style( 'nnfy-admin-style', NNFY_ADMIN_ASSETS . 'css/admin-options.css', false, NNFY_VERSION );

        // wp core styles
        wp_enqueue_style( 'wp-jquery-ui-dialog' );
        // wp core scripts
        wp_enqueue_script( 'jquery-ui-dialog' );

    }

    /**
     * Enqueue frontend scripts
     */
    public function enqueue_frontend_scripts() {

        // CSS
        wp_enqueue_style(
            'nnfy-main',
            NNFY_ASSETS . 'css/nnfy-main.css',
            NULL,
            NNFY_VERSION
        );

        // JS
        wp_enqueue_script(
            'nnfy-main',
            NNFY_ASSETS . 'js/nnfy-main.js',
            array('jquery'),
            NNFY_VERSION,
            TRUE
        );

    }
    

}

NNFy_Scripts::instance();