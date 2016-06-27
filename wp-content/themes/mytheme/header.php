<!DOCTYPE html>
<html>
<head>
	<title><?php echo wp_title( '-', true, 'right' ); ?></title>
	<?php wp_head();?>
</head>
<body>
<nav class="navbar">
	<div class="container-fluid">
		<div class="navbar-header logo">
			<?php the_custom_logo(); ?>
		</div>
		<div class="men">
		<?php
		wp_nav_menu(
			array(
				'theme_location'	=>	'Primary',
				'menu'			=>	'ul',
				'menu_class'	=>	'nav navbar-nav'
			)
		); ?>
		</div>
	</div>
</nav>