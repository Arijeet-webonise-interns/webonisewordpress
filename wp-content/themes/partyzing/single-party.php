<?php
get_header();
?>
<div class="post-content col-sm-9">
<?php

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post(); 
		?>
		<article class="row" id="post-<?php the_id(); ?>" <?php post_class(); ?>>
			<?php the_title('<h1 class="entry-title">','</h1>'); edit_post_link();
				?><div class="pull-left"></div><?php
			 ?>
			<small><?php the_category(); ?></small>
			<table style='width:100%; border:1'><col width='20%'><col width='80%'>
				<tr><th>Description</th><td><?php echo get_post_meta($id,'party_desp',false)[0]; ?></td></tr>
				<tr><th>Location</th>
				<td>
					<?php echo get_post_meta($id,'party_location',false)[0]; ?>
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
				        var address = "<?php echo get_post_meta($id,'party_location',false)[0];?>";
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
				</td></tr>
				<tr><th>Food</th><td>
				<?php
					$v=get_post_meta($id,'mcp-veg',false)[0];
					$nv=get_post_meta($id,'mcp-nveg',false)[0];
					if($v=="on"){
						?>Veg<?php
						if($nv=="on"){
							?>, Non Veg</td><?php
						}
					}else{
						if($nv=="on"){
							?>Non Veg<?php
						}else{
							?><i>Please Enter food</i><?php
						}
					}
				?>
			</table>
		</article>
		<div class="row">
			<?php
		if(comments_open()){
			comments_template();
		}else{
			echo "Command is closed";
		}
		?>
		</div>
		<?php
	} // end while
} // end if
?>
</div>
<div class="col-sm-3">
<?php
get_sidebar();
?>
</div>
<?php
get_footer();?>