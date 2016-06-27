<!doctype html>
<html class="no-js" lang="">
    <head>
        <title>PARTYZING</title>
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <?php wp_head(); ?>
    </head>
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
          <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <a href="#" class="logo"><img src="<?php echo get_template_directory_uri(); ?>/img/logo.png" alt="image"></a>
              <!-- <a class="navbar-brand" href="#">Brand</a> -->
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <?php
                wp_nav_menu(
                  array(
                    'theme_location'  =>  'Primary',
                    'menu'      =>  'ul',
                    'menu_class'  =>  'nav navbar-nav navbar-right',
                    'container'	=> ''
                  )
                ); ?>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>