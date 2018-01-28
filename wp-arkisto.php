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
require_once (plugin_dir_path(__FILE__) . 'wp-arkisto-tentit-uploader.php' );

/* Tyylien ja javascriptin lataus adminiin */

function wpark_admin_enqueue_scripts() {
    global $pagenow, $typenow;

    /* Pöytäkirjoille */

    if ( ( $pagenow == 'post.php' || $pagenow == 'post-new.php' ) && $typenow == 'poytakirjat' ) {
        wp_enqueue_media(); 
        wp_enqueue_style( 'wpark-admin-css', plugins_url( 'css/admin-poytakirjat.css', __FILE__ ) );
        wp_enqueue_script( 'wpark-admin-js', plugins_url( 'js/admin-poytakirjat.js', __FILE__ ), array( 'jquery', 'jquery-ui-datepicker', 'media-upload' ), true );
        wp_enqueue_style( 'jquery-style', plugins_url( 'assets/jquery-ui-theme-asteriski/jquery-ui.css', __FILE__ ) );
        wp_enqueue_script( 'wpark_pdf_uploader', plugin_dir_url( __FILE__  ) . 'js/admin-poytakirjat-uploader.js', array('jquery', 'media-upload'), '0.0.2', true  );
        wp_localize_script( 'wpark_pdf_uploader', 'pdfUploads', array( 'pdfdata' => get_post_meta( get_the_ID(), 'custom_pdf_data', true  )  )  );
    }

    if ( get_current_screen() ->taxonomy === "vuosi" || get_current_screen() ->taxonomy === "tyyppi" ) {
        wp_enqueue_style( 'wpark-admin-css', plugins_url( 'css/admin-poytakirjat.css', __FILE__ ) );
    }

    /* Tenttiarkistolle */

    if ( ( $pagenow == 'post.php' || $pagenow == 'post-new.php' ) && $typenow == 'tentit' ) {
        wp_enqueue_media(); 
        wp_enqueue_style( 'wpark-t-admin-css', plugins_url( 'css/admin-tentit.css', __FILE__ ) );
        wp_enqueue_script( 'wpark-t-admin-js', plugins_url( 'js/admin-tentit.js', __FILE__ ), array( 'jquery', 'jquery-ui-datepicker', 'media-upload' ), true );
        wp_enqueue_style( 'jquery-style', plugins_url( 'assets/jquery-ui-theme-asteriski/jquery-ui.css', __FILE__ ) );
        wp_enqueue_script( 'wpark-t-pdf-uploader', plugin_dir_url( __FILE__  ) . 'js/admin-tentit-uploader.js', array('jquery', 'media-upload'), '0.0.2', true  );
        wp_localize_script( 'wpark-t-pdf-uploader', 'pdfUploads', array( 'pdfdata' => get_post_meta( get_the_ID(), 'custom_pdf_data', true  )  )  );
    }

    if ( get_current_screen() ->taxonomy === "kurssi" ) {
        wp_enqueue_style( 'wpark-t-admin-css', plugins_url( 'css/admin-tentit.css', __FILE__ ) );
    }
}

add_action( 'admin_enqueue_scripts', 'wpark_admin_enqueue_scripts' );

/* Tyylien ja javascriptin lataus fronttiin */

function wpark_front_enqueue_scripts() {

    /* Yhteiset */

    wp_enqueue_style( 'hover-master-css', plugins_url( 'assets/hover.css', __FILE__ ) );
    wp_enqueue_style( 'animatism-css', plugins_url( 'assets/animatism.css', __FILE__ ) );
    wp_enqueue_style( 'buttons-css', plugins_url( 'assets/buttons.css', __FILE__ ) );
    wp_enqueue_style( 'datatables-css', plugins_url( 'assets/datatables.min.css', __FILE__ ) );
//    wp_enqueue_script( 'w3js', plugins_url( 'assets/w3.js', __FILE__ ),  true );
    wp_enqueue_script( 'datatables-js', plugins_url( 'assets/datatables.min.js', __FILE__ ), array( 'jquery' ), true );

    /* Pöytäkirjoille */

    if ( get_query_var( 'post_type' ) == 'poytakirjat' ) {

        wp_enqueue_script( 'wpark-front-js', plugins_url( 'js/front-poytakirjat.js', __FILE__ ),  true );
        wp_enqueue_style( 'wpark-front-css', plugins_url( 'css/front-poytakirjat.css', __FILE__ ) );
    }
    
    if ( get_query_var( 'post_type' ) == 'poytakirjat' || is_singular( 'tentit' )  ) {

        wp_enqueue_style( 'font-awesome-legacy', '//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css'  );

    } else {
        // Tämä myös tenteille
        wp_enqueue_script( 'font-awesome', plugins_url( 'assets/fontawesome-all.js', __FILE__ ),  true );    
    }

    /* Tenttiarkistolle */

    if ( get_query_var( 'post_type' ) == 'tentit' ) {

        wp_enqueue_script( 'wpark-t-front-js', plugins_url( 'js/front-tentit.js', __FILE__ ),  true );
        wp_enqueue_style( 'wpark-t-front-css', plugins_url( 'css/front-tentit.css', __FILE__ ) );
    }

    if ( get_query_var( 'taxonomy' ) == 'kurssi' ) {

        wp_enqueue_style( 'wpark-t-front-css', plugins_url( 'css/front-tentit.css', __FILE__ ) );
        wp_enqueue_script( 'wpark-t-front-js', plugins_url( 'js/front-tentit.js', __FILE__ ),  true );
        wp_enqueue_script( 'wpark-t-kurssit-js', plugins_url( 'js/kurssit-archive.js', __FILE__ ),  true );
    }

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
