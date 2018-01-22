<?php 

/**
 * Template Name: Tentit-archive
 **/
?>

<?php get_header(); ?>

<?php
/* travelify_before_main_container hook */
do_action( 'travelify_before_main_container' );
?>

<div id="tentit-archive">
    <h1> Tentit archive </h1>

<div id="tentit-content">
<?php

$args = array( 'hide_empty=0' );
 
$terms = get_terms( 'kurssi', $args );
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
    $count = count( $terms );
    $i = 0;
    $term_list = '<p class="my_term-archive">';
    foreach ( $terms as $term ) {
        $i++;
        $term_list .= '<a href="' . esc_url( get_term_link( $term ) ) . '" alt="' . esc_attr( sprintf( __( 'View all post filed under %s', 'my_localization_domain' ), $term->name ) ) . '">' . $term->name . '</a>';
        if ( $count != $i ) {
            $term_list .= ' &middot; ';
        }
        else {
            $term_list .= '</p>';
        }
    }
    echo $term_list;
}
?>
</div>
</div>
<?php
/* travelify_after_main_container hook */
do_action( 'travelify_after_main_container' );
?>

<?php get_footer(); ?>
