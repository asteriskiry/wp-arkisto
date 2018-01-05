<?php 
/*
* Template Name: Pöytäkirjat
* */
?>

<?php get_header(); ?>

<?php
	/**
	 * travelify_before_main_container hook
	 */
	do_action( 'travelify_before_main_container' );
?>

<div id="pk">
<div id="pk-dropdown">
<?php
global $wp;
$current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request  )  );
?>
<li id="pk-dropdown-li">
    <?php wp_dropdown_categories( 'show_option_none=Valitse vuosi&taxonomy=vuosi&value_field=slug'  ); ?>
        <script type="text/javascript">
            <!--
            var dropdown = document.getElementById("cat");
            function onCatChange() {
                if ( dropdown.options[dropdown.selectedIndex].value > 0  ) {
                    location.href = "<?php  $current_url ?>?vuosi="+dropdown.options[dropdown.selectedIndex].value;
                }
            }
        dropdown.onchange = onCatChange;
        -->
        </script>
    </li>

</div>
<div id="pk-content">
<?php
/* Parametrit Loopille */
    $args = array(
        'post_type' 		=> 'poytakirjat',
        'tax_query' 		=> array(
        array(
            'taxonomy' => 'vuosi',
            'field' => 'slug',
            'terms' => htmlspecialchars(isset($_GET["vuosi"]) ? $_GET['vuosi'] : null),
            ),
        ),
    );

    /* Loop joka hakee poytakirjat */
    $pkvuosittain = new WP_Query( $args );
    if ( $pkvuosittain-> have_posts() ) :
        echo '<table id="pk-taulukko">';
        echo '<tr class="pk-rivi">';	
        echo '<th class="pk-indeksit" onclick="w3.sortHTML(\'#pk-taulukko\',\'.item\', \'td:nth-child(1)\')">Nimi <i class="fa fa-sort" style="font-size:13px;"></i></th>';
        echo '<th class="pk-indeksit" onclick="w3.sortHTML(\'#pk-taulukko\',\'.item\', \'td:nth-child(2)\')">Järjestysnumero <i class="fa fa-sort" style="font-size:13px;"></i></th>';
        echo '<th class="pk-indeksit" onclick="w3.sortHTML(\'#pk-taulukko\',\'.item\', \'td:nth-child(3)\')">Päivämäärä <i class="fa fa-sort" style="font-size:13px;"></i></th>';
        echo '<th class="pk-indeksit" onclick="w3.sortHTML(\'#pk-taulukko\',\'.item\', \'td:nth-child(4)\')">Tyyppi <i class="fa fa-sort" style="font-size:13px;"></i></th>';
        echo '</tr>';
        while ( $pkvuosittain->have_posts() ) : $pkvuosittain->the_post();
        	global $post;
        	$title = get_the_title();
        	$slug = get_permalink();
            $pm = get_post_meta( $post->ID, 'pk_paivamaara', true );
            $jn = get_post_meta( $post->ID, 'pk_numero', true );
            $tyyppi = get_the_terms( $post->ID, 'tyyppi' );
        	echo '<tr class="item">';
            echo '<td><a href="' . $slug . '">' . $title . '</a></td>';
            echo '<td> ' . $jn  . '</td>';
            echo '<td> ' . $pm  . '</td>';
            echo '<td> ' . $tyyppi[0]->name  . '</td>';
            echo '</tr>';
        endwhile;
    echo '</table>';
    //echo '</div>';
endif;
?>

    </div>
</div>

<?php
    /**
    * travelify_after_main_container hook
    */
	do_action( 'travelify_after_main_container' );
?>

<?php get_footer(); ?>
