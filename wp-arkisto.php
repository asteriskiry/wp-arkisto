<?php
/**
 * Plugin Name: WP-Arkisto
 * Description: Työkalu dokumenttien hallintaan
 * Plugin URI: https://asteriski.fi
 * Author: Maks Turtiainen
 * Version: 0.0.2
 * Author URI: https://asteriski.fi
 * License: BSD
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once (plugin_dir_path(__FILE__) . 'wp-arkisto-poytakirjat.php' );
require_once (plugin_dir_path(__FILE__) . 'wp-arkisto-tentit.php' );
require_once (plugin_dir_path(__FILE__) . 'wp-arkisto-shortcodes.php' );

/* Tyylien ja javascriptin lataus */
function wpark_admin_enqueue_scripts() {
    global $pagenow, $typenow;

    if ( ( $pagenow == 'post.php' || $pagenow == 'post-new.php' ) && $typenow == 'poytakirjat' ) {
        wp_enqueue_style( 'wpark-admin-css', plugins_url( 'css/admin-poytakirjat.css', __FILE__ ) );
        wp_enqueue_script( 'wpark-admin-js', plugins_url( 'js/admin-poytakirjat.js', __FILE__ ), array( 'jquery', 'jquery-ui-datepicker' ), '20180104', true );
        wp_enqueue_style( 'jquery-style', plugins_url( 'assets/jquery-ui-theme-asteriski/jquery-ui.css', __FILE__ ) );
    }

}

add_action( 'admin_enqueue_scripts', 'wpark_admin_enqueue_scripts' );

function wpark_front_enqueue_scripts() {
    wp_enqueue_script( 'w3js', plugins_url( 'assets/w3.js', __FILE__ ),  true );
    wp_enqueue_style( 'wpark-front-css', plugins_url( 'css/front-poytakirjat.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'wpark_front_enqueue_scripts' );
?>
