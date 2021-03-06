<?php // Pressable Cache Management  - Register Settings


// disable direct file access
if (!defined('ABSPATH'))
{

    exit;

}

// register plugin settings
function pressable_cache_management_register_settings()
{
    //Save options for object cache tab
    register_setting('pressable_cache_management_options', 'pressable_cache_management_options', 'pressable_cache_management_callback_validate_options');

    //Save options for CDN tab
    register_setting('cdn_settings_tab_options', 'cdn_settings_tab_options', 'cdn_settings_tab_callback_validate_options');

    //Save option for API Authentication tab
    register_setting('pressable_api_authentication_tab_options', 'pressable_api_authentication_tab_options', 'pressable_api_authentication_tab_callback_validate_options');

    //Save options for branding tab
    register_setting('remove_pressable_branding_tab_options', 'remove_pressable_branding_tab_options', 'remove_pressable_branding_tab_callback_validate_options');

    //Object cache page
    add_settings_section('pressable_cache_management_section_cache', esc_html__('Cache Mangement By', 'pressable_cache_management') , 'pressable_cache_management_callback_section_cache', 'pressable_cache_management',);

    //CDN settings tab page
    add_settings_section('pressable_cache_management_section_cdn', esc_html__('Manage CDN Settings', 'cdn_settings_tab') , 'pressable_cache_management_callback_section_cdn', 'cdn_settings_tab');

    //API authentication tab page
    add_settings_section('pressable_cache_management_section_api_authentication', esc_html__('API Authentication', 'pressable_api_authentication_tab') , 'pressable_cache_management_callback_section_authentication', 'pressable_api_authentication_tab');

    //Remove Pressable branding tab page
    add_settings_section('pressable_cache_management_section_branding', esc_html__('Show or Hide Plugin Branding', 'remove_pressable_branding_tab') , 'pressable_cache_management_callback_section_branding', 'remove_pressable_branding_tab');

    // verify if the options exist
    if (false == get_option('pressable_cache_management_options'))
    {
        add_option('pressable_cache_management_options');
    }

    add_settings_section('display_settings_section', 'pressable_cache_management', 'cdn_settings_tab', 'tpressable_api_authentication_tab', 'remove_pressable_branding_tab');


    /*
    Ojbect Cache Management Tab 
        
    */

    //Flush object cache button
    add_settings_field('flush_cache_button', esc_html__('Flush Object Cache', 'pressable_cache_management') , 'pressable_cache_management_callback_field_button', 'pressable_cache_management', 'pressable_cache_management_section_cache', ['id' => 'flush_cache_button', 'label' => esc_html__('Flush object cache (Database)', 'pressable_cache_management') ]);

    //Extend batache checkbox
    add_settings_field('extend_batcache_checkbox', esc_html__('Extend Batcache', 'pressable_cache_management') , 'pressable_cache_management_callback_field_extend_cache_checkbox', 'pressable_cache_management', 'pressable_cache_management_section_cache', ['id' => 'extend_batcache_checkbox', 'label' => esc_html__('Extend the length of time a Batcache render is stored', 'pressable_cache_management') ]);

    //Flush object cache on theme or plugin update
    add_settings_field('flush_cache_theme_plugin_checkbox', esc_html__('Flush Cache on Update', 'pressable_cache_management') , 'pressable_cache_management_callback_field_plugin_theme_update_checkbox', 'pressable_cache_management', 'pressable_cache_management_section_cache', ['id' => 'flush_cache_theme_plugin_checkbox', 'label' => esc_html__('Flush batcache automatically on plugin & theme update', 'pressable_cache_management') ]);

    //Flush object cache on page or post checkbox
    add_settings_field('flush_cache_page_edit_checkbox', esc_html__('Flush Cache on Edit', 'pressable_cache_management') , 'pressable_cache_management_callback_field_page_edit_checkbox', 'pressable_cache_management', 'pressable_cache_management_section_cache', ['id' => 'flush_cache_page_edit_checkbox', 'label' => esc_html__('Flush Batcache automatically when new page/post is updated', 'pressable_cache_management') ]);

    //Flush cache for a single page
    add_settings_field('flush_object_cache_for_single_page', esc_html__('Flush Batcache for single page', 'pressable_cache_management') , 'pressable_cache_management_callback_field_flush_batcache_particular_page_checbox', 'pressable_cache_management', 'pressable_cache_management_section_cache', ['id' => 'flush_object_cache_for_single_page', 'label' => esc_html__('Flush batache cache for a particular page', 'pressable_cache_management') ]);

    //  //Exempt from batache textbox
    // add_settings_field('exempt_from_batcache', esc_html__('Exclude page from batcache', 'pressable_cache_management') , 'pressable_cache_management_callback_field_exempt_batcache_text', 'pressable_cache_management', 'pressable_cache_management_section_cache', ['id' => 'exempt_from_batcache', 'label' => esc_html__('Exempt page from Batache ', 'pressable_cache_management') ]);
    /*
    CDN Management Tab
        
    */

    //CDN Radio button
   
    $api_auth_tab_options = get_option('pressable_api_authentication_tab_options');
//   $api_client_id = $api_auth_tab_options['api_client_id'];
    
    if (empty($api_auth_tab_options['api_client_id']))
    {
        add_settings_field('no_cdn_option', esc_html__('Turn on/off your CDN', 'cdn_settings_tab') , 'pressable_cdn_enable_api', 'cdn_settings_tab', 'pressable_cache_management_section_cdn', ['id' => 'no_cdn_option', 'label' => esc_html__('Turn on/off your CDN') ]);
    }
    else
    {
        add_settings_field('cdn_on_off_radio_button', esc_html__('Turn On/Off CDN', 'cdn_settings_tab') , 'pressable_cache_management_callback_field_extend_cdn_radio_button', 'cdn_settings_tab', 'pressable_cache_management_section_cdn', ['id' => 'cdn_on_off_radio_button', 'label' => esc_html__('Turn on/off your CDN', 'cdn_settings_tab') ]);
    };

    
    
    //Purge CDN cache button
    $cdn_tab_options = get_option('cdn_settings_tab_options');
     if (empty($api_auth_tab_options['api_client_id']))
    {
    }
    else
    {
//           if ($cdn_tab_options['cdn_on_off_radio_button'] == "enable")  
//         {
              if ($cdn_tab_options && $cdn_tab_options['cdn_on_off_radio_button'] == 'enable') {
        
        
    
                   
            add_settings_field('purge_cdn_cache_button', esc_html__('Purge CDN Cache', 'cdn_settings_tab') , 'pressable_cdn_cache_flush_management_callback_field_button', 'cdn_settings_tab', 'pressable_cache_management_section_cdn', ['id' => 'purge_cdn_cache_button', 'label' => esc_html__('Purge CDN Cache (Static files Img/CSS/JS/WEBP)', 'cdn_settings_tab') ]);
        }
        else
        {

        }
    }

    //CDN cache extender
    if (empty($api_auth_tab_options['api_client_id']))
    {
    }
    else
    {
          if ($cdn_tab_options && $cdn_tab_options['cdn_on_off_radio_button'] == 'enable') {
              
            add_settings_field('cdn_cache_extender', esc_html__('CDN Cache Extender', 'cdn_settings_tab') , 'pressable_cdn_cache_extender_callback_field_checkbox', 'cdn_settings_tab', 'pressable_cache_management_section_cdn', ['id' => 'cdn_cache_extender', 'label' => esc_html__('Extend the cache-control from 7 days until 10 years for static assets', 'cdn_settings_tab') ]);
        }
        else
        {

        }
    }

    //Exlude image files from CDN caching
      if (empty($api_auth_tab_options['api_client_id']))
    {
    }
    else
    {
              if ($cdn_tab_options && $cdn_tab_options['cdn_on_off_radio_button'] == 'enable') {
            
              add_settings_field('exclude_jpg_png_webp_from_cdn', esc_html__('Exlude image file', 'pressable_cache_management') , 'pressable_cache_management_callback_field_exclude_cdn_image_webp_checkbox', 'cdn_settings_tab', 'pressable_cache_management_section_cdn', ['id' => 'exclude_jpg_png_webp_from_cdn', 'label' => esc_html__('Exclude .JPG, .PNG, WEBP files from CDN Caching', 'cdn_settings_tab') ]);
        }
        else
        {

        }
    }

    //Exlude all .json and .js file from CDN caching
      if (empty($api_auth_tab_options['api_client_id']))
    {
    }
    else
    {
               if ($cdn_tab_options && $cdn_tab_options['cdn_on_off_radio_button'] == 'enable') {
                   
            add_settings_field('exclude_json_js_from_cdn', esc_html__('Exclude .json and .js file', 'pressable_cache_management') , 'pressable_cache_management_callback_field_exclude_json_checkbox', 'cdn_settings_tab', 'pressable_cache_management_section_cdn', ['id' => 'exclude_json_js_from_cdn', 'label' => esc_html__('Exclude all .json and .js files from CDN Caching', 'cdn_settings_tab') ]);
        }
        else
        {

        }
    }

    //Exlude all .css file from CDN caching
      if (empty($api_auth_tab_options['api_client_id']))
    {
    }
    else
    {
              if ($cdn_tab_options && $cdn_tab_options['cdn_on_off_radio_button'] == 'enable') {
                  
                
            add_settings_field('exclude_css_from_cdn', esc_html__('Exclude .css file', 'pressable_cache_management') , 'pressable_cache_management_callback_field_exclude_json_checkbox', 'cdn_settings_tab', 'pressable_cache_management_section_cdn', ['id' => 'exclude_css_from_cdn', 'label' => esc_html__('Exclude all .css files from CDN Caching', 'cdn_settings_tab') ]);
        }
        else
        {

        }
    }

    //Exclude a particular file from CDN caching textbox
      if (empty($api_auth_tab_options['api_client_id']))
    {
    }
    else
    {
            if ($cdn_tab_options && $cdn_tab_options['cdn_on_off_radio_button'] == 'enable') {
               
            add_settings_field('exclude_particular_file_from_cdn', esc_html__('Exclude a particular file', 'pressable_cache_management') , 'pressable_cache_management_callback_field_exclude_partucular_file_text', 'cdn_settings_tab', 'pressable_cache_management_section_cdn', ['id' => 'exclude_particular_file_from_cdn', 'label' => esc_html__('To exclude multiple files separate with | eg template.js|style.css', 'cdn_settings_tab') ]);
        }
        else
        {

        }
    }

    /*
    Authentication Management Tab
        
    */

    //Check if the connection to the API is successful from the DB
    $site_id_con_res = get_option('pcm_site_id_con_res');
    if ($site_id_con_res === 'OK')
    {

        //Hide site id field if connection successful
        //Site ID
        add_settings_field('pressable_site_id', esc_html__('Site ID', 'pressable_api_authentication_tab') , //Displayed title
        'pressable_cache_management_callback_field_site_id_text', //Callback used to render the description
        'pressable_api_authentication_tab', //Plugin page/tab
        'pressable_cache_management_section_api_authentication', //Plugin section
        ['id' => 'pressable_site_id', 'class' => 'textbox-hidden', 'label' => esc_html__('Enter the site ID', 'pressable_api_authentication_tab') ] //Array of passed from this field
        );

        
    //Show site id field if connection not-successful
    }
    elseif ($site_id_con_res === 'Not Found')
    {

        //Site ID
        add_settings_field('pressable_site_id', esc_html__('Site ID', 'pressable_api_authentication_tab') , //Displayed title
        'pressable_cache_management_callback_field_site_id_text', //Callback used to render the description
        'pressable_api_authentication_tab', //Plugin page/tab
        'pressable_cache_management_section_api_authentication', //Plugin section
        ['id' => 'pressable_site_id', 'label' => esc_html__('Enter the site ID', 'pressable_api_authentication_tab') ] //Array of passed from this field
        );

    } elseif ($site_id_con_res === '')
    {


        //Site ID
        add_settings_field('pressable_site_id', esc_html__('Site ID', 'pressable_api_authentication_tab') , //Displayed title
        'pressable_cache_management_callback_field_site_id_text', //Callback used to render the description
        'pressable_api_authentication_tab', //Plugin page/tab
        'pressable_cache_management_section_api_authentication', //Plugin section
        ['id' => 'pressable_site_id', 'label' => esc_html__('Enter the site ID', 'pressable_api_authentication_tab') ] //Array of passed from this field
        );

    } 


    //Client ID textbox
    add_settings_field('api_client_id', esc_html__('Client ID', 'pressable_api_authentication_tab') , 'pressable_cache_management_callback_field_id_text', 'pressable_api_authentication_tab', 'pressable_cache_management_section_api_authentication', ['id' => 'api_client_id', 'label' => esc_html__('Enter the API client ID', 'pressable_api_authentication_tab') ]);

    //Client secret textbox
    add_settings_field('api_client_secret', esc_html__('Client Secret', 'pressable_api_authentication_tab') , 'pressable_cache_management_callback_field_secret_text', 'pressable_api_authentication_tab', 'pressable_cache_management_section_api_authentication', ['id' => 'api_client_secret', 'label' => esc_html__('Enter the API client secret', 'pressable_api_authentication_tab') ]);

    /*
    Remove Pressable Branding Tab
        
    */

    //CDN Radio button
    add_settings_field('branding_on_off_radio_button', esc_html__('Hide or Show Plugin Branding', 'remove_pressable_branding_tab') , 'pressable_cache_management_callback_field_extend_remove_branding_radio_button', 'remove_pressable_branding_tab', 'pressable_cache_management_section_branding', ['id' => 'branding_on_off_radio_button', 'label' => esc_html__('Hide or show plugin branding', 'remove_pressable_branding_tab') ]);

}
add_action('admin_init', 'pressable_cache_management_register_settings');
