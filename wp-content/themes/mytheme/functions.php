<?php
	
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
	function my_theme_wrapper_start() {
	  echo '<section id="main">';
	}

	function my_theme_wrapper_end() {
	  echo '</section>';
	}
	add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
	add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);

	function mcp_script_enqueue(){
		wp_enqueue_style('customstyle',get_template_directory_uri().'/css/mytheme.css',array(),'1.0.0','all');
		wp_enqueue_script('smoothjs',"https://cdn.jsdelivr.net/scrollreveal.js/3.1.4/scrollreveal.min.js",array(),'3.1.4',true);
		wp_enqueue_script( 'wowjs', get_template_directory_uri().'/js/wow.js', array(), '1.0.0', false );
		wp_enqueue_script('customscript',get_template_directory_uri().'/js/mytheme.js',array(),'1.0.0',false);
		wp_enqueue_style('sitecss',get_template_directory_uri().'/css/site.css',array(),'1.0.0','all');
		wp_enqueue_script('animatejs',get_template_directory_uri().'/js/animate.css',array(),'1.0.0',true);
		wp_enqueue_style('boothstrap','http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css',array(),'1.0.0','all');
		wp_enqueue_style('socialicon',get_template_directory_uri().'/css/socialicon.css',array(),'1.0.0','all');
	}
	add_action('wp_enqueue_scripts','mcp_script_enqueue');

	function mcp_menu_setup(){
		add_theme_support('menus');

		register_nav_menu('Primary','Primary Top menu');
		register_nav_menu('Secondary','Footer menu');
		add_theme_support('post-formats',array('aside','image','video','gallery'));
		register_sidebar(  array(
			'name'			=>	'Sidebar',
			'id'			=>	'sidebar-1',
			'class'			=>	'side',
			'before_widget'	=>	'<aside id="%1$s" class="widget %2$s">',
			'after_widget'	=>	"</aside>",
			'before_title'	=>	'<h1 class="widget_title">',
			'after_title'	=>	'</h1>'
		));
		register_sidebar(  array(
			'name'			=>	'footerbar',
			'id'			=>	'sidebar-2',
			'class'			=>	'row',
			'before_widget'	=>	'<aside id="%1$s" class="widget %2$s col-sm-3">',
			'after_widget'	=>	"</aside>",
			'before_title'	=>	'<h1 class="widget_title">',
			'after_title'	=>	'</h1>'
		));
	}
	add_action('init','mcp_menu_setup');
	add_theme_support( 'custom-logo', array(
		'height'      => 300,
		'width'       => 400,
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => array( 'site-title', 'site-description' ),
	) );
	add_theme_support( 'woocommerce' ); 

function party_customize_register($wp_customize) 
{
	$wp_customize->add_section("big_title",array(
		"title"		=>	__("Big Title","customizer_party_sections"),
		"priority"	=>	30,
	));
	$wp_customize->add_setting("big_title_field", array(
		"default" => "Add zing to your Party",
		"transport" => "postMessage",
	));
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		"big_title_field",
		array(
			"label" => __("Enter Title", "customizer_ads_code_label"),
			"section" => "big_title",
			"settings" => "big_title_field",
			"type" => "input",
		)
	));
	$wp_customize->add_setting("big_title_desp", array(
		"default" => "Let your employees go crazy with the props, dress up, accessorize and get clicked at the funky photobooth like celebrities",
		"transport" => "postMessage",
	));
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		"big_title_desp",
		array(
			"label" => __("Enter Description", "customizer_ads_code_label"),
			"section" => "big_title",
			"settings" => "big_title_desp",
			"type" => "textarea",
		)
	));
	$wp_customize->add_setting("big_title_but_label", array(
		"default" => "Explore Packs",
		"transport" => "postMessage",
	));
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		"big_title_but_label",
		array(
			"label" => __("Enter Button Label", "customizer_ads_code_label"),
			"section" => "big_title",
			"settings" => "big_title_but_label",
			"type" => "text",
		)
	));
	$wp_customize->add_setting("big_title_but_link", array(
		"default" => "#",
		"transport" => "postMessage",
	));
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		"big_title_but_link",
		array(
			"label" => __("Enter Button Link", "customizer_ads_code_label"),
			"section" => "big_title",
			"settings" => "big_title_but_link",
			"type" => "text",
		)
	));
	$wp_customize->add_setting( 'big_title_bg', array(
		'sanitize_callback' => 'esc_url_raw',
		'transport' => 'postMessage'
	));
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'big_title_bg', array(
		'label' => __( 'Background', 'customizer_control' ),
		'section' => 'big_title',
		'settings' => 'big_title_bg',
		'priority' => 1,
	)));
	$wp_customize->add_section("promise",array(
		"title"		=>	__("Promises","customizer_party_sections"),
		"priority"	=>	31,
	));
	$wp_customize->add_setting( 'promise1_label', array(
		"default"	=>	__("Best quality products","customizer_party_sections"),
		'transport' => 'postMessage'
	));
	
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		"promise1_label",
		array(
			"label" => __("Label 1", "customizer_ads_code_label"),
			"section" => "promise",
			"settings" => "promise1_label",
			"type" => "text",
		)
	));
	$wp_customize->add_setting( 'promise1_img', array(
		'sanitize_callback' => 'esc_url_raw',
		'transport' => 'postMessage'
	));
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'promise1_img', array(
		'label' => __( 'image 1', 'customizer_control' ),
		'section' => 'promise',
		'settings' => 'promise1_img',
		'priority' => 1,
	)));
	$wp_customize->add_setting( 'promise2_img', array(
		'sanitize_callback' => 'esc_url_raw',
		'transport' => 'postMessage'
	));
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'promise2_img', array(
		'label' => __( 'image 2', 'customizer_control' ),
		'section' => 'promise',
		'settings' => 'promise2_img',
		'priority' => 1,
	)));
	$wp_customize->add_setting( 'promise3_img', array(
		'sanitize_callback' => 'esc_url_raw',
		'transport' => 'postMessage'
	));
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'promise3_img', array(
		'label' => __( 'image 3', 'customizer_control' ),
		'section' => 'promise',
		'settings' => 'promise3_img',
		'priority' => 1,
	)));
	$wp_customize->add_setting( 'promise2_label', array(
		"default"	=>	__("Free delivery","customizer_party_sections"),
		'transport' => 'postMessage'
	));
	
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		"promise2_label",
		array(
			"label" => __("Label 2", "customizer_ads_code_label"),
			"section" => "promise",
			"settings" => "promise2_label",
			"type" => "text",
		)
	));
	$wp_customize->add_setting( 'promise3_label', array(
		"default"	=>	__("Devlivers across India","customizer_party_sections"),
		'transport' => 'postMessage'
	));
	
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		"promise3_label",
		array(
			"label" => __("Label 3", "customizer_ads_code_label"),
			"section" => "promise",
			"settings" => "promise3_label",
			"type" => "text",
		)
	));
	$wp_customize->add_section("team",array(
		"title"		=>	__("Teams","customizer_party_sections"),
		"priority"	=>	33,
	));
	$wp_customize->add_setting( 'team1', array(
		"default"	=>	__("Team1","customizer_party_sections"),
		'transport' => 'postMessage'
	));
	
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		"team1",
		array(
			"label" => __("Team 1", "customizer_ads_code_label"),
			"section" => "team",
			"settings" => "team1",
			"type" => "text",
		)
	));
	$wp_customize->add_setting( 'team2', array(
		"default"	=>	__("Team2","customizer_party_sections"),
		'transport' => 'postMessage'
	));
	
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		"team2",
		array(
			"label" => __("Team 2", "customizer_ads_code_label"),
			"section" => "team",
			"settings" => "team2",
			"type" => "text",
		)
	));
	$wp_customize->add_setting( 'team3', array(
		"default"	=>	__("Team3","customizer_party_sections"),
		'transport' => 'postMessage'
	));
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		"team3",
		array(
			"label" => __("Team 3", "customizer_ads_code_label"),
			"section" => "team",
			"settings" => "team3",
			"type" => "text",
		)
	));
	$wp_customize->add_setting( 'team4', array(
		"default"	=>	__("Team4","customizer_party_sections"),
		'transport' => 'postMessage'
	));
	
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		"team4",
		array(
			"label" => __("Team 4", "customizer_ads_code_label"),
			"section" => "team",
			"settings" => "team4",
			"type" => "text",
		)
	));
	$wp_customize->add_setting( 'team5', array(
		"default"	=>	__("Team5","customizer_party_sections"),
		'transport' => 'postMessage'
	));
	
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		"team1",
		array(
			"label" => __("Team 1", "customizer_ads_code_label"),
			"section" => "team",
			"settings" => "team1",
			"type" => "text",
		)
	));
	$wp_customize->add_setting( 'team6', array(
		"default"	=>	__("Team6","customizer_party_sections"),
		'transport' => 'postMessage'
	));
	
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		"team6",
		array(
			"label" => __("Team 6", "customizer_ads_code_label"),
			"section" => "team",
			"settings" => "team6",
			"type" => "text",
		)
	));
	$wp_customize->add_setting( 'team7', array(
		"default"	=>	__("Team7","customizer_party_sections"),
		'transport' => 'postMessage'
	));
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		"team7",
		array(
			"label" => __("Team 7", "customizer_ads_code_label"),
			"section" => "team",
			"settings" => "team7",
			"type" => "text",
		)
	));
	$wp_customize->add_setting( 'team8', array(
		"default"	=>	__("Team8","customizer_party_sections"),
		'transport' => 'postMessage'
	));
	
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		"team8",
		array(
			"label" => __("Team 8", "customizer_ads_code_label"),
			"section" => "team",
			"settings" => "team8",
			"type" => "text",
		)
	));
}

add_action("customize_register","party_customize_register");   

function party_customizer_live_preview()
{
	wp_enqueue_script("party-themecustomizer", get_template_directory_uri() . "/js/themeoption.js", array("jquery", "customize-preview"), '',  true);
}

add_action("customize_preview_init", "party_customizer_live_preview");
//custom post type//
function party_post_setup(){
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
		'delete_with_user'	 =>true,
		'hierarchical'		 =>false,
		'has_archive'		 =>true,
		'map_meta_cap'		 =>true,
		'menu_position'      => 11 ,
		'taxonomies'		 =>array('post_tag','category'),
		'exclude_from_search'=>false,
		'supports'           => array( 
			'title', 
			'editor',
			'custom-fields', 
			'comments',
			'thumbnail' ));
	register_post_type('Party',$args);
}
add_action('init','party_post_setup');
function party_occasion_registor(){
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

add_action('init','party_occasion_registor');

function party_theme_registor(){
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

add_action('init','party_theme_registor');

function mcp_add_metabox(){
		add_meta_box(
			'mcp_location','Party Information','mcp_meta_callback','party','normal','high'
			);
	}
	add_action('add_meta_boxes','mcp_add_metabox');

	function mcp_meta_callback( $post ){
		wp_nonce_field(basename(__FILE__),"mcp_party_nonce");
		$mcp_stored_meta=get_post_meta($post->ID);

		?>
		<div>
				<div class="form-group">
					<label for="Party-id" class="mcp-row">Party ID:</label>
					<input type="text" class="form-control" name="party_id" id="party_id" placeholder="Party ID" value="<?php if(!empty($mcp_stored_meta['party_id'])) echo esc_attr($mcp_stored_meta['party_id'][0]); ?>"/>
				</div>
				<div class="form-group">
					<label for="Party-desp" class="mcp-desp">Party Description:</label>
					<textarea name="party_desp" id="party_desp" class="form-control" placeholder="Party Description"><?php if(!empty($mcp_stored_meta['party_desp'])) echo esc_attr($mcp_stored_meta['party_desp'][0]); ?></textarea>
				</div>
				<div class="form-group">
					<label for="Party-location" class="mcp-row">Party Location:</label>
					<input type="text" class="form-control" name="party_location" id="party_location" placeholder="Party Location" value="<?php if(!empty($mcp_stored_meta['party_location'])) echo esc_attr($mcp_stored_meta['party_location'][0]); ?>" />
					<div id="googleMap" style="width:500px;height:380px;"></div>
					<script>
					var input = /** @type {!HTMLInputElement} */(
						        document.getElementById('party_location'));
						function initMap() {
						    var map = new google.maps.Map(document.getElementById('googleMap'), {
						      center: {lat: -33.8688, lng: 151.2195},
						      zoom: 13
						    });
						    

						    var autocomplete = new google.maps.places.Autocomplete(input);
						    autocomplete.bindTo('bounds', map);

						    var infowindow = new google.maps.InfoWindow();
						    var marker = new google.maps.Marker({
						      map: map,
						      anchorPoint: new google.maps.Point(0, -29)
						    });
						    autocomplete.addListener('place_changed', function() {
						      infowindow.close();
						      marker.setVisible(false);
						      var place = autocomplete.getPlace();
						      if (!place.geometry) {
						        window.alert("Autocomplete's returned place contains no geometry");
						        return;
						      }

						      // If the place has a geometry, then present it on a map.
						      if (place.geometry.viewport) {
						        map.fitBounds(place.geometry.viewport);
						      } else {
						        map.setCenter(place.geometry.location);
						        map.setZoom(10);  // Why 17? Because it looks good.
						      }
						      marker.setIcon(/** @type {google.maps.Icon} */({
						        url: place.icon,
						        size: new google.maps.Size(71, 71),
						        origin: new google.maps.Point(0, 0),
						        anchor: new google.maps.Point(17, 34),
						        scaledSize: new google.maps.Size(35, 35)
						      }));
						      marker.setPosition(place.geometry.location);
						      marker.setVisible(true);

						      var address = '';
						      if (place.address_components) {
						        address = [
						          (place.address_components[0] && place.address_components[0].short_name || ''),
						          (place.address_components[1] && place.address_components[1].short_name || ''),
						          (place.address_components[2] && place.address_components[2].short_name || '')
						        ].join(' ');
						      }

						      infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
						      infowindow.open(map, marker);
						    });
						}
					</script>
					<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBUfuE9kFsnJNVN4Voz0M4Ee2dTKw00JbM&libraries=places&callback=initMap"
        async defer></script>
				</div>
				<div class="form-group">
					<label for="Party-date" class="mcp-row">Party Date:</label>
					<input type="date" class="form-control datepicker" name="party_date" id="party_date" placeholder="Party Date" value="<?php if(!empty($mcp_stored_meta['party_date'])) echo esc_attr($mcp_stored_meta['party_date'][0]); ?>"/>
				</div>
				<div class="checkbox">
					<label for="Party-food">Food Types:</label><br>
					<label for="Party-food"><input type="checkbox" id="mcp-veg" name="mcp-veg" <?php if(isset($mcp_stored_meta['mcp-veg'][0])){
						echo "checked";
					}?>>Veg</label>
				</div>
				<div class="checkbox">
					<label for="Party-food" class="mcp-row"><input type="checkbox" id="mcp-nveg" name="mcp-nveg" <?php if(isset($mcp_stored_meta['mcp-nveg'][0])){
						echo "checked";
					}?>>Non Veg</label>
				</div>
		</div>
		<?php
	}

	function mcp_meta_save( $post_id ){
		//check save status
		$is_autosave=wp_is_post_autosave($post_id);
		$is_revision=wp_is_post_revision($post_id);
		$is_valid_nonce=(isset($_POST['mcp_party_nonce'])&&wp_verify_nonce($_POST['mcp_party_nonce'],basename(__FILE__)));
		// Exit script depending on save status
		if($is_autosave||$is_revision||!$is_valid_nonce){
			return;
		}

		if(isset($_POST['party_id'])){
			update_post_meta($post_id,'party_id',sanitize_text_field($_POST['party_id']));
		}
		if(isset($_POST['party_location'])){
			update_post_meta($post_id,'party_location',sanitize_text_field($_POST['party_location']));
		}
		if(isset($_POST['party_desp'])){
			update_post_meta($post_id,'party_desp',sanitize_text_field($_POST['party_desp']));
		}
		
		update_post_meta($post_id,'mcp-veg',$_POST['mcp-veg']);
		update_post_meta($post_id,'mcp-nveg',$_POST['mcp-nveg']);
	}

	add_action('save_post','mcp_meta_save');

	// Creating the widget 
	class wpb_widget extends WP_Widget {

	function __construct() {
	parent::__construct(
	// Base ID of your widget
	'wpb_widget', 

	// Widget name will appear in UI
	__('Get Connected', 'wpb_widget_domain'), 

	// Widget description
	array( 'description' => __( 'Social links', 'wpb_widget_domain' ), ) 
	);
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {
	$title = apply_filters( 'widget_title', $instance['title'] );
	$facebook = apply_filters( 'widget_face', $instance['facebook'] );
	$twitter = apply_filters( 'widget_twitter', $instance['twitter'] );
	$insta = apply_filters( 'widget_insta', $instance['insta'] );
	$you = apply_filters( 'widget_insta', $instance['you'] );
	// before and after widget arguments are defined by themes
	echo $args['before_widget'];
	echo $args['before_title'] . $title . $args['after_title'];
	echo __( '<ul id="social" class="inline-list social-icons">', 'wpb_widget_domain' );
	echo __("<li><a href='".$twitter."' class='btn btn-social-icon btn-twitter'><i class='fa fa-twitter'></i></a></li>");
	echo  __(" <li><a href='".$facebook."' class='btn btn-social-icon btn-facebook'>
    <i class='fa fa-facebook'></i></a></li>") ;
	echo  __("<li><a href='".$insta ."' class='btn btn-social-icon btn-instagram'>
    <i class='fa fa-instagram'></i></a></li>") ;
    echo __("<li><a href='".$you ."' class='btn btn-social-icon btn-instagram'><i class='fa fa-youtube-square' aria-hidden='true'></i></a></li>");;
	echo __( '</ul>', 'wpb_widget_domain' );
	// This is where you run the code and display the output
	echo $args['after_widget'];
	}
			
	// Widget Backend 
	public function form( $instance ) {
	if ( isset( $instance[ 'title' ] ) ) {
	$title = $instance[ 'title' ];
	}
	else {
	$title = __( 'New title', 'wpb_widget_domain' );
	}
	if ( isset( $instance[ 'facebook' ] ) ) {
		$facebook = $instance[ 'facebook' ];
	}
	else {
		$facebook = __( 'New facebook', 'wpb_widget_domain' );
	}
	if ( isset( $instance[ 'twitter' ] ) ) {
		$Twitter = $instance[ 'twitter' ];
	}
	else {
		$Twitter = __( 'New Twitter', 'wpb_widget_domain' );
	}
	if ( isset( $instance[ 'instagram' ] ) ) {
		$insta = $instance[ 'instagram' ];
	}
	else {
		$insta = __( 'New Instagram', 'wpb_widget_domain' );
	}
	if ( isset( $instance[ 'you' ] ) ) {
		$you = $instance[ 'you' ];
	}
	else {
		$you = __( 'New Youtube', 'wpb_widget_domain' );
	}
	// Widget admin form
	?>
	<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	<label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e( 'Facebook link:' ); ?></label> 
	<input class="widefat" id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" type="text" value="<?php echo esc_attr( $facebook ); ?>" />
	<label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e( 'twitter link:' ); ?></label> 
	<input class="widefat" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" type="text" value="<?php echo esc_attr( $twitter ); ?>" />
	<label for="<?php echo $this->get_field_id( 'insta' ); ?>"><?php _e( 'Instagram link:' ); ?></label> 
	<input class="widefat" id="<?php echo $this->get_field_id( 'insta' ); ?>" name="<?php echo $this->get_field_name( 'insta' ); ?>" type="text" value="<?php echo esc_attr( $insta ); ?>" />
	<label for="<?php echo $this->get_field_id( 'you' ); ?>"><?php _e( 'Youtube link:' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'you' ); ?>" name="<?php echo $this->get_field_name( 'you' ); ?>" type="text" value="<?php echo esc_attr( $you ); ?>" />
	</p>
	<?php 
	}
		
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
	$instance = array();
	$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
	$instance['facebook'] = ( ! empty( $new_instance['facebook'] ) ) ? strip_tags( $new_instance['facebook'] ) : '';
	$instance['twitter'] = ( ! empty( $new_instance['twitter'] ) ) ? strip_tags( $new_instance['twitter'] ) : '';
	$instance['insta'] = ( ! empty( $new_instance['insta'] ) ) ? strip_tags( $new_instance['insta'] ) : '';
	$instance['you'] = ( ! empty( $new_instance['you'] ) ) ? strip_tags( $new_instance['you'] ) : '';
	return $instance;
	}
}

class contact extends WP_Widget {

	function __construct() {
	parent::__construct(
	// Base ID of your widget
	'contact', 

	// Widget name will appear in UI
	__('Contact Us', 'wpb_widget_domain'), 

	// Widget description
	array( 'description' => __( 'Contact Us', 'wpb_widget_domain' ), ) 
	);
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {
	$title = apply_filters( 'widget_title', $instance['title'] );
	$contact = apply_filters( 'widget_face', $instance['contact'] );
	$email = apply_filters( 'widget_email', $instance['email'] );
	// before and after widget arguments are defined by themes
	echo $args['before_widget'];
	echo $args['before_title'] . $title . $args['after_title'];
	echo __( '<ul>', 'wpb_widget_domain' );
	echo __("<li>Contact:-$contact</li>");
	echo  __(" <li>Email:-<a href='mailto:$email'>$email</a></li>") ;
	echo __( '</ul>', 'wpb_widget_domain' );
	// This is where you run the code and display the output
	echo $args['after_widget'];
	}
			
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
		$title = $instance[ 'title' ];
		}
		else {
		$title = __( 'New title', 'wpb_widget_domain' );
		}
		if ( isset( $instance[ 'contact' ] ) ) {
			$contact = $instance[ 'contact' ];
		}
		else {
			$contact = __( 'New contact', 'wpb_widget_domain' );
		}
		if ( isset( $instance[ 'email' ] ) ) {
			$email = $instance[ 'email' ];
		}
		else {
			$email = __( 'New email', 'wpb_widget_domain' );
		}
	// Widget admin form
	?>
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		<label for="<?php echo $this->get_field_id( 'contact' ); ?>"><?php _e( 'contact link:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'contact' ); ?>" name="<?php echo $this->get_field_name( 'contact' ); ?>" type="text" value="<?php echo esc_attr( $contact ); ?>" />
		<label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e( 'email link:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" type="text" value="<?php echo esc_attr( $email ); ?>" />
		<label for="<?php echo $this->get_field_id( 'insta' ); ?>"><?php _e( 'Instagram link:' ); ?></label> 
	</p>
	<?php 
	}
		
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['contact'] = ( ! empty( $new_instance['contact'] ) ) ? strip_tags( $new_instance['contact'] ) : '';
		$instance['email'] = ( ! empty( $new_instance['email'] ) ) ? strip_tags( $new_instance['email'] ) : '';
		return $instance;
	}


	} // Class wpb_widget ends here

	class newsletter extends WP_Widget {

	function __construct() {
	parent::__construct(
	// Base ID of your widget
	'NewsLetter', 

	// Widget name will appear in UI
	__('NewsLetter', 'wpb_widget_domain'), 

	// Widget description
	array( 'description' => __( 'Contact Us', 'wpb_widget_domain' ), ) 
	);
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {
	$title = apply_filters( 'widget_title', $instance['title'] );
	$contact = apply_filters( 'widget_face', $instance['contact'] );
	$email = apply_filters( 'widget_email', $instance['email'] );
	// before and after widget arguments are defined by themes
	echo $args['before_widget'];
	echo $args['before_title'] . $title . $args['after_title'];
	echo __( '<p>Sign Up for promotions</p>' );
	echo __('<form action="action="//partyzing.us13.list-manage.com/subscribe/post?u=107d7e51fa11fce6dec20e408&id=6addf66689"" method="post" ><input value="" placeholder="your-email@example.com" name="EMAIL" id="mail" aria-label="your-email@example.com" autocorrect="off" autocapitalize="off" type="email"><br><input class="btn btn-primary" name="subscribe" id="subscribe" value="Subscribe" type="submit"></form>');
	// This is where you run the code and display the output
	echo $args['after_widget'];
	}
			
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
		$title = $instance[ 'title' ];
		}
		else {
		$title = __( 'New title', 'wpb_widget_domain' );
		}
	// Widget admin form
	?>
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	</p>
	<?php 
	}
		
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}


	}

	// Register and load the widget
	function wpb_load_widget() {
		register_widget( 'wpb_widget' );
		register_widget( 'contact' );
		register_widget( 'newsletter');
	}
	add_action( 'widgets_init', 'wpb_load_widget' );
	wp_login_url( home_url() );

?>