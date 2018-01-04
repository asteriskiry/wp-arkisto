<?php
if ( !defined( 'ABSPATH' ) ) exit;

if ( !function_exists( 'chld_thm_cfg_parent_css' ) ):
    function chld_thm_cfg_parent_css() {
        wp_enqueue_style( 'chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array(  ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 10 );


/* Asettaa Asteriskin admin teeman oletusteemaksi */
function set_default_admin_color($user_id) {
$args = array(
            'ID' => $user_id,
                    'admin_color' => 'asteriski'
                        
                );  
    wp_update_user( $args  );

}
add_action('user_register', 'set_default_admin_color');
