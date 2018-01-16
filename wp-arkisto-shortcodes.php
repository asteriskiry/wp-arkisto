<?php

/* WP-arkiston shortcodet jos sellaisia joskus tarvitaan, alla esimerkki */
/* Shortcode [pk_listaa_vuodet] listaa kaikki "Vuodet" taxonomyn termit */

function pk_taxonomy_list( $atts, $content = null ) {

    $atts = shortcode_atts(
        array(

            'title' => 'Pöytäkirjojen vuodet'
        ), $atts
    );
    $lista = get_terms('vuosi');

    $vuosilista = '<div id="lista">';
    $vuosilista .= '<h4>' . $atts['title']  . '</h4>';
    $vuosilista .= '<ul>';

    foreach( $lista as $vuos ) {

        $vuosilista .= '<li class="vuodet">';
        $vuosilista .= '<a href="' . get_term_link( $vuos ) . '">';
        $vuosilista .= $vuos->name . '</a></li>';
    }
    $vuosilista .= '</ul></div>';

    return $vuosilista;

}
add_shortcode( 'pk_listaa_vuodet', "pk_taxonomy_list" );

?>
