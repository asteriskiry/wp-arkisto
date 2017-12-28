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

<li id="pk-dropdown-li">
    <?php wp_dropdown_categories( 'show_option_none=Valitse vuosi&taxonomy=vuosi&value_field=slug'  ); ?>
        <script type="text/javascript">
            <!--
            var dropdown = document.getElementById("cat");
            function onCatChange() {
                if ( dropdown.options[dropdown.selectedIndex].value > 0  ) {
                location.href = "<?php echo esc_url( get_permalink()); ?>?vuosi="+dropdown.options[dropdown.selectedIndex].value;
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
                        'terms' => htmlspecialchars($_GET["vuosi"]),
                    ),
            ),
    );

    /* Loop joka hakee poytakirjat */
    /*$pkvuosittain = new WP_Query( array( 'post_type' => 'poytakirjat' ) );
     */$pkvuosittain = new WP_Query( $args );
    if ( $pkvuosittain-> have_posts() ) :
        echo '<div id="jobs-by-location">';
    	/* echo '<h4>' . esc_html__( $atts[ 'title' ] ) . '&nbsp' . esc_html__( ucwords( $location ) ) . '</h4>';
         */
        echo '<ul>';	
        while ( $pkvuosittain->have_posts() ) : $pkvuosittain->the_post();
        	global $post;
        	$title = get_the_title();
        	$slug = get_permalink();
            $tiedot = var_dump(get_post_meta($post));
        	echo '<li class="job-listing">';
            echo '<li><a href="' . $slug . '">' . $title . '</a>';
            echo '<span>' . esc_html( $tiedot ) . '</span>';
            echo '</li>';
        endwhile;
    echo '</ul>';
    echo '</div>';
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
