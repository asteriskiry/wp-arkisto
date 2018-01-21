<?php 

/**
 * Template Name: Pöytäkirjat-archive
 **/
?>

<?php get_header(); ?>

<?php
/* travelify_before_main_container hook */
//do_action( 'travelify_before_main_container' );
?>

<div id="pk">
<div id="pk-dropdown">
<?php

/* Dropdown-valikko */

global $wp;
$current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request  )  );
?>
<li id="pk-dropdown-li">
    <?php wp_dropdown_categories( 'show_option_none=Valitse vuosi&taxonomy=vuosi&value_field=slug'  ); ?>
<script type="text/javascript">

    var dropdown = document.getElementById("cat");
    function onCatChange() {
        if ( dropdown.options[dropdown.selectedIndex].value > 0  ) {
            location.href = "<?php  $current_url ?>?vuosi="+dropdown.options[dropdown.selectedIndex].value;
        }
    }

dropdown.onchange = onCatChange;

</script>
</li>
</div>
<div id="pk-content">
<?php

/* Parametrit Loopeille */

$args_by_year = array(
    'post_type' 		=> 'poytakirjat',
    'posts_per_page'        => -1,
    'tax_query' 		=> array(
        array(
            'taxonomy' => 'vuosi',
            'field' => 'slug',
            'terms' => htmlspecialchars(isset($_GET["vuosi"]) ? $_GET['vuosi'] : null),
        ),
    ),
);

$args_recent = array( 
    'numberposts' => '4',
    'post_type' => 'poytakirjat'
);

/* Jos vuotta ei valittu, generoidaan viimeisimmät  */

if ($args_by_year['tax_query'][0]['terms'] == '') {

	$recent_posts = wp_get_recent_posts( $args_recent );
    echo '<h1 class="customtitle">Viimeisimmät</h1>';
    echo '<div class="pk-flex-recent">';

    foreach( $recent_posts as $recent ){

        $c_pdf_data_recent = get_post_meta($recent["ID"], 'custom_pdf_data');
        $tn = $c_pdf_data_recent[0]['tnMed'];
        echo '<div class="pk-recent">' . $recent["post_title"];
		echo '<a class="hvr-curl-top-right" href="' . get_permalink($recent["ID"]) . '">' . '<img src="' . $tn . '"></img></a></div>';
    }

    echo '</div>';
	wp_reset_query();

/* Jos vuosi valitaan */

} else {

$pk_by_year = new WP_Query( $args_by_year );
if ( $pk_by_year-> have_posts() ) :

    /* HTML: taulukon staattiset kentät */

    echo '<h1 class="customtitle">' . get_the_terms( $post->ID, 'vuosi' )[0]->name . '</h1>';
?>
    <table id="pk-taulukko" class="row-border">
        <thead>
            <tr class="pk-rivi">	
                <th class="pk-indeksit">Nimi </th>
                <th class="pk-indeksit">Järjestysnumero </th>
                <th class="pk-indeksit">Päivämäärä </th>
                <th class="pk-indeksit">Tyyppi </th>
            </tr>
        </thead>
        <tbody>
<?php

/* Haetaan tiedot ja tallennetaan muuttujiin */

while ( $pk_by_year->have_posts() ) : $pk_by_year->the_post();

    global $post;
    $title = get_the_title();
    $custom_pdf_data = get_post_meta($post->ID, 'custom_pdf_data');
    /* Kommentoitu $slug sitä varten jos halutaan valikosta suoraan pdf-tiedostoon */
    //$slug = $custom_pdf_data[0]['src'];
    $slug = get_permalink();
    $pm = get_post_meta( $post->ID, 'pk_paivamaara', true );
    $jn = get_post_meta( $post->ID, 'pk_numero', true );
    $tyyppi = get_the_terms( $post->ID, 'tyyppi' );
    $thumbnail = $custom_pdf_data[0]['tnSmall']; 

    /* HTML: dynaamiset kentät*/
    echo '<tr class="item">';
    echo '<td><div class="tooltip"><a class="hvr-grow" href="' . $slug . '">' . $title . ' <i class="fas fa-file-pdf" ></i></a><img class="tooltipimg" src="' . $thumbnail  . '"></div></td>';
    echo '<td> ' . $jn  . '</td>';
    echo '<td> ' . $pm  . '</td>';
    echo '<td> ' . $tyyppi[0]->name  . '</td>';
    echo '</tr>';
endwhile;
echo '</tbody>';
echo '</table>';
endif;
}
?>
</div>
</div>
<?php
/* travelify_after_main_container hook */
do_action( 'travelify_after_main_container' );
?>

<?php get_footer(); ?>
