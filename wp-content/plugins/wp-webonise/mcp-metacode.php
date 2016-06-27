<?php
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
					<label for="Party-id" class="mcp-row">Party ID:<?php echo($post->ID);?></label>
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
?>