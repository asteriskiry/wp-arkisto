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


<?php
	/**
	 * travelify_after_main_container hook
	 */
	do_action( 'travelify_after_main_container' );
?>

    <form id="category-select" class="category-select" action="<?php echo esc_url( home_url( '/asd'  )  ); ?>" method="get">
        <?php wp_dropdown_categories( 'taxonomy=vuosi'  ); ?>
        <input type="submit" name="submit" value="näytä" />
    </form>

<?php $args = array(
	'taxonomy'           => 'vuosi',
); ?>


<?php
 $terms = get_terms( array(
                          'taxonomy' => '2017',
                          'hide_empty' => false,  
)  );

 $output = '';
 foreach($terms as $term){
    $output .= '<input type="checkbox" name="terms" value="' . $term->name . '" /> ' .  $term->name . '<br />';
  
 }
?>

<?php get_footer(); ?>
