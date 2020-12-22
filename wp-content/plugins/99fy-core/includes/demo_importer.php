<?php

add_action( 'admin_head', 'nnfy_remove_ocdi_notice' );
function nnfy_remove_ocdi_notice(){
  ?>
  <style type="text/css">
    .ocdi .notice-info{
      display: none !important;
    }
    .ocdi__gl-item[data-name="comingsoon"]{
      display: none !important;
    }
  </style>
  <?php
}

function nnfy_import_files() {

  return array(

    array(
      'import_file_name'             => 'Standard Demo',
      'local_import_file'            => NNFY_PL_PATH . 'includes/demo-content/99fy.xml',
      'local_import_widget_file'     => NNFY_PL_PATH . 'includes/demo-content/99fy.wie',
      'local_import_customizer_file' => NNFY_PL_PATH . 'includes/demo-content/99fy.dat',
      'import_preview_image_url'     => get_stylesheet_directory_uri().'/screenshot.png',
    ),

    array(
      'import_file_name'           => 'ComingSoon',
      'local_import_file'            => NNFY_PL_PATH . 'includes/demo-content/99fy.xml',
      'local_import_widget_file'     => NNFY_PL_PATH . 'includes/demo-content/99fy.wie',
      'local_import_customizer_file' => NNFY_PL_PATH . 'includes/demo-content/99fy.dat',
      'import_preview_image_url'     => get_stylesheet_directory_uri().'/screenshot.png',
    )

  );

}
add_filter( 'pt-ocdi/import_files', 'nnfy_import_files' );

function nnfy_after_import_setup() {

    // Assign menus to their locations.
    $header_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
    set_theme_mod( 'nav_menu_locations' , array( 
        'primary' => $header_menu->term_id,
      )
    );

    // Set home page
    $front_page_id = get_page_by_title( 'Home' );
    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );

    // Set blog page
    $blog_page_id  = get_page_by_title( 'Blog' );
    update_option( 'page_for_posts', $blog_page_id->ID );

    // Set shop page
    $shop_page_id = get_page_by_title('shop');
    $shop_page_id = $shop_page_id ? $shop_page_id->ID : get_option( 'woocommerce_shop_page_id');
    update_option( 'woocommerce_shop_page_id', $shop_page_id);

    // Set cart page
    $cart_page_id = get_page_by_title('cart');
    $cart_page_id = $cart_page_id ? $cart_page_id->ID : get_option( 'woocommerce_cart_page_id');
    update_option( 'woocommerce_cart_page_id', $cart_page_id);

    // Set checkout page
    $checkout_page_id = get_page_by_title('checkout');
    $checkout_page_id = $checkout_page_id ? $checkout_page_id->ID : get_option( 'woocommerce_checkout_page_id');
    update_option( 'woocommerce_checkout_page_id', $checkout_page_id);

    // Set myaccount page
    $account_page_id = get_page_by_title('my account ');
    $account_page_id = $account_page_id ? $account_page_id->ID : get_option( 'woocommerce_myaccount_page_id');
    update_option( 'woocommerce_myaccount_page_id', $account_page_id);

    // Set wishlist page
    $wishlist_page_id = get_page_by_title('wishlist');
    $wishlist_page_id = $wishlist_page_id ? $wishlist_page_id->ID : get_option( 'yith_wcwl_wishlist_page_id');
    update_option( 'yith_wcwl_wishlist_page_id', $wishlist_page_id);
    
    flush_rewrite_rules();
}

add_action( 'pt-ocdi/after_import', 'nnfy_after_import_setup' );