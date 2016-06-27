<?php
function party_create_occasion(){
	$singular='Occasion';
	$plural='Occasions';
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
			'slug' 		=> 'occasion',
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
	register_post_type('occasion',$args);
}
add_action('init','party_create_occasion');


?>