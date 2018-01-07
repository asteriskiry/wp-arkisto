<?php 

/**
 * Template Name: Pöytäkirjat-single
 **/
?>

<?php get_header(); ?>

<?php
	/**
	 * travelify_before_main_container hook
	 */
	do_action( 'travelify_before_main_container' );
?>

<div class="pk-single">
<ul>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post();    

 $args = array(
   'post_type' => 'attachment',
   'numberposts' => -1,
   'post_status' => null,
   'post_parent' => $post->ID
  );

    $attachments = get_posts( $args );
    if ( $attachments ) {
        foreach ( $attachments as $attachment ) {
            echo '<li>';
            echo '<div class="pk-thumb">';
            the_attachment_link( $attachment->ID, true );
            echo '<div class="pk-single-hidden">klikkaa</div>';
            echo '</div>';
            echo '<div class="pk-single-meta">';
            echo '<p>';
            echo apply_filters( 'the_title', $attachment->post_title );
            echo previous_post_link();
            echo next_post_link();
            echo '</p></div></li>';
        }
    }

 endwhile; endif; ?>
</ul>
</div>

<?php

   /**
    * travelify_after_main_container hook
    */
	do_action( 'travelify_after_main_container' );
?>

<?php get_footer(); ?>
