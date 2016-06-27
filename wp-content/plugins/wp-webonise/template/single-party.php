<!DOCTYPE html>
<html>
  <head>
  <?php wp_head(); ?>
 <script src="http://maps.google.com/maps/api/js?sensor=false"></script>
 </head>
  <body>
  
   <header><nav class="navbar navbar-inverse navbar-fixed-top">
	<?php wp_nav_menu(array(
		'theme_location'=='primary',
		'container'=>'div',
		'container_class'=>'container-fluid',
		'menu_class'=>'nav navbar-nav')
		); ?>
		</nav>
		</header>
  <?php
  	while ( have_posts() ) { the_post();
  ?>
    <br><br>
    These is a test page
    <?php }
     ?>
    </span>
    <span class="col-sm-3">
    <?php dynamic_sidebar('sidebar') ?>
    </span>
    <?php wp_footer(); ?>
  </body>
</html>