<?php // Pressable Cache Management - Custom function to turn on/off CDN


	//*********Activate CDN Option*********
		/******************************/


$cdn = false;


//Check if radion button is enabled before activating the CDN
$options = get_option( 'pressable_cache_management_options');
	
	if ( isset( $options['cdn_on_off_radio_button'] ) && ! empty( $options['cdn_on_off_radio_button'] ) ) {
		
		$cdn = sanitize_text_field( $options['cdn_on_off_radio_button'] );

	}

	 //Set radion button state to defualt 
	if ( 'enable' === $cdn) {


		 //Defining client id client secret and site id
		$client_id = $options['api_client_id'];
		$client_secret = $options['api_client_secret'];
		$pressable_site_id = $options['pressable_site_id'];


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
		// if(!$results){die("Connection Failure");}
		curl_close($curl);

		//Display admin notice error messsage if connection unsuccessful
		if(!$results){

		function pressable_api_admin_notice_connection_failure() {
	   	//Check for current user to display  admin notice message to only
		if (  current_user_can( 'manage_options' ) ) {
				 
			$user    = $GLOBALS['current_user'];
		    $class = 'notice notice-error';
		    $message = __( 'Connection failure try again :( ', 'sample-text-domain' );
		 
		    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
		}
			}
		add_action( 'admin_notices', 'pressable_api_admin_notice_connection_failure' );


		} 
		
		//Define index for error message in the array
		$key = array( "error_description" => "error_description");

		$results = json_decode($results, true);


		foreach ((array)$results as $key => $result) {}

		 //Get error message from api response if there are any
		if ($key == "error_description" ){
			
		/**Delete option from the database if the connection is not successfully
		used by admin notice to display and remove notice**/
		delete_option( 'pressable_api_admin_notice__status', 'activated' );

		//Display admin notice if client ID or Client secret is incorrect				
		function incorrect_id_admin_notice_success() {
		    // Check for current user to display  admin notice message to only
			if (  current_user_can( 'manage_options' ) ) {
				 
			$user    = $GLOBALS['current_user'];
		    $class = 'notice notice-error';
		    $message = __( 'Client ID or Client Secret Incorrect.', 'sample-text-domain' );


		// **Delete CDN enable option from the database if the connection is 
	   	// not successful. This is used by admin notice to display and remove notice**/
		  delete_option( 'pressable_api_enable_cdn_connection_admin_notice', 'activated' );
		  printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );

		}
			}

		add_action( 'admin_notices', 'incorrect_id_admin_notice_success' );


		} else {

		    //Display admin notice only once if connection to Pressable API is successful
			function pressable_api_admin_notice__render_notice( $message = '', $classes = 'notice-success' ) {

			if ( ! empty( $message ) ) {
				printf( '<div class="notice %2$s">%1$s</div>', $message, $classes );
			}
		}

		function pressable_api_connection_admin_notice() {

			$pressable_api_display_notice = get_option( 'pressable_api_admin_notice__status', 'activating' );

			if ( 'activating' === $pressable_api_display_notice && current_user_can( 'manage_options' ) ) {

				add_action( 'admin_notices', function() {
		 
					$user    = $GLOBALS['current_user'];
					$message = sprintf( '<p>Authentication Successful :)</p>', $user->display_name );

					pressable_api_admin_notice__render_notice( $message, 'notice notice-success is-dismissible' );
				} );

				update_option( 'pressable_api_admin_notice__status', 'activated' );
			}
		}
		add_action( 'init', 'pressable_api_connection_admin_notice' );}
	
	//Check if connection was successfuly
	if (!isset($results["access_token"])) {

		//Declearing index variable for access_token
		$results = array( "access_token" => "invalid_token");

	} 


	$token = $results["access_token"];
	$pressable_b_token = 'Authorization: Bearer ';
	$p_api_slug = "https://my.pressable.com/v1/sites/";
	$pressable_site_id = $options['pressable_site_id'];
	$p_cdn_api = "/cdn";


	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => $p_api_slug . $pressable_site_id . $p_cdn_api,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_HTTPHEADER => array(
	    $pressable_b_token  . $token,     
	    "cache-control: no-cache"
	  ),
	));
	 
	$response = curl_exec($curl);
	$err = curl_error($curl);
	 
	curl_close($curl);


	//Convert request reponse to json object
	$pressable_api_query_response = json_decode($response);
	
		
	if (isset($pressable_api_query_response->message)) {
		
	

     	//Display admin notice only once if connection to Pressable API is successful
		function pressable_api_connection_success_notice( $message = '', $classes = 'notice-success' ) {

			if ( ! empty( $message ) ) {
				printf( '<div class="notice %2$s">%1$s</div>', $message, $classes );
			}
		}

		function pressable_api_enable_cdn_connection_admin_notice() {

			$pressable_api_display_notice = get_option( 'pressable_api_enable_cdn_connection_admin_notice', 'activating' );

			if ( 'activating' === $pressable_api_display_notice && current_user_can( 'manage_options' ) ) {

				add_action( 'admin_notices', function() {
		 
					$user    = $GLOBALS['current_user'];
					$message = sprintf( '<p>CDN Enabled Successfully.</p>', $user->display_name );

					pressable_api_connection_success_notice( $message, 'notice notice-success is-dismissible' );
				} );

				update_option( 'pressable_api_enable_cdn_connection_admin_notice', 'activated' );
				/**Delete option from the database if the connection deactivated
				used by admin notice to display and remove notice**/
				delete_option( 'pressable_cdn_connection_decactivated_notice', 'deactivated' );
			}
		}
		add_action( 'init', 'pressable_api_enable_cdn_connection_admin_notice' );


	
	

	//Check response if 404 error is found for site id
	} elseif ($pressable_api_query_response->status == "404")  {


	//Display error message if site ID not found
    function pressable_site_id_notice__error() {

     $screen = get_current_screen();
 
    //Display admin notice for this plugn page only
    if ( $screen->id !== 'toplevel_page_pressable_cache_management') return;
	    // Check for current user to display  admin notice message to only
			if (  current_user_can( 'manage_options' ) ) {
				 
	$user    = $GLOBALS['current_user'];
    $class = 'notice notice-error';
    $message = __( 'Pressable Site ID Incorrect.', 'sample-text-domain' );
 
    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 

		}

	}

	add_action( 'admin_notices', 'pressable_site_id_notice__error' );

	}
	

	//*********Deactivate CDN Option*********
		/******************************/

		
} else {


  $cdn = false;


//Check if radio button is deactivated before deactivating the CDN
$options = get_option( 'pressable_cache_management_options');
	
	if ( isset( $options['cdn_on_off_radio_button'] ) && ! empty( $options['cdn_on_off_radio_button'] ) ) {
		
		$cdn = sanitize_text_field( $options['cdn_on_off_radio_button'] );

	}

	if ( 'disable' === $cdn ) {
		
 
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
		//If the query fails display admin notice error messsage
		if(!$results){

		function pressable_api_admin_notice__connection_failure() {
	    // Check for current user to display  admin notice message to only
			if (  current_user_can( 'manage_options' ) ) {
				 
			$user    = $GLOBALS['current_user'];
		    $class = 'notice notice-error';
		    $message = __( 'Connection failure try again :( ', 'sample-text-domain' );
		 
		    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
		}
			}
		add_action( 'admin_notices', 'pressable_api_admin_notice__connection_failure' );
} 

		//Define index for error messahe in the array
		$key = array( "error_description" => "error_description");

		$results = json_decode($results, true);
	
		foreach ((array)$results as $key => $result) {

		}

		

		 //Get error message from api response if there are any
		if ($key == "error_description") {
			
		/**Delete option from the database if the connection is not successfully
		used by admin notice to display and remove notice**/
		delete_option( 'pressable_api_admin_notice__status', 'activated' );


		//Display admin notice if client ID or Client secret is incorrect				
		function incorrect_id_admin_notice_error() {
			// Check for current user to display  admin notice message to only
			if (  current_user_can( 'manage_options' ) ) {
				 
			$user    = $GLOBALS['current_user'];

		    $class = 'notice notice-error';
		    $message = __( 'Client ID or Client Secret Incorrect.', 'sample-text-domain' );
		 
		    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
		}
			}
			add_action( 'admin_notices', 'incorrect_id_admin_notice_error' );


		} else {

		    //Display admin notice only once if connection to Pressable API is successful
			function pressable_api_admin_notice__render_notice( $message = '', $classes = 'notice-success' ) {

			if ( ! empty( $message ) ) {
				printf( '<div class="notice %2$s">%1$s</div>', $message, $classes );
			}
		}

		function pressable_api_connection_admin_notice() {

			$pressable_api_display_notice = get_option( 'pressable_api_admin_notice__status', 'activating' );

			if ( 'activating' === $pressable_api_display_notice && current_user_can( 'manage_options' ) ) {

				add_action( 'admin_notices', function() {
		 
					$user    = $GLOBALS['current_user'];
					$message = sprintf( '<p>Authentication Successful :)</p>', $user->display_name );

					pressable_api_admin_notice__render_notice( $message, 'notice notice-success is-dismissible' );
				} );

				update_option( 'pressable_api_admin_notice__status', 'activated' );
			}
		}
		add_action( 'init', 'pressable_api_connection_admin_notice' );}
	
	//Check if connection was successfuly
	if (!isset($results["access_token"])) {

		//Declearing index variable for access_token
		$results = array( "access_token" => "invalid_token");

	} 


	$token = $results["access_token"];
	$pressable_b_token = 'Authorization: Bearer ';
	$p_api_slug = "https://my.pressable.com/v1/sites/";
	$pressable_site_id = $options['pressable_site_id'];
	$p_cdn_api = "/cdn";


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


	//Convert request reponse to json object
	$pressable_api_query_response = json_decode($response, true);


	//Check array if CDN is deactivated 
	if (in_array(false, $pressable_api_query_response)) {

	//Display admin notice only once if connection to Pressable API is successful
	function pressable_cdn_deactivate_admin_notice( $message = '', $classes = 'notice-success' ) {

			if ( ! empty( $message ) ) {
				printf( '<div class="notice %2$s">%1$s</div>', $message, $classes );
			}
		}

		function pressable_api_deactivate_cdn_connection_admin_notice() {


		$pressable_cdn_deactivate_display_notice = get_option( 'pressable_cdn_connection_decactivated_notice', 'deactivated' );

		if ( 'deactivated' === $pressable_cdn_deactivate_display_notice && current_user_can( 'manage_options' ) ) {

				add_action( 'admin_notices', function() {
		 
					$user    = $GLOBALS['current_user'];
					$message = sprintf( '<p>CDN Deactivated - It is always recommened to turn on your CDN for best caching expereince.</p>', $user->display_name );

					pressable_api_admin_notice__render_notice( $message, 'notice notice-info is-dismissible' );
				} );

					update_option( 'pressable_cdn_connection_decactivated_notice', 'deactivated' );
					/**Delete update cdn option from the database if the connection is deactivated
					used by admin notice to display and remove admin notice**/
					delete_option( 'pressable_api_enable_cdn_connection_admin_notice', 'activated' );
			}
		}
		add_action( 'init', 'pressable_api_deactivate_cdn_connection_admin_notice' );



	$pressable_api_query_response = json_decode($response, true);


		//Check response if 404 error is found for site id
		} elseif (in_array("404", $pressable_api_query_response)) {

		  		

	//If is not set define index variable to prevent error then terminate
	$pressable_api_query_response = array( "status" => "Not Found");
            



    function pressable_site_id_notice__error() {

     $screen = get_current_screen();
 
    //Display admin notice for this plugn page only
    if ( $screen->id !== 'toplevel_page_pressable_cache_management') return;
	    // Check for current user to display  admin notice message to only
			if (  current_user_can( 'manage_options' ) ) {
				 
	$user    = $GLOBALS['current_user'];
    $class = 'notice notice-error';
    $message = __( 'Pressable Site ID Incorrect.', 'sample-text-domain' );
    //update_option( 'pressable_incorrect_site_id', 'activated' );
 
    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
}}
	add_action( 'admin_notices', 'pressable_site_id_notice__error' );

			
		}
	}
}


