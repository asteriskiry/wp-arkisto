<?php

/** 
 * Pöytäkirjojen PDF-uploaderi 
 **/

namespace pk_uploader;

function register_metaboxes() {
    add_meta_box(
        'pk_uploader_metabox', 
        'Pöytäkirjan tiedosto', 
        __NAMESPACE__ . '\pk_uploader_callback',
        'poytakirjat',
        'side'
    );
}
add_action( 'add_meta_boxes', __NAMESPACE__ . '\register_metaboxes' );

function pk_uploader_callback( $post_id ) {
    wp_nonce_field( basename( __FILE__ ), 'custom_pk_nonce' ); 
    ?>

    <div id="metabox_wrapper">
        <img id="pk-tag"></img>
		<input type="hidden" id="pk-hidden" name="custom_pk_data">
		<input type="button" id="pk-upload-button" class="button" value="Lisää pöytäkirja">
		<input type="button" id="pk-delete-button" class="button" value="Poista pöytäkirja">
	</div>

	<?php
}

function save_custom_pk( $post_id ) {
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST[ 'custom_pk_nonce' ] ) && wp_verify_nonce( $_POST[ 'custom_pk_nonce' ], basename( __FILE__ ) ) );

	if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
		return;
	}
	if ( isset( $_POST[ 'custom_pk_data' ] ) ) {
		$pk_data = json_decode( stripslashes( $_POST[ 'custom_pk_data' ] ) );
		if ( is_object( $pk_data[0] ) ) {
			$pk_data = array( 'id' => intval( $pk_data[0]->id ), 'src' => esc_url_raw( $pk_data[0]->url
			) );
		} else {
			$pk_data = [];
		}
		update_post_meta( $post_id, 'custom_pk_data', $pk_data );
	}
}
add_action( 'save_post', __NAMESPACE__ . '\save_custom_pk' );
