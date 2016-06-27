<div class="container animated" id="team" style="padding:10px;">
	<div class="col-sm-6">
		<strong>Team</strong>
		<ul style="list-style-type: circle;">
			<div class="col-sm-6">
				<li id="team1"><?php echo get_theme_mod("team1"); ?></li>
				<li id="team2"><?php echo get_theme_mod("team2"); ?></li>
				<li id="team3"><?php echo get_theme_mod("team3"); ?></li>
				<li id="team4"><?php echo get_theme_mod("team4"); ?></li>
			</div>
			<div class="col-sm-6">
				<li id="team5"><?php echo get_theme_mod("team5"); ?></li>
				<li id="team6"><?php echo get_theme_mod("team6"); ?></li>
				<li id="team7"><?php echo get_theme_mod("team7"); ?></li>
				<li id="team8"><?php echo get_theme_mod("team8"); ?></li>
			</div>
		</ul>
	</div>
	<div class="col-sm-6">
		<strong>Occasion</strong>
		<ul>
			<div class="col-sm-6">
			<?php
			$args = array(
			    'taxonomy'	=>	'Occasion',
			    'number'	=>	8
			); 

			$tax = get_terms($args);
				for ($i=0; $i < 4; $i++) { 
					?><li><?php echo $tax[$i]->name;?></li><?php
					
				}
			?>
			</div>
			<div class="col-sm-6">
			<?php
				for ($i=4; $i < 8; $i++) { 
					?><li><?php echo $tax[$i]->name;?></li><?php
					
				}
			?>
			</div>
		</ul>
	</div>
</div>