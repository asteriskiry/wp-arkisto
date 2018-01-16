<?php

/**
 * Tenttiarkisto
 **/

/* Custom post type "Tentit" rekisteröinti */

function wpark_t_register_post_type() {

    $singular = 'Tentti';
    $plural = 'Tentit';
    $slug = 'tentit';

    $labels = array(
        'name'                  => $plural,
        'singular_name'         => $singular,
        'add_name'              => 'Lisää uusi',
        'add_new_item'          => 'Lisää uusi ' . $singular,
        'edit'                  => 'Muokkaa',
        'edit_item'             => 'Muokkaa tenttiä',
        'new_item'              => 'Uusi ' . $singular,
        'view'                  => 'Näytä ' . $singular,
        'view_item'             => 'Näytä ' . $singular,
        'search_term'           => 'Etsi tenttiä',
        'parent'                => 'Vanhempi ' . $singular,
        'not_found'             => 'Tenttejä ei löytynyt',
        'not_found_in_trash'    => 'Tenttejä ei löytynyt roskakorista',
        'menu_name'             => 'Tenttiarkisto'
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
        'menu_icon'             => 'dashicons-welcome-learn-more',
        'can_export'            => true,
        'delete_with_user'      => false,
        'hierarchical'          => false,
        'has_archive'           => true,
        'query_var'             => true,
        'capability_type'       => 'post',
        'map_meta_cap'          => true,
        // 'capabilities'       => array(),
        // 'taxonomies'            => array( 'kurssi', ),
        'rewrite'               => array( 
            'slug'                  => $slug,
            'with_front'            => true,
            'pages'                 => true,
            'feeds'                 => false,
        ),
        'supports'              => array(
            'title',
            'comments',
            // 'editor',
            // 'custom-fields',
        )
    );

    register_post_type( $slug, $args );
}
add_action( 'init', 'wpark_t_register_post_type' );
