
<div class="animated">
<?php get_header(); ?>
</div>
<?php
get_template_part( 'section/bigtitle' );
get_template_part('section/team');
get_template_part('section/packs');
get_template_part('section/detail');
?>
<hr>
<div id="sidebar" class="footer-section row">
	<?php dynamic_sidebar('sidebar-2'); ?>
</div>
<?php
get_template_part('section/custompack');
?>
<div class="animated">
<?php get_footer();?>
</div>