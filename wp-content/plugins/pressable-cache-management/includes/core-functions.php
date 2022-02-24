<?php // Pressable Cache Management - Core Functionality



// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {
	
	exit;
	
}



// Process client ID text fiels
function pressable_api_client_id( $client_id ) {
	
	$options = get_option( 'pressable_cache_management_options');
	
	if ( isset( $options['api_client_id'] ) && ! empty( $options['api_client_id'] ) ) {

		// echo  $options['api_client_id'];
		
		$client_id  = esc_attr( $options['api_client_id'] );
		
	}
	
	return $client_id;
	
}
// add_filter( 'client_id_title', 'pressable_api_client_id' );



// Process client ID text fiels
function pressable_api_client_secret( $client_secret ) {
	
	$options = get_option( 'pressable_cache_management_options');
	
	if ( isset( $options['api_client_secret'] ) && ! empty( $options['api_client_secret'] ) ) {

		// echo  $options['api_client_secret'];

		
		$client_secret = esc_attr( $options['api_client_secret'] );
		
	}
	
	return $client_secret;
	
}
// add_filter( 'client_secret_title', 'pressable_api_client_id' );






//Check if post is initiated to prevent form submit on page reload
if( !empty($_POST) ){
	// if ( ! current_user_can( 'manage_options' ) ) wp_die();
// Flush cache button
function pressable_cache_button() {
	
	
	$options = get_option( 'pressable_cache_management_options');


	
    
	 wp_cache_flush();
	  //set_transient( 'set_transient', 'PEEE-TEST');
		 set_transient( 'set_transient_button', 50);

}
add_action( 'wp_before_admin_bar_render', 'pressable_cache_button', 999 );


//Success message on flush cache button click
function flush_cache_notice__success() {?>

    <div class="notice notice-success is-dismissible">
        <p><strong><?php _e( 'Cache flushed.', 'sample-text-domain' ); ?></strong></p>
    </div>
    <?php
}
add_action( 'admin_notices', 'flush_cache_notice__success' );

}



// Flush cache on theme/plugin update checkbox
function pressable_cache_checkbox() {
	
	
	$options = get_option( 'pressable_cache_management_options');
	
	if ( isset( $options['flush_cache_theme_plugin_checkbox'] ) && ! empty( $options['flush_cache_theme_plugin_checkbox'] ) ) {
	
		
	}
	

}
add_action( 'wp_before_admin_bar_render', 'pressable_cache_checkbox', 999 );



// Flush on page/post update checkbox
function pressable_cache_page_edit_checkbox() {
	
	
	$options = get_option( 'pressable_cache_management_options');
	
	if ( isset( $options['flush_cache_page_edit_checkbox'] ) && ! empty( $options['flush_cache_page_edit_checkbox'] ) ) {
		
		
	}
	

}
add_action( 'wp_before_admin_bar_render', 'pressable_cache_page_edit_checkbox', 999 );





