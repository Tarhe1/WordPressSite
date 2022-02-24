<?php
/*
Plugin Name:  Pressable Cache Management
Description:  Presable cache management made easy
Plugin URI:   https://pressable.com
Author:       Pressable Customer Success Team
Version:      2.0
Text Domain:  pressable_cache_management
Domain Path:  /languages
License:      GPL v2 or later
License URI:  https://www.gnu.org/licenses/gpl-2.0.txt
*/



// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}



// load text domain
function pressable_cache_management_load_textdomain() {

	load_plugin_textdomain( 'pressable_cache_management', false, plugin_dir_path( __FILE__ ) . 'languages/' );

}
add_action( 'plugins_loaded', 'pressable_cache_management_load_textdomain' );



// include plugin dependencies: admin only
if ( is_admin() ) {

	require_once plugin_dir_path( __FILE__ ) . 'admin/admin-menu.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/settings-page.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/settings-register.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/settings-callbacks.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/settings-validate.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/custom-functions/flush_cache_on_theme_plugin_update.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/custom-functions/flush_cache_on_page_edit.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/custom-functions/extend_batcache.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/custom-functions/turn_on_off_cdn.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/custom-functions/purge_cdn_cache.php';



}



// include plugin dependencies: admin and public
require_once plugin_dir_path( __FILE__ ) . 'includes/core-functions.php';


