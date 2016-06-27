<?php
function mcp_form2_shortcode($atts,$content=null){
	wp_enqueue_script('mcp-form',plugins_url('js/customizer.js',__FILE__));
	wp_enqueue_style('mcp-form',plugins_url('css/admin-party.css',__FILE__));
	// The Query
	$s1='';
	$args=array(
		'post_type'				=>'theme',
		'orderby'				=>'menu_order',
		'order'					=>'ASC',
		'post_status'			=>'publish',
		'no_found_rows'			=>true,
		'update_post_term_cache'=>false,
		'post_per_post'			=>10
	);
	$the_query = new WP_Query( $args );

	// The Loop
	if ( $the_query->have_posts() ) {
		$s1=$s1. '<table class="table table-striped table-hover">';
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$s1=$s1. '<tr><td class="radio"><input onclick="rad(\''.get_the_title().'\')" type="radio" name="theme">' . get_the_title() . '</input></td></tr>';
		}
		$s1=$s1. '</table>';
	} else {
		// no posts found
		$s1='Not Found';
	}
	/* Restore original Post Data */
	wp_reset_postdata();			
	return $s1;
}
add_shortcode('mcp-party2-form','mcp_form2_shortcode');

?>