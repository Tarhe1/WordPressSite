<?php // Custom function - Add custom functions to flush cache on page edit



// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {
	
	exit;
	
}

//Get checkbox options and check if is not empty
$options = get_option( 'pressable_cache_management_options');
	
	if ( isset( $options['flush_cache_page_edit_checkbox'] ) && ! empty( $options['flush_cache_page_edit_checkbox'] ) ) {
		
//Flush Batcache cache on page edit
function clear_batcache_on_post_save() {
       wp_cache_flush(); 


	
	   //set_transient( 'page_edit_notice', 1 );
	   //Set transient for admin notice for 9 seconds
	   	   set_transient( 'page_edit_notice', true, 9 );
}
add_action( 'save_post', 'clear_batcache_on_post_save' );

		

		if ( get_transient( 'page_edit_notice' ) ) {	
	 
function page_edit_notice__success() {

	$screen = get_current_screen();
 
    //Display admin notice for this plugn page only
    if ( $screen->id !== 'toplevel_page_pressable_cache_management') return;
    $user    = $GLOBALS['current_user'];
	    // Check for current user to display  admin notice message to only
			if (  current_user_can( 'manage_options' ) ) {
				 
	
	//delete_transient('page_edit_notice');
    ?>
    <div class="notice notice-success is-dismissible">
        <p><?php _e( 'Cache was flushed becasue page or post was updated', 'sample-text-domain' ); ?></p>

    </div>

    <?php
}
	}
add_action( 'admin_notices', 'page_edit_notice__success' );

}
	} 

else {
   return;
}