<?php // Pressable Cache Management  - Validate Settings



// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {
	
	exit;
	
}



// callback: validate options
function pressable_cache_management_callback_validate_options( $input ) {
	
	
	// API Client ID
	if ( isset( $input['api_client_id'] ) ) {
		
		$input['api_client_id'] = sanitize_text_field( $input['api_client_id'] );
		
	}
	
	// API Client secrect
	if ( isset( $input['api_client_secret'] ) ) {
		
		$input['capi_client_secret'] = sanitize_text_field( $input['api_client_secret'] );
		
	}



	// checkbox
	if ( ! isset( $input['flush_cache_theme_plugin_checkbox'] ) ) {
		
		$input['flush_cache_theme_plugin_checkbox'] = null;
		
	}
	
	
	
	// checkbox
	if ( ! isset( $input['flush_cache_theme_plugin_checkbox'] ) ) {
		
		$input['flush_cache_theme_plugin_checkbox'] = null;
		
	}
	
	$input['flush_cache_theme_plugin_checkbox'] = ($input['flush_cache_theme_plugin_checkbox'] == 1 ? 1 : 0);
	

	
	return $input;
	
}


