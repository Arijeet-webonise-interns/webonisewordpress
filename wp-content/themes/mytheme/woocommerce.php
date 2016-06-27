<?php
/**
 * The template for displaying all WooCommerce pages.
 */
wp_enqueue_style('woostyle',get_template_directory_uri().'/css/woo.css',array(),'1.0.0','all');
get_header(); ?>

<div class="clear"></div>

</header> <!-- / END HOME SECTION  -->

<div id="content" class="site-content col-sm-9">

	<div class="container">

		<div class="content-left-wrap col-md-12">

			<div id="primary" class="content-area">

				<main id="main" class="site-main" role="main">

					<?php woocommerce_content(); ?>

				</main><!-- #main -->

			</div><!-- #primary -->

		</div><!-- .content-left-wrap -->

	</div><!-- .container -->
</div>
<div class="col-sm-3">
<?php 
get_sidebar();
?>
</div>
<?php
get_footer(); ?>