<?php
    /*
    *
    *	Wpbingo Framework Menu Functions
    *	------------------------------------------------
    *	Wpbingo Framework v3.0
    * 	Copyright Wpbingo Ideas 2017 - http://wpbingosite.com/
    *
    *	phami_setup_menus()
    *
    */
    /* CUSTOM MENU SETUP
    ================================================== */
    register_nav_menus( array(
        'main_navigation' => esc_html__( 'Main Menu', 'phami' ),
		'vertical_menu'     => esc_html__( 'Vertical Menu', 'phami' ),
		'currency_menu'     => esc_html__( 'Currency Menu', 'phami' ),   
        'language_menu'     => esc_html__( 'Language Menu', 'phami' )
    ) );
?>