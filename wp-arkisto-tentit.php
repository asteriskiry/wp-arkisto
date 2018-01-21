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

/* Custom taxonomyn "Kurssit" rekisteröinti tenteille */

function wpark_t_register_taxonomy_kurssi() {

    $plural = 'Kurssit';
    $singular = 'Kurssi';
    $slug = 'kurssi';

    $labels = array(
        'name'                       => $singular,
        'singular_name'              => $singular,
        'search_items'               => 'Etsi kurssia',
        'popular_items'              => 'Suositut kurssit',
        'all_items'                  => 'Kaikki kurssit',
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => 'Muokkaa kurssia',
        'update_item'                => 'Päivitä ' . $singular,
        'add_new_item'               => 'Lisää uusi ' . $singular,
        'new_item_name'              => 'Nimeä ' . $singular,
        'separate_items_with_commas' => 'Erottele ' . $plural . ' pilkuilla',
        'add_or_remove_items'        => 'Lisää tai poista kursseja',
        'choose_from_most_used'      => 'Valitse suosituimmista kursseista',
        'not_found'                  => 'Kursseja ei löytynyt',
        'menu_name'                  => $plural,
    );

    $args = array(
        'hierarchical'          => true,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'kurssi' ),
        'meta_box_cb'           => 'wpark_t_taxonomy_meta_box',
    ); 
    register_taxonomy( 'kurssi', 'tentit', $args );
}
add_action('init', 'wpark_t_register_taxonomy_kurssi');

/* Lisäyssivun taxonomioiden meta boxit */

function wpark_t_taxonomy_meta_box($post, $meta_box_properties) {
    $taxonomy = $meta_box_properties['args']['taxonomy'];
    $tax = get_taxonomy($taxonomy);
    $terms = get_terms($taxonomy, array('hide_empty' => 0));
    $name = 'tax_input[' . $taxonomy . ']';
    $postterms = get_the_terms( $post->ID, $taxonomy );
    $current = ($postterms ? array_pop($postterms) : false);
    $current = ($current ? $current->term_id : 0);
?>

<div id="taxonomy-<?php echo $taxonomy; ?>" class="categorydiv">
  <ul id="<?php echo $taxonomy; ?>-tabs" class="category-tabs">
    <li class="tabs"><a href="#<?php echo $taxonomy; ?>-all"><?php echo $tax->labels->all_items; ?></a></li>
  </ul>

  <div id="<?php echo $taxonomy; ?>-all" class="tabs-panel">
    <input name="tax_input[<?php echo $taxonomy; ?>][]" value="0" type="hidden">            
    <ul id="<?php echo $taxonomy; ?>checklist" data-wp-lists="list:symbol" class="categorychecklist form-no-clear">
<?php   foreach($terms as $term){
$id = $taxonomy.'-'.$term->term_id;?>
      <li id="<?php echo $id?>"><label class="selectit"><input required value="<?php echo $term->term_id; ?>" name="tax_input[<?php echo $taxonomy; ?>][]" id="in-<?php echo $id; ?>"<?php if( $current === (int)$term->term_id ){?>checked="checked"<?php } ?> type="radio"> <?php echo $term->name; ?></label></li>
<?php   }?>
    </ul>
  </div>
</div>
<?php
}

/* Tenttien lisäyssivun meta box (pvm, helppi) */

function wpark_pk_add_metabox() {

    add_meta_box(
        'wpark_pk_meta',
        'Pöytäkirjan tiedot',
        'wpark_pk_callback',
        'poytakirjat',
        'normal',
        'high'
    );

    add_meta_box(
        'wpark_pk_help',
        'Tiedote',
        'wpark_pk_help_callback',
        'poytakirjat',
        'normal',
        'high'
    );
} 

add_action('add_meta_boxes', 'wpark_pk_add_metabox');
