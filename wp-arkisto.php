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


?>
