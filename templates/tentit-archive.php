<?php 

/**
 * Template Name: Tentit-archive
 **/

get_header();
?>

<div id="tentit-archive">
    <h1 class="customtitle">Tenttiarkisto</h1>

<?php
$args = array( 'hide_empty=0' );
 
$terms = get_terms( 'kurssi', $args );
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
    $count = count( $terms );
    $yhtmaara = 0;
?>
    <table id="t-taulukko" class="row-border">
        <thead>
            <tr class="t-rivi">	
                <th class="t-indeksit">Kurssi </th>
                <th class="t-indeksit">Tenttejä </th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach ( $terms as $term ) {
        $slug = esc_url( get_term_link( $term ) );
        $kurssi = $term->name;
        $maara = $term->count;
        $yhtmaara = $yhtmaara + $maara;
        echo '<tr class="item">';
        echo '<td><a class="hvr-grow-custom-smaller" href="' . $slug . '">' . $kurssi . '</a></td>';
        echo '<td> ' . $maara  . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo 'Tenttiarkistossa on yhteensä ' . $yhtmaara . ' tenttiä';
    echo '</div>';
}

get_footer();
