<?php

/*
 * Return Elementor Version
 */
function nnfy_is_elementor_version( $operator = '<', $version = '2.6.0' ) {
    return defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, $version, $operator );
}

/*
 * Elementor Settings return value
 * return $elget_value
 */
if( !function_exists('nnfy_get_elementor_option') ){
    function nnfy_get_elementor_option( $key, $post_id ){
        // Get the page settings manager
        $page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );

        // Get the settings model for current post
        $page_settings_model = $page_settings_manager->get_model( $post_id );

        // Retrieve value
        $elget_value = $page_settings_model->get_settings( $key );
        return $elget_value;
    }
}

/**
 * Page option and Customizer value
 * return value
 */

if( !function_exists('nnfy_get_option') ){
    function nnfy_get_option( $key, $post_id, $default ){

        $page_value = nnfy_get_elementor_option( $key, $post_id );
        $customizer_value = get_option( $key, $default );

        if( !empty( $page_value ) && 'default' != $page_value ){
            
            if( $page_value === 'yes' ){
                return true;
            }else if( $page_value === 'no' ){
                return false;
            }else{
                return $page_value;
            }

        }else{
            return $customizer_value;
        }

    }
}


/*
 * Get Taxonomy
 * return array
 */
function nnfy_get_taxonomies( $htmega_texonomy = 'category' ){
    $terms = get_terms( array(
        'taxonomy' => $htmega_texonomy,
        'hide_empty' => true,
    ));
    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
        foreach ( $terms as $term ) {
            $options[ $term->slug ] = $term->name;
        }
        return $options;
    }
}

/**
 * Get Post List
 * return array
 */
function nnfy_post_name( $post_type = 'post' ){
    $options = array();
    $options['0'] = __('Select','99fy');
    $all_post = array( 'posts_per_page' => -1, 'post_type'=> $post_type );
    $post_terms = get_posts( $all_post );
    if ( ! empty( $post_terms ) && ! is_wp_error( $post_terms ) ){
        foreach ( $post_terms as $term ) {
            $options[ $term->ID ] = $term->post_title;
        }
        return $options;
    }
}

/*
 * Generate List Item From New nile text
 */
if( !function_exists('nnfy_generate_list') ){
    function nnfy_generate_list( $texts ){
        $texts = explode( "\n", $texts );
        if( count( $texts ) && !empty( $texts ) ){
            echo '<ul>';
                foreach( $texts as $text ) { echo '<li>'. $text .' </li>'; }
            echo '</ul>';
        }
    }
}