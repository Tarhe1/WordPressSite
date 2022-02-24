<?php // Pressable Cache Management - Purge CDN Cache

$results = array( "access_token" => "invalid_token");

//Check if post is initiated to prevent form submit on page reload
if( !empty($_POST) ){

//define index variable for access token to prevent undefined token error 	
//$results = array( "access_token" => "invalid_token"); 


// Flush cache button
function pressable_cdn_purge__button() {

$options = get_option( 'pressable_cache_management_options');
	
 		//Defining client id and client secret
		$client_id = $options['api_client_id'];
		$client_secret = $options['api_client_secret'];


		//query the api to auto generate bearer token
		$curl = curl_init();
		$auth_data = array(
		  'client_id'     => $client_id,
		  'client_secret'   => $client_secret,
		  'grant_type'    => 'client_credentials'
		);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $auth_data);
		curl_setopt($curl, CURLOPT_URL, 'https://my.pressable.com/auth/token');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		$results = curl_exec($curl);

		curl_close($curl);


		//Convert array to json format
		$results = json_decode($results);


	if (!isset($results->access_token)) {
 
			
			//If is not set define index variable to prevent error then terminate
			$results = array( "access_token" => "invalid_token");
            echo 'Unable to purge CDN plugin not connected to MyPressable';

			return;

		} 

		//return access token from the json object
 		$results = $results->access_token;


		$token = $results;
		$pressable_b_token = 'Authorization: Bearer ';
		$p_api_slug = "https://my.pressable.com/v1/sites/";
		$pressable_site_id = $options['pressable_site_id'];
		$p_cdn_api = "/cache";


		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_URL => $p_api_slug . $pressable_site_id . $p_cdn_api,
	    CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "DELETE",
		CURLOPT_HTTPHEADER => array(
		$pressable_b_token  . $token,     
		    "cache-control: no-cache"
		  ),
		));
		 
		$response = curl_exec($curl);
		$err = curl_error($curl);
		 
		curl_close($curl);
   

}
add_action( 'wp_before_admin_bar_render', 'pressable_cdn_purge__button', 999 );


//Success message on flush cache button click
function pressable_cdn_purge_cache_notice_success() {?>

    <div class="notice notice-success is-dismissible">
        <p><?php _e( 'CDN Purged', 'sample-text-domain' ); ?></p>
    </div>
    <?php
    // update_option( 'pressable_api_cache', 'activated' );
}
add_action( 'admin_notices', 'pressable_cdn_purge_cache_notice_success' );

}




