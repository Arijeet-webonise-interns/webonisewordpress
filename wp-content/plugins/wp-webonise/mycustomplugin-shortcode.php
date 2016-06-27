<?php
function mcp_party_shortcode($atts,$content=null){
	wp_enqueue_style('mcp-style-list',plugins_url('css/mcp-party.css',__FILE__));
	$atts=shortcode_atts(
		array(
			'title'=>'Default title',
			'pagination'=>true
			),$atts
	);

	$paged=get_query_var('paged')?get_query_var('paged'):1;

	$args=array(
		'post_type'				=>'party',
		'orderby'				=>'menu_order',
		'order'					=>'ASC',
		'post_status'			=>'publish',
		'no_found_rows'			=>true,
		'update_post_term_cache'=>false,
		'post_per_post'			=>10
	);
	var_dump(apply_filters( 'taxonomy-images-queried-term-image', 'theme', array(
    'attr'       => array(
        'alt'   => 'Custom alternative text',
        'title' => 'Custom Title',
        ),
    'before'     => '<div id="my-custom-div">',
    'after'      => '</div>',
    'image_size' => 'medium'
) ));
	$party_list=new WP_Query($args);
	$s1="<div id='party-sort' class='wrap'>
			<div id='icon-party-admin' class='icon32'><br></div>";
			$id=get_the_ID();
	if($party_list->have_posts()){ 
						while ( $party_list->have_posts() ) :
							$party_list->the_post();
							if($id==get_the_ID())
							{
								$s1=$s1."<table style='width:100%; border:1'><col width='20%'><col width='80%'>";
								$s1=$s1."<tr><th>Description</th><td>".get_post_meta($id,'party_desp',false)[0]."</td></tr>";
								$s1=$s1."<tr><th>Location</th><td>".get_post_meta($id,'party_location',false)[0].'
								
    <div id="googleMap" style="width:100%;height:380px;"></div>
    <script>
      function initMap() {
        var map = new google.maps.Map(document.getElementById("googleMap"), {
          zoom: 8,
          center: {lat: -34.397, lng: 150.644}
        });
        var geocoder = new google.maps.Geocoder();

        document.getElementById("submit").addEventListener("click", function() {
          geocodeAddress(geocoder, map);
        });
        geocodeAddress(geocoder, map); 
      }

      function geocodeAddress(geocoder, resultsMap) {
        var address = "'.get_post_meta($id,'party_location',false)[0].'";
        geocoder.geocode({"address": address}, function(results, status) {
          if (status === google.maps.GeocoderStatus.OK) {
            resultsMap.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
              map: resultsMap,
              position: results[0].geometry.location
            });
          } else {
            alert("Geocode was not successful for the following reason: " + status);
          }
        });
      }

						</script>
						<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBUfuE9kFsnJNVN4Voz0M4Ee2dTKw00JbM&callback=initMap">
    </script>


								</td></tr>';
								$s1=$s1."<tr><th>Food</th><td>";
								$v=get_post_meta($id,'mcp-veg',false)[0];
								$nv=get_post_meta($id,'mcp-nveg',false)[0];
								if($v=="on"){
									$s1=$s1."Veg";
									if($nv=="on"){
										$s1=$s1.", Non Veg";
									}
								}else{
									if($nv=="on"){
										$s1=$s1."Non Veg";
									}else{
										$s1=$s1."<i>Please Enter food</i>";
									}
								}
								$s1=$s1."</table>";
							}
						endwhile;
					$s1=$s1."</ul>";
				 }else{ 
				$s1=$s1."<p>You have no Party to Sort</p>";
			 }
		$s1=$s1."</div> ";
	/* Restore original Post Data */
	wp_reset_postdata();
	//$string=get_post_meta();
	//var_dump($s1);
	return $s1;
}
add_shortcode('mcp-party-list','mcp_party_shortcode');
function us_add_my_media_button() {
    echo '<a id="insert-my-media" class="button">Add party shortcode</a>';
}
add_action('media_buttons', 'us_add_my_media_button', 15);
?>