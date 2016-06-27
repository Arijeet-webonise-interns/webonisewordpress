<?php
/*
Plugin Name: Party Planner
Plugin URI: https://localhost/wordpress
Description: Custom Plugin for wordpress
Version: 0.1.0
Author: Arijeet Baruah
Author URI: http://rishithegamecreator.wordpress.com
Text Domain: Custom
Domain Path: /languages
*/

// Exit if accessed directly
if(!defined('ABSPATH')){
	exit;
}

require_once (plugin_dir_path(__FILE__).'mycustomplugin-cpt.php');
require_once (plugin_dir_path(__FILE__).'mycustomplugin-admin.php');
require_once (plugin_dir_path(__FILE__).'mcp-metacode.php');
require_once (plugin_dir_path(__FILE__).'mycustomplugin-shortcode.php');
require_once (plugin_dir_path(__FILE__).'mycustomplugin-shortcode2.php');
require_once (plugin_dir_path(__FILE__).'mycustomplugin-shortcode3.php');
//require_once (plugin_dir_path(__FILE__).'mycustomplugin-widgittest.php');


function us_admin_enqueue_script(){
	global $pagenow,$typenow;
	if(($pagenow=="post.php")||($pagenow=="post-new.php")){
		wp_enqueue_style('boothstrap','http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css');
		wp_enqueue_script('boothstrapjs','http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js');
		wp_enqueue_style('mcp-style',plugins_url('css/admin-party.css',__FILE__));
		wp_enqueue_script('mcp-customjs',plugins_url('js/mcp-jquery.js',__FILE__),array('jquery','jquery-ui-datepicker'),'20150204',true);
		wp_enqueue_script('mcp-map','http://maps.googleapis.com/maps/api/js');
		wp_enqueue_style('jqueryfile','//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
	}
	wp_enqueue_script('mcp-media',plugins_url('js/mcp-media.js',__FILE__));
	
}
add_action('admin_enqueue_scripts','us_admin_enqueue_script');

?>
