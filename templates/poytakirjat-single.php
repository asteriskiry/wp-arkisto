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

    global $post;
 $args = array(
   'post_type' => 'attachment',
 //  'numberposts' => -1,
 //  'post_status' => null,
 //  'post_parent' => $post->ID
  );

    $attachments = get_posts( $args );
            var_dump($attachments);
    if ( $attachments ) {
        foreach ( $attachments as $attachment ) {
            echo '<li>';
            echo '<div class="pk-grid">';
            echo '<div class="pk-thumb">';
            the_attachment_link( $attachment->ID, true );
            echo '</div>';
            echo '<div class="pk-single-meta">';
            echo '<div class="pk-buttons-left">';
            echo previous_post_link('%link', 'Edellinen pöytäkirja');
            echo '</div>';
            echo '<div class="pk-buttons-right">';
            echo next_post_link('%link', 'Seuraava pöytäkirja');
            echo '</div>';
            echo '<br>';
            echo apply_filters( 'the_title', $attachment->post_title );
            echo '</div></li>';
            echo '</div>';
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
