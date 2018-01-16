<?php

/**
 * Plugin Name: WP-Arkisto
 * Description: Työkalu dokumenttien hallintaan. Pöytäkirja- ja tenttiarkisto.
 * Plugin URI: https://asteriski.fi
 * Author: Asteriski www-toimikunta, Maks Turtiainen
 * Version: 1.0
 * Author URI: https://asteriski.fi
 * License: BSD
 **/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once (plugin_dir_path(__FILE__) . 'wp-arkisto-poytakirjat.php' );
require_once (plugin_dir_path(__FILE__) . 'wp-arkisto-tentit.php' );
require_once (plugin_dir_path(__FILE__) . 'wp-arkisto-shortcodes.php' );
require_once (plugin_dir_path(__FILE__) . 'wp-arkisto-poytakirjat-uploader.php' );

/* Tyylien ja javascriptin lataus admin-sivuille */

function wpark_admin_enqueue_scripts() {
    global $pagenow, $typenow;

    if ( ( $pagenow == 'post.php' || $pagenow == 'post-new.php' ) && $typenow == 'poytakirjat' ) {
        wp_enqueue_media(); 
        wp_enqueue_style( 'wpark-admin-css', plugins_url( 'css/admin-poytakirjat.css', __FILE__ ) );
        wp_enqueue_script( 'wpark-admin-js', plugins_url( 'js/admin-poytakirjat.js', __FILE__ ), array( 'jquery', 'jquery-ui-datepicker', 'media-upload' ), true );
        wp_enqueue_style( 'jquery-style', plugins_url( 'assets/jquery-ui-theme-asteriski/jquery-ui.css', __FILE__ ) );
        wp_enqueue_script( 'wpark_pdf_uploader', plugin_dir_url( __FILE__  ) . 'js/admin-poytakirjat-uploader.js', array('jquery', 'media-upload'), '0.0.2', true  );
        wp_localize_script( 'wpark_pdf_uploader', 'pdfUploads', array( 'pdfdata' => get_post_meta( get_the_ID(), 'custom_pdf_data', true  )  )  );
    }
}

add_action( 'admin_enqueue_scripts', 'wpark_admin_enqueue_scripts' );

/* Tyylien ja javascriptin lataus fronttiin */

function wpark_front_enqueue_scripts() {

    wp_enqueue_style( 'wpark-front-css', plugins_url( 'css/front-poytakirjat.css', __FILE__ ) );
    wp_enqueue_style( 'hover-master-css', plugins_url( 'assets/hover.css', __FILE__ ) );
    wp_enqueue_style( 'buttons-css', plugins_url( 'assets/buttons.css', __FILE__ ) );
    wp_enqueue_script( 'w3js', plugins_url( 'assets/w3.js', __FILE__ ),  true );
    wp_enqueue_script( 'font-awesome', plugins_url( 'assets/fontawesome-all.js', __FILE__ ),  true );
}
add_action( 'wp_enqueue_scripts', 'wpark_front_enqueue_scripts' );

/* Dashboard-widgetti */

function wpark_dashboard () {
    wp_add_dashboard_widget( 'wpark_dashboard_welcome', 'Hei', 'wpark_add_dashboard_widget' );
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
        echo '</ul>';
}
 
add_action( 'wp_dashboard_setup', 'wpark_dashboard' );
