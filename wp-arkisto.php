<?php
/**
 * Plugin Name: WP-Arkisto
 * Description: Työkalu dokumenttien hallintaan
 * Author: Maks Turtiainen
 * Version: 0.0.1
 * License: MIT
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function pk_register_post_type() {
    
    $singular = 'Pöytäkirja';
    $plural = 'Pöytäkirjat';
    $slug = 'poytakirjat';

    $labels = array(
        'name'                  => $plural,
        'singular_name'         => $singular,
        'add_name'              => 'Lisää uusi',
        'add_new_item'          => 'Lisää uusi ' . $singular,
        'edit'                  => 'Muokkaa',
        'edit_item'             => 'Muokkaa ' . $singular,
        'new_item'              => 'Uusi ' . $singular,
        'view'                  => 'Näytä ' . $singular,
        'view_item'             => 'Näytä ' . $singular,
        'search_term'           => 'Etsi ' . $plural,
        'parent'                => 'Vanhempi ' . $singular,
        'not_found'             => $plural . ' ei löydy',
        'not_found_in_trash'    => $plural . ' ei löydy roskakorista'
    );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable'    => true,
        'exclude_from_search'   => false,
        'show_in_nav_menus'     => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'show_in_admin_bar'     => true,
        'menu_position'         => 10,
        'menu_icon'             => 'dashicons-media-text',
        'can_export'            => true,
        'delete_with_user'      => false,
        'hierarchical'          => false,
        'has_archive'           => true,
        'query_var'             => true,
        'capability_type'       => 'post',
        'map_meta_cap'          => true,
        // 'capabilities'       => array(),
        'rewrite'               => array( 
            'slug'                  => $slug,
            'with_front'            => true,
            'pages'                 => true,
            'feeds'                 => false,
        ),
        'supports'              => array(
            'title',
            'editor',
            'custom-fields',
        )
    );

    register_post_type( $slug, $args );
}
add_action( 'init', 'pk_register_post_type' );

function pk_register_taxonomy() {

    $plural = 'Vuodet';
    $singular = 'Vuosi';

    $labels = array(
        'name'                       => $plural,
        'singular_name'              => $singular,
        'search_items'               => 'Search ' . $plural,
        'popular_items'              => 'Popular ' . $plural,
        'all_items'                  => 'All ' . $plural,
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => 'Edit ' . $singular,
        'update_item'                => 'Update ' . $singular,
        'add_new_item'               => 'Add New ' . $singular,
        'new_item_name'              => 'New ' . $singular . ' Name',
        'separate_items_with_commas' => 'Separate ' . $plural . ' with commas',
        'add_or_remove_items'        => 'Add or remove ' . $plural,
        'choose_from_most_used'      => 'Choose from the most used ' . $plural,
        'not_found'                  => 'No ' . $plural . ' found.',
        'menu_name'                  => $plural,
    );
    
    $args = array(
            'hierarchical'          => true,
            'labels'                => $labels,
            'show_ui'               => true,
            'show_admin_column'     => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var'             => true,
            'rewrite'               => array( 'slug' => $$slug ),
    ); 
    register_taxonomy( 'vuosi', 'poytakirjat', $args );
}
add_action('init', 'pk_register_taxonomy');

function pk_taxonomy_list( $atts, $content = null ) {

    $atts = shortcode_atts(
        array(

            'title' => 'Pöytäkirjat'
        ), $atts
    );
    $lista = get_terms('vuosi');

    $displaylist = '<div id="lista">';
    $displaylist .= '<h4>' . $atts['title']  . '</h4>';
    $displaylist .= '<ul>';

    foreach( $lista as $vuos ) {

        $displaylist .= '<li class="vuodet">';
        $displaylist .= '<a href="' . get_term_link( $vuos ) . '">';
        $displaylist .= $vuos->name . '</a></li>';
    }
    $displaylist .= '</ul></div>';

    return $displaylist;

}
add_shortcode( 'pk_list', "pk_taxonomy_list" );
