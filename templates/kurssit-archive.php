<?php 

/**
 * Template Name: Pöytäkirjat-archive
 **/
?>

<?php get_header(); ?>

<?php
/* travelify_before_main_container hook */
do_action( 'travelify_before_main_container' );

echo 'Tämä on kurssit-archive';

/* travelify_after_main_container hook */
do_action( 'travelify_after_main_container' );
?>

<?php get_footer(); ?>
