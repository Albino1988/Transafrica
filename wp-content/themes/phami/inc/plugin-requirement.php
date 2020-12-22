<?php
/***** Active Plugin ********/
add_action( 'tgmpa_register', 'phami_register_required_plugins' );
function phami_register_required_plugins() {
    $plugins = array(
		array(
            'name'               => esc_html__('Woocommerce', 'phami'), 
            'slug'               => 'woocommerce', 
            'required'           => false
        ),
		array(
            'name'      		 => esc_html__('Elementor', 'phami'),
            'slug'     			 => 'elementor',
            'required' 			 => false
        ),		
		array(
            'name'               => esc_html__('Revolution Slider', 'phami'), 
			'slug'               => 'revslider',
			'source'             => get_template_directory() . '/plugins/revslider.zip', 
			'required'           => true, 
        ),
		array(
            'name'               => esc_html__('Wpbingo Core', 'phami'), 
            'slug'               => 'wpbingo', 
            'source'             => get_template_directory() . '/plugins/wpbingo.zip',
            'required'           => true, 
        ),			
		array(
            'name'               => esc_html__('Redux Framework', 'phami'), 
            'slug'               => 'redux-framework', 
            'required'           => false
        ),			
		array(
            'name'      		 => esc_html__('Contact Form 7', 'phami'),
            'slug'     			 => 'contact-form-7',
            'required' 			 => false
        ),	
		array(
            'name'     			 => esc_html__('YITH Woocommerce Wishlist', 'phami'),
            'slug'      		 => 'yith-woocommerce-wishlist',
            'required' 			 => false
        ),
		array(
            'name'      		 => esc_html__('YITH Woocommerce Compare', 'phami'),
            'slug'      		 => 'yith-woocommerce-compare',
            'required'			 => false
        ),		
		array(
            'name'     			 => esc_html__('WooCommerce Variation Swatches', 'phami'),
            'slug'      		 => 'variation-swatches-for-woocommerce',
            'required' 			 => false
        ),
    );
    $config = array();
    tgmpa( $plugins, $config );
}