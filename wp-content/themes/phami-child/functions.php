<?php

add_action('wp_enqueue_scripts', 'phami_child_css', 1001);
 
// Load CSS
function phami_child_css() {
    wp_deregister_style( 'styles-child' );
    wp_register_style( 'styles-child', get_stylesheet_directory_uri() . '/style.css' );
    wp_enqueue_style( 'styles-child' );
}
