<?php // Custom function - Flush cache tomatically auon theme and plugin update



// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {
	
	exit;
	
}
	
	//call option from checkbox to see if an option is selected
     $options = get_option( 'pressable_cache_management_options');
	
	if ( isset( $options['flush_cache_theme_plugin_checkbox'] ) && ! empty( $options['flush_cache_theme_plugin_checkbox'] ) ) {

        

	//Check if theme or plugin is updated then flush cache when complete
    function pressable_plugins_update_completed( $upgrader_object, $options ) {

    if ( $options['action'] == 'update' && $options['type'] == 'plugin' && isset( $options['plugins'] ) ) {

         wp_cache_flush(); 


          
          //Set transiet for 9 seconds to remove admin notice
          set_transient( 'plugin_theme_update_notice', true, 9 );
         
    }
}
add_action( 'upgrader_process_complete', 'pressable_plugins_update_completed', 10, 2 );

		
 if ( get_transient( 'plugin_theme_update_notice' ) ) {
	
        

function plugin_theme_admin_notice_success() {


	$screen = get_current_screen();
 
    //Display admin notice for this plugn page only
    if ( $screen->id !== 'toplevel_page_pressable_cache_management') return;
    $user    = $GLOBALS['current_user'];
	 // Check for current user to display  admin notice message to only
	if (  current_user_can( 'manage_options' ) ) {

    ?>
    <div class="notice notice-success is-dismissible">
        <p><?php _e( 'Cache was flushed because theme or plugin was updated.', 'text-domain' ); ?></p>

	 
    </div>
    <?php
} 
	}

add_action( 'admin_notices', 'plugin_theme_admin_notice_success' );

}
		
	 } else {

   return;
}