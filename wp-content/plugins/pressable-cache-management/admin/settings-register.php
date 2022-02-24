<?php // Pressable Cache Management  - Register Settings



// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {
	
	exit;
	
}



// register plugin settings
function pressable_cache_management_register_settings() {
	
	
	register_setting( 
		'pressable_cache_management_options', 
		'pressable_cache_management_options', 
		'pressable_cache_management_callback_validate_options' 
	); 
	
	/*
	
	add_settings_section( 
		string   $id, 
		string   $title, 
		callable $callback, 
		string   $page
	);
	
	*/
	
	add_settings_section( 
		'pressable_cache_management_section_cache', 
		esc_html__('Cache Mangement By', 'pressable_cache_management'), 
		'pressable_cache_management_callback_section_cache', 
		'pressable_cache_management'
	);
	
	//TODO: Add CDN managent section - uncomment the function pressable_cache_management_callback_section_cdn in call back settins 
	add_settings_section( 
		'pressable_cache_management_section_cdn', 
		esc_html__('Manage CDN Settings', 'pressable_cache_management'), 
		'pressable_cache_management_callback_section_cdn', 
		'pressable_cache_management'
	);
	
	/*
	
	add_settings_field(
    	string   $id, 
		string   $title, 
		callable $callback, 
		string   $page, 
		string   $section = 'default', 
		array    $args = []
	);
	
	*/

	add_settings_field(
		'pressable_site_id',
		esc_html__('Presable Site ID', 'pressable_cache_management'),
		'pressable_cache_management_callback_field_site_id_text',
		'pressable_cache_management', 
		'pressable_cache_management_section_cache', 
		[ 'id' => 'pressable_site_id', 'label' => esc_html__('Enter your Pressable Site ID', 'pressable_cache_management') ]
	);



	add_settings_field(
		'api_client_id',
		esc_html__('Client ID', 'pressable_cache_management'),
		'pressable_cache_management_callback_field_id_text',
		'pressable_cache_management', 
		'pressable_cache_management_section_cache', 
		[ 'id' => 'api_client_id', 'label' => esc_html__('Enter your Pressable API client ID', 'pressable_cache_management') ]
	);


	add_settings_field(
		'api_client_secret',
		esc_html__('Client secret', 'pressable_cache_management'),
		'pressable_cache_management_callback_field_secret_text',
		'pressable_cache_management', 
		'pressable_cache_management_section_cache', 
		[ 'id' => 'api_client_secret', 'label' => esc_html__('Enter your Pressable API client secret', 'pressable_cache_management') ]
	);



	add_settings_field(
		'flush_cache_button',
		esc_html__('Flush Object Cache', 'pressable_cache_management'),
		'pressable_cache_management_callback_field_button',
		'pressable_cache_management', 
		'pressable_cache_management_section_cache', 
		[ 'id' => 'flush_cache_button', 'label' => esc_html__('Flush your Pressable site object cache (Database)', 'pressable_cache_management') ]
	);
	
	add_settings_field(
		'flush_cache_theme_plugin_checkbox',
		esc_html__('Flush Cache on Update', 'pressable_cache_management'),
		'pressable_cache_management_callback_field_plugin_theme_update_checkbox',
		'pressable_cache_management', 
		'pressable_cache_management_section_cache',  
		[ 'id' => 'flush_cache_theme_plugin_checkbox', 'label' => esc_html__('Flush cache automatically on plugin & theme update', 'pressable_cache_management') ]
	);


	add_settings_field(
		'flush_cache_page_edit_checkbox',
		esc_html__('Flush Cache on Edit', 'pressable_cache_management'),
		'pressable_cache_management_callback_field_plugin_theme_update_checkbox',
		'pressable_cache_management', 
		'pressable_cache_management_section_cache',  
		[ 'id' => 'flush_cache_page_edit_checkbox', 'label' => esc_html__('Flush Batcache automatically when new page/post is updated', 'pressable_cache_management') ]


	);



	add_settings_field(
		'extend_batcache_checkbox',
		esc_html__('Flush Cache on Edit', 'pressable_cache_management'),
		'pressable_cache_management_callback_field_extend_cache_checkbox',
		'pressable_cache_management', 
		'pressable_cache_management_section_cache',  
	    [ 'id' => 'extend_batcache_checkbox', 'label' => esc_html__('Extend the length of time a Batcache render is stored', 'pressable_cache_management') ]


	);

		//CDN management

	 add_settings_field(
		'cdn_on_off_radio_button',
		esc_html__('Turn on/off CDN', 'pressable_cache_management'),
		'pressable_cache_management_callback_field_extend_cdn_radio_button',
		'pressable_cache_management', 
		'pressable_cache_management_section_cdn',  
	    [ 'id' => 'cdn_on_off_radio_button', 'label' => esc_html__('Turn on/off your CDN (Not recommended)', 'pressable_cache_management') ]


		);


	 		//Flush CDN cache button
	add_settings_field(
		'purge_cdn_cache_button',
		esc_html__('Purge CDN Cache', 'pressable_cache_management'),
		'pressable_cdn_cache_flush_management_callback_field_button',
		'pressable_cache_management', 
		'pressable_cache_management_section_cdn', 
		[ 'id' => 'purge_cdn_cache_button', 'label' => esc_html__('Purge CDN cache (Static files JS/CSS)', 'pressable_cache_management') ]
	);


    
} 
add_action( 'admin_init', 'pressable_cache_management_register_settings' );

