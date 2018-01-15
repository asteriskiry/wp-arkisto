<?php

/* WP-arkiston shortcodet jos sellaisia joskus tarvitaan, alla esimerkki */

function pk_taxonomy_list( $atts, $content = null ) {

    $atts = shortcode_atts(
        array(

            'title' => 'Pöytäkirjat'
        ), $atts
    );
    $lista = get_terms('vuosi');

    $displaylist = '<div id="lista">';
    $displaylist .= '<h4>' . $atts['title']  . '</h4>';
    $displaylist .= '<ul>';

    foreach( $lista as $vuos ) {

        $displaylist .= '<li class="vuodet">';
        $displaylist .= '<a href="' . get_term_link( $vuos ) . '">';
        $displaylist .= $vuos->name . '</a></li>';
    }
    $displaylist .= '</ul></div>';

    return $displaylist;

}
add_shortcode( 'pk_list', "pk_taxonomy_list" );

?>
