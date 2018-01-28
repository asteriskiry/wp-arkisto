<?php 

/**
 * Template Name: Pöytäkirjat-single
 **/
?>

<?php get_header(); ?>

<?php
/* travelify_before_main_container hook */
do_action( 'travelify_before_main_container' );
?>

<div class="tentit-single">
<script>
jQuery(function ($)  {

            $(window).load(function() {

                $('#loadOverlay').fadeOut('slow');

            })

        })
</script>
<?php

/* Loop joka hakee tiedot */

if ( have_posts() ) : while ( have_posts() ) : the_post();
    global $post;

    /* Tallennetaan tiedot muuttujiin kannasta */

    $custom_pdf_data = get_post_meta($post->ID, 'custom_pdf_data');
    $thumbnail = $custom_pdf_data[0]['tnBig'];
    $pdfurl = $custom_pdf_data[0]['src'];
    $slug = get_permalink();
    $pm = get_post_meta( $post->ID, 't_paivamaara', true );    
    $kurssi = get_the_terms( $post->ID, 'kurssi' );
    $post_type = get_post_type();
    if ( $post_type )
    {
        $post_type_data = get_post_type_object( $post_type );
        $post_type_slug = $post_type_data->rewrite['slug'];
    }

    /* Generoidaan HTML */

    echo '<div class="t-grid">';
    echo '<div class="t-thumb">';
    echo '<div class="btn26">';
    echo '<img src="' . $thumbnail . '"><div class="ovrly"></div><div class="anim-buttons"><a class="fa fa-file-pdf-o" href="' . $pdfurl . '"></a></div>';
    echo '</div>';
    echo '</div>';
    echo '<div class="t-single-meta">';
    echo '<div class="t-buttons-left">';
    echo previous_post_link('%link', '<i class="fa fa-angle-double-left"></i> Edellinen');
    echo '</div>';
    echo '<div class="t-buttons-right">';
    echo next_post_link('%link', 'Seuraava <i class="fa fa-angle-double-right"></i>');
    echo '</div>';
    echo '<br>';
    echo '<div class="t-single-meta-content">';
    echo '<table>';
    echo '<tr>';
    echo '<td><strong>Kurssi</strong></td><td>' . $kurssi[0]->name . '</td>';
    echo '</tr><tr>';
    echo '<td><strong>Päivämäärä</strong></td><td>' . $pm . '</td>';
    echo '</tr>';
    echo '</table>';
    echo '<a class="hvr-grow"href="' . $pdfurl . '">PDF-tiedosto <i class="fa fa-file-pdf-o"></i></a>';
    echo '</div>';
    echo '<div class="t-buttons">';
    echo '<a href="' . get_site_url() . '/' . $post_type_slug . '">Takaisin selailuun</a>'; 
    echo '</div>';
    echo '</div>';
    echo '</div>';
endwhile; endif; ?>
</div>

<?php
/* travelify_after_main_container hook */
do_action( 'travelify_after_main_container' );
?>

<?php get_footer(); ?>