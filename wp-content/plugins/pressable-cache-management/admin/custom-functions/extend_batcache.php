<?php // Custom function - Extend Batcache in wp-config.php

// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

    
 

 $options = get_option( 'pressable_cache_management_options');
    
    if ( isset( $options['extend_batcache_checkbox'] ) && ! empty( $options['extend_batcache_checkbox'] ) ) {
        
  // echo "checked";


  function wp_config_put( $slash = '' ) {
    $config = file_get_contents (ABSPATH . "test-wp-config.php");
    $config = preg_replace ("/^([\r\n\t ]*)(\<\?)(php)?/i", "<?php define('TARHE_CACHE', true);", $config);
    file_put_contents (ABSPATH . $slash . "test-wp-config.php", $config);
}

if ( file_exists (ABSPATH . "test-wp-config.php") && is_writable (ABSPATH . "test-wp-config.php") ){
    wp_config_put();
}
else if (file_exists (dirname (ABSPATH) . "/test-wp-config.php") && is_writable (dirname (ABSPATH) . "/test-wp-config.php")){
    wp_config_put('/');
}
else { 
    print_r('Error adding');
}

        
    } 

else {
    // echo 'BOX is Unchecked :(';


function wp_config_delete( $slash = '' ) {
    $config = file_get_contents (ABSPATH . "wp-config.php");
    $config = preg_replace ("/( ?)(define)( ?)(\()( ?)(['\"])WP_CACHE(['\"])( ?)(,)( ?)(0|1|true|false)( ?)(\))( ?);/i", "", $config);
    file_put_contents (ABSPATH . $slash . "wp-config.php", $config);
}

if (file_exists (ABSPATH . "wp-config.php") && is_writable (ABSPATH . "wp-config.php")) {
    wp_config_delete();
}
else if (file_exists (dirname (ABSPATH) . "/wp-config.php") && is_writable (dirname (ABSPATH) . "/wp-config.php")) {
    wp_config_delete('/');
}
else if (file_exists (ABSPATH . "wp-config.php") && !is_writable (ABSPATH . "wp-config.php")) {
    add_warning('Error removing');
}
else if (file_exists (dirname (ABSPATH) . "/wp-config.php") && !is_writable (dirname (ABSPATH) . "/wp-config.php")) {
    add_warning('Error removing');
}
else {
    add_warning('Error removing');
}


}
    


