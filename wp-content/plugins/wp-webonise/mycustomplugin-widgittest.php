<?php
function mcp_theme_control($wp_customize){
	/**********************************************/
    /**********	LATEST Party SECTION ***************/
	/**********************************************/
	$wp_customize->add_section( 'zerif_latestparties_section' , array(
		'title'       => __( 'Latest Party section', 'zerif-lite' ),
    	'priority'    => 37
	));

	/* latest Part show/hide */
	$wp_customize->add_setting( 'zerif_latestparties_show', array(
		'sanitize_callback' => 'zerif_sanitize_checkbox',
		'transport' => 'postMessage'
	));

    $wp_customize->add_control( 'zerif_latestparties_show', array(
		'type' => 'checkbox',
		'label' => __('Hide latest Party section?','zerif-lite'),
		'section' => 'zerif_latestparties_section',
		'priority'    => 1,
	));

	/* latest news title */
	$wp_customize->add_setting( 'zerif_latestparties_title', array(
		'sanitize_callback' => 'zerif_sanitize_input',
		'transport' => 'postMessage'
	));

	$wp_customize->add_control( 'zerif_latestparties_title', array(
		'label'    		=> __( 'Latest Party title', 'zerif-lite' ),
		'section'  		=> 'zerif_latestparties_section',
		'priority'    	=> 2,
	));

	/* latest Part subtitle */
	$wp_customize->add_setting( 'zerif_latestparties_subtitle', array(
		'sanitize_callback' => 'zerif_sanitize_input',
		'transport' => 'postMessage'
	));

	$wp_customize->add_control( 'zerif_latestparties_subtitle', array(
		'label'    		=> __( 'Latest Party subtitle', 'zerif-lite' ),
	    'section'  		=> 'zerif_latestparties_section',
		'priority'   	=> 3,
	));
}
add_action('customize_register','mcp_theme_control');
?>