<?php // Pressable Cache Management - Settings Callbacks


// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {
	
	exit;
	
}


// callback: login section
function pressable_cache_management_callback_section_cache() {



 echo '<div><img width="300" height="50" src="' .  plugin_dir_url(__FILE__) . '/assets/img/pressable-logo.png' . '" > </div>';
	
	
	echo '<p>'. esc_html__('These settings enable you to manage cache on your Pressable site.', 'pressable_cache_management') .'</p>';
	
}




 // TODO: callback: CDN section - see settings-register to uncommnet the field
function pressable_cache_management_callback_section_cdn() {
	
	echo '<p>'. esc_html__('These settings enable you to manage your Pressable site CDN.', 'pressable_cache_management') .'</p>';
	
}



// Flush site cache 
function pressable_cache_management_callback_field_button( $args ) {

	$options = get_option( 'pressable_cache_management_options' );
	
	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';


   
		echo '</form>';

        echo ' <form method="post" >

         <span id="flush_cache_button">

             <input id="pressable_cache_management_options_'. $id .'" name="pressable_cache_management_options['. $id .']" type="submit" size="40" value="Flush Cache" class="button"><br/><br/><label for="pressable_cache_management_options_'. $id .'">'. $label .'</label>

         </span>

    </form>';


}

// }



// Callback: text field for Pressable API client ID
function pressable_cache_management_callback_field_site_id_text( $args ) {
	
	$options = get_option( 'pressable_cache_management_options');
	
	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';
	
	$value = isset( $options[$id] ) ? sanitize_text_field( $options[$id] ) : '';
	
	echo '<input required id="pressable_cache_management_options_'. $id .'" name="pressable_cache_management_options['. $id .']" type="text" size="40" value="'. $value .'"><br />';
	echo '<label for="pressable_cache_management_options_'. $id .'">'. $label .'</label>';
	
}



// Callback: text field for Pressable API client ID
function pressable_cache_management_callback_field_id_text( $args ) {
	
	$options = get_option( 'pressable_cache_management_options');
	
	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';
	
	$value = isset( $options[$id] ) ? sanitize_text_field( $options[$id] ) : '';
	
	echo '<input  id="pressable_cache_management_options_'. $id .'" name="pressable_cache_management_options['. $id .']" type="text" size="40" value="'. $value .'"><br />';
	echo '<label for="pressable_cache_management_options_'. $id .'">'. $label .'</label>';


	
}



// Callback: text field for Pressable API client ID
function pressable_cache_management_callback_field_secret_text( $args ) {
	
	$options = get_option( 'pressable_cache_management_options');
	
	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';
	
	$value = isset( $options[$id] ) ? sanitize_text_field( $options[$id] ) : '';
	
	echo '<input id="pressable_cache_management_options_'. $id .'" name="pressable_cache_management_options['. $id .']" type="text" size="40" value="'. $value .'"><br />';
	echo '<label for="pressable_cache_management_options_'. $id .'">'. $label .'</label>';
	
}


// Flush site cache on Theme/Plugin update checkbox
function pressable_cache_management_callback_field_plugin_theme_update_checkbox( $args ) {

	$options = get_option( 'pressable_cache_management_options' );
	
	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';
	
	$checked = isset( $options[$id] ) ? checked( $options[$id], 1, false ) : '';
	
	echo '<input id="pressable_cache_management_options_'. $id .'" name="pressable_cache_management_options['. $id .']" type="checkbox" value="1"'. $checked .'> ';
	echo '<label for="pressable_cache_management_options_'. $id .'">'. $label .'</label>';

}



// Flush site cache on page & post update checkbox
function pressable_cache_management_callback_field_page_edit_checkbox( $args ) {

	$options = get_option( 'pressable_cache_management_options' );
	
	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';

	
	$checked = isset( $options[$id] ) ? checked( $options[$id], 1, false ) : '';
	
	echo '<input id="pressable_cache_management_options_'. $id .'" name="pressable_cache_management_options['. $id .']" type="checkbox" value="1"'. $checked .'> ';
	echo '<label for="pressable_cache_management_options_'. $id .'">'. $label .'</label>';


}



// Flush site cache on page & post update checkbox
function pressable_cache_management_callback_field_extend_cache_checkbox( $args ) {

	$options = get_option( 'pressable_cache_management_options' );
	
	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';
	
	$checked = isset( $options[$id] ) ? checked( $options[$id], 1, false ) : '';
	
	echo '<input id="pressable_cache_management_options_'. $id .'" name="pressable_cache_management_options['. $id .']" type="checkbox" value="1"'. $checked .'> ';
	echo '<label for="pressable_cache_management_options_'. $id .'">'. $label .'</label>';

}


//CDN management

// Turn on/off CDN radio button


// radio field options
function pressable_cache_management_options_radio_button() {
	
	return array(
		
		'enable'  => esc_html__('Enable CDN', 'pressable_cache_management'),
		'disable' => esc_html__('Disable CDN', 'pressable_cache_management')
		
	);
	
}

function pressable_cache_management_callback_field_extend_cdn_radio_button( $args ) {
	
	$options = get_option( 'pressable_cache_management_options' );
	
	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';

	
	$selected_option = isset( $options[$id] ) ? sanitize_text_field( $options[$id] ) : '';
	
	$radio_options = pressable_cache_management_options_radio_button();
	
	foreach ( $radio_options as $value => $label ) {
		
		$checked = checked( $selected_option === $value, true, false );
		
		echo '<label><input name="pressable_cache_management_options['. $id .']" type="radio" value="'. $value .'"'. $checked .'> ';
		echo '<span>'. $label .'</span></label><br />';
		
	}
	
}

 function logo_image_callback() {
        printf(
            '<input type="text" name="vaajo_general[logo_image]" id="logo_image" value="%s"> <a href="#" id="logo_image_url" class="button" > Select </a>',
            isset( $this->options_general['logo_image'] ) ? esc_attr( $this->options_general['logo_image']) : ''
             );
    }







// Purge CDN cache 
function pressable_cdn_cache_flush_management_callback_field_button( $args ) {

	$options = get_option( 'pressable_cache_management_options' );
	
	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';


   
		echo '</form>';

        echo ' <form method="post" >

         <span id="purge_cdn_cache_button">

             <input id="pressable_cache_management_options_'. $id .'" name="pressable_cache_management_options['. $id .']" type="submit" size="40" value="Purge CDN" class="button"><br/><br/><label for="pressable_cache_management_options_'. $id .'">'. $label .'</label>

         </span>

    </form>';


}
