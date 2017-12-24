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

/* Adminpaneelin logon korvaus */
function htx_custom_logo() {
echo '
<style type="text/css">
#wpadminbar #wp-admin-bar-wp-logo > .ab-item .ab-icon:before { 
background-image: url(' . get_bloginfo('stylesheet_directory') . '/pieni-vari20.png)  !important; 
color: transparent;
}
#wpadminbar #wp-admin-bar-wp-logo.hover > .ab-item .ab-icon {
background-position: 0 0;
}   
 </style>
';
}

add_action('wp_before_admin_bar_render', 'htx_custom_logo');
?>
