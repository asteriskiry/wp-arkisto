<?php

/**
 * Plugin Name: WP-Arkisto
 * Description: Työkalu dokumenttien hallintaan. Pöytäkirja- ja tenttiarkisto.
 * Plugin URI: https://asteriski.fi
 * Author: Maks Turtiainen
 * Version: 1.2
 * Author URI: https://asteriski.fi
 * License: BSD
 **/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once (plugin_dir_path(__FILE__) . 'wp-arkisto-poytakirjat.php' );
require_once (plugin_dir_path(__FILE__) . 'wp-arkisto-tentit.php' );
require_once (plugin_dir_path(__FILE__) . 'wp-arkisto-enqueue.php' );
require_once (plugin_dir_path(__FILE__) . 'wp-arkisto-shortcodes.php' );
require_once (plugin_dir_path(__FILE__) . 'wp-arkisto-poytakirjat-uploader.php' );
require_once (plugin_dir_path(__FILE__) . 'wp-arkisto-tentit-uploader.php' );

/* Dashboard-widgetti */

function wpark_dashboard () {
    add_meta_box( 'wpark_dashboard_welcome', 'Hei', 'wpark_add_dashboard_widget', 'dashboard', 'normal', 'high' );
}
function wpark_add_dashboard_widget () {
?>
    <div class="wpark-dashboard">
        <h1>Tervetuloa</h1>
        <h3>Haluatko:</h3>
        <ul>
<?php   
    echo '<li><a href="' . admin_url( 'edit.php?post_type=poytakirjat' ) . '">Lisätä pöytäkirjan</a></li>';
    echo '<li><a href="' . admin_url( 'edit.php?post_type=tentit' ) . '">Lisätä tentin tenttiarkistoon</a></li>'; 
    echo '<h3>Vahvistusta odottavat tentit:</h3>';
    echo '</ul>';
    echo '</div>';
}

add_action( 'wp_dashboard_setup', 'wpark_dashboard' );

/* Luodaan sivut fronttiin */

function wpark_add_pages () {
    $pk_query = new WP_Query('pagename=poytakirjat');	
    if(empty($pk_query->posts) && empty($pk_query->queried_object) && get_option('poytakirjat-created') == false) {
        $poytakirjat_page = array(
            'post_title' => 'Pöytäkirjat',
            'post_name' => 'poytakirjat',
            'post_status' => 'publish',
            'post_author' => 1,
            'post_type' => 'page',
            'comment_status' => 'closed'
        );
        $poytakirjat_post_id = wp_insert_post( $poytakirjat_page );
        update_option('poytakirjat-created', true);
    }
    $t_query = new WP_Query('pagename=tentit');	
    if(empty($t_query->posts) && empty($t_query->queried_object) && get_option('tentit-created') == false) {
        $tentit_page = array(
            'post_title' => 'Tenttiarkisto',
            'post_name' => 'tenttiarkisto',
            'post_status' => 'publish',
            'post_author' => 1,
            'post_type' => 'page',
            'comment_status' => 'closed'
        );
        $tentit_post_id = wp_insert_post( $tentit_page );
        update_option('tentit-created', true);
    }
}

add_action( 'admin_init', 'wpark_add_pages'  );

/* Poistetaan listauksesta quick edit */

function wpark_remove_quick_edit( $actions  ) {
    global $typenow;
    if ($typenow == 'poytakirjat' || $typenow == 'tentit') {
        unset($actions['inline hide-if-no-js']);
        return $actions;
    } else {
        return $actions;
    }
}

add_filter('post_row_actions','wpark_remove_quick_edit',10,1);
