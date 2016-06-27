<?php
function mcp_register_party_post_type(){
	$singular='party';
	$plural='Partys';
	$label=array(
		'name'				=>$plural,
		'singular_name'		=>$singular,
		'add_name'			=>'Add New',
		'add_new_item'		=>'Add New '.$singular,
		'edit'				=>'Edit',
		'edit_item'			=>'Edit '.$singular,
		'new_item'			=>'New '.$singular,
		'view'				=>'View '.$singular,
		'view_item'			=>'View '.$singular,
		'search_term'		=>'Search '.$singular,
		'parent'			=>'Parent '.$singular,
		'not_found'			=>'No '.$plural.' Found',
		'not_found_in_trash'=>'No '.$plural.'Found in Trash'
		);
	$args = array(
		'labels' => $label,
        'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_admin_bar'	 =>true,
		'query_var'          => true,
		'rewrite'            => array( 
			'slug' 		=> 'partys',
			'with_front'=>true,
			'pages'		=>true,
			'feeds'		=>true
		 ),
		'capability_type'    => 'post',
		'menu_icon'			 =>'dashicons-groups',
		'can_export'		 =>true,
		'delete_with_mcper'	 =>true,
		'hierarchical'		 =>false,
		'has_archive'		 =>true,
		'map_meta_cap'		 =>true,
		'menu_position'      => 11 ,
		'supports'           => array( 
			'title', 
			'editor',
			'cmcptom-fields', 
			'comments',
			'thumbnail' ));
	register_post_type('Party',$args);
}
add_action('init','mcp_register_party_post_type');

// function mcp_register_theme_post_type(){
// 	$singular='Theme';
// 	$plural='Themes';
// 	$label=array(
// 		'name'				=>$plural,
// 		'singular_name'		=>$singular,
// 		'add_name'			=>'Add New',
// 		'add_new_item'		=>'Add New '.$singular,
// 		'edit'				=>'Edit',
// 		'edit_item'			=>'Edit '.$singular,
// 		'new_item'			=>'New '.$singular,
// 		'view'				=>'View '.$singular,
// 		'view_item'			=>'View '.$singular,
// 		'search_term'		=>'Search '.$singular,
// 		'parent'			=>'Parent '.$singular,
// 		'not_found'			=>'No '.$plural.' Found',
// 		'not_found_in_trash'=>'No '.$plural.'Found in Trash'
// 		);
// 	$args = array(
// 		'labels' => $label,
//         'public'             => true,
// 		'publicly_queryable' => true,
// 		'show_ui'            => true,
// 		'show_in_menu'       => true,
// 		'show_in_admin_bar'	 =>true,
// 		'query_var'          => true,
// 		'rewrite'            => array( 
// 			'slug' 		=> 'themes',
// 			'with_front'=>true,
// 			'pages'		=>true,
// 			'feeds'		=>true
// 		 ),
// 		'capability_type'    => 'page',
// 		'menu_icon'			 =>'dashicons-images-alt',
// 		'can_export'		 =>true,
// 		'delete_with_mcper'	 =>true,
// 		'hierarchical'		 =>false,
// 		'has_archive'		 =>true,
// 		'map_meta_cap'		 =>true,
// 		'menu_position'      => 11 ,
// 		'supports'           => array( 
// 			'title', 
// 			'editor',
// 			'cmcptom-fields', 
// 			'comments',
// 			'thumbnail' ));
// 	register_post_type('theme',$args);
// }
// add_action('init','mcp_register_theme_post_type');

function mcp_occasion_registor(){
	$labels = array(
		'name'              => _x( 'Occasions', 'taxonomy general name' ),
		'singular_name'     => _x( 'Occasion', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Occasions' ),
		'all_items'         => __( 'All Occasions' ),
		'parent_item'       => __( 'Parent Occasion' ),
		'parent_item_colon' => __( 'Parent Occasion:' ),
		'edit_item'         => __( 'Edit Occasion' ),
		'update_item'       => __( 'Update Occasion' ),
		'add_new_item'      => __( 'Add New Occasion' ),
		'new_item_name'     => __( 'New Occasion Name' ),
		'menu_name'         => __( 'Occasion' ),
	);
	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'occasion' ), 
	);
	register_taxonomy('Occasion','party',$args);
}

add_action('init','mcp_occasion_registor');

function mcp_theme_registor(){
	$labels = array(
		'name'              => _x( 'Themes', 'taxonomy general name' ),
		'singular_name'     => _x( 'Theme', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Themes' ),
		'all_items'         => __( 'All Themes' ),
		'parent_item'       => __( 'Parent Theme' ),
		'parent_item_colon' => __( 'Parent Theme:' ),
		'edit_item'         => __( 'Edit Theme' ),
		'update_item'       => __( 'Update Theme' ),
		'add_new_item'      => __( 'Add New Theme' ),
		'new_item_name'     => __( 'New Theme Name' ),
		'menu_name'         => __( 'Theme' ),
	);
	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'theme' ), 
	);
	register_taxonomy('theme','party',$args);
}

add_action('init','mcp_theme_registor');
?>