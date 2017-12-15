<?php

/* Pöytäkirjojen admin-puoli */

/* Custom post type "Pöytäkirjat" rekisteröinti */
function wpark_pk_register_post_type() {
    
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
           // 'editor',
           // 'custom-fields',
        )
    );

    register_post_type( $slug, $args );
}
add_action( 'init', 'wpark_pk_register_post_type' );


/* Custom taxonomyn "Vuodet" rekisteröinti pöyräkirjoille */
function wpark_pk_register_taxonomy() {

    $plural = 'Vuodet';
    $singular = 'Vuosi';
    $slug = 'vuosi';

    $labels = array(
        'name'                       => $plural,
        'singular_name'              => $singular,
        'search_items'               => 'Etsi ' . $plural,
        'popular_items'              => 'Suositus ' . $plural,
        'all_items'                  => 'kaikki ' . $plural,
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => 'Muokkaa ' . $singular,
        'update_item'                => 'Päivitä ' . $singular,
        'add_new_item'               => 'Lisää uusi ' . $singular,
        'new_item_name'              => 'Uusi ' . $singular . ' Name',
        'separate_items_with_commas' => 'Erottele ' . $plural . ' with commas',
        'add_or_remove_items'        => 'Lisää tai poista ' . $plural,
        'choose_from_most_used'      => 'Valitse suosituimmista ' . $plural,
        'not_found'                  => 'Vuotta ei löytynyt.',
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
add_action('init', 'wpark_pk_register_taxonomy');

/* Pöytäkirjojen lisäyssivun metaboxi */

function wpark_pk_add_metabox() {

    add_meta_box(
        'wpark_pk_meta',
        'Pöytäkirjan tiedot',
        'wpark_pk_callback',
        'poytakirjat',
        'normal',
        'high'
    );
} 

add_action('add_meta_boxes', 'wpark_pk_add_metabox');


/* Lisäyssivun html:n generointi */
function wpark_pk_callback() {
?>

<div class="meta-row">
    <div class="meta-th">
        <label for="pk-tyyppi" class="pk-row-title">Tyyppi (hallitus/yhdistys/toimikunta)</label>
    </div>
    <div class="meta-td">
        <input type="text" name="pk-tyyppi" id="pk-tyyppi" value=""/>
    </div>
</div>

<div class="meta-row">
    <div class="meta-th">
        <label for="pk-numero" class="pk-row-title">Järjestysnumero</label>
    </div>
    <div class="meta-td">
        <input type="text" name="pk-numero" id="pk-numero" value=""/>
    </div>
</div>

<div class="meta-row">
    <div class="meta-th">
        <label for="pk-paivamaara" class="pk-row-title">Päivämäärä</label>
    </div>
    <div class="meta-td">
        <input type="text" name="pk-paivamaara" id="pk-paivamaara" value=""/>
    </div>
</div>
<div class="meta">
    <div class="meta-th">
        <span>Lisää pöytäkirja "Lisää media" -näppäimestä.</span>
    </div>
</div>

<div class="meta-editor"></div>
    <?php
    $content = get_post_meta( $post->ID, 'poytakirja', true  );
    $editor = 'poytakirja';
    $settings = array(
        'textarea_rows' => 8,
        'media_buttons' => true,
    );
    wp_editor( $content, $editor, $settings );
    ?>
</div>

<?php
}

?>
