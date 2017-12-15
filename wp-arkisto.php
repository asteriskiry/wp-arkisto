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

require_once (plugin_dir_path(__FILE__) . 'wp-arkisto-poytakirjat.php' );
require_once (plugin_dir_path(__FILE__) . 'wp-arkisto-tentit.php' );
require_once (plugin_dir_path(__FILE__) . 'wp-arkisto-shortcodes.php' );

?>
