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
				?><div class="pull-left"><img src="<?php echo get_post_meta(get_the_ID(),'Shopify Image Src',true);?>"></div><?php
			 ?>
			<small><?php the_category(); ?></small>
			<?php the_content(); 
			?>
		</article>
		
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