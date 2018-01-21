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

<div class="pk-single">
<script>
jQuery(function ($)  {

            $(window).load(function() {

                $('#loadOverlay').fadeOut('slow');

            })

        })
</script>
<link rel='stylesheet'   href='https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css' type='text/css' media='all' />
<?php

/* Loop joka hakee tiedot */

if ( have_posts() ) : while ( have_posts() ) : the_post();
    global $post;

    /* Tallennetaan tiedot muuttujiin kannasta */

    $custom_pdf_data = get_post_meta($post->ID, 'custom_pdf_data');
    $thumbnail = $custom_pdf_data[0]['tnBig'];
    $pdfurl = $custom_pdf_data[0]['src'];
    $slug = get_permalink();
    $pm = get_post_meta( $post->ID, 'pk_paivamaara', true );    
    $jn = get_post_meta( $post->ID, 'pk_numero', true );
    $tyyppi = get_the_terms( $post->ID, 'tyyppi' );

    /* Generoidaan HTML */
    echo '<div class="pk-grid">';
    echo '<div class="pk-thumb">';
    echo '<div class="btn26">';
    echo '<img src="' . $thumbnail . '"><div class="ovrly"></div><div class="anim-buttons"><a class="fa fa-file-pdf-o" href="' . $pdfurl . '"></a></div>';
    echo '</div>';
    echo '</div>';
    echo '<div class="pk-single-meta">';
    echo '<div class="pk-buttons-left">';
    echo previous_post_link('%link', '<i class="fa fa-angle-double-left"></i> Edellinen');
    echo '</div>';
    echo '<div class="pk-buttons-right">';
    echo next_post_link('%link', 'Seuraava <i class="fa fa-angle-double-right"></i>');
    echo '</div>';
    echo '<br>';
    echo '<div class="pk-single-meta-content">';
    echo '<table>';
    echo '<tr>';
    echo '<td><strong>Nimi</strong></td><td>' . apply_filters( 'the_title', $post->post_title ) . '</td>';
    echo '</tr><tr>';
    echo '<td><strong>Tyyppi</strong></td><td>' .  $tyyppi[0]->name . '</td>';
    echo '</tr><tr>';
    echo '<td><strong>Päivämäärä</strong></td><td>' . $pm . '</td>';
    echo '</tr><tr>';
    echo '<td><strong>Järjestysnumero</strong></td><td>' . $jn . '</td>';
    echo '</tr>';
    echo '</table>';
    echo '<a class="hvr-grow"href="' . $pdfurl . '">PDF-tiedosto <i class="fa fa-file-pdf-o"></i></a>';
    echo '</div>';
    echo '<div class="pk-buttons">';
    echo '<a href="' . get_site_url() . '/' . get_post_type($post->ID) . '">Takaisin selailuun</a>'; 
    echo '</div>';
    echo '</div>';

    /* Kommenttiosio */
    comments_template();

    echo '</div>';
endwhile; endif; ?>
</div>

<?php
/* travelify_after_main_container hook */
do_action( 'travelify_after_main_container' );
?>

<?php get_footer(); ?>
