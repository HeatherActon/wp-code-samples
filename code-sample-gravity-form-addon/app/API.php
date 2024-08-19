<?php
class Sample_Gravity_Forms_API extends SampleGravityForms {

	public function __construct() {
		$this->headers           = array(
			'Content-Type' => 'application/json'
		);
		$this->authorization_url = $this->get_auth_url();
		$this->client_id         = $this->get_client_id();
		$this->client_secret     = $this->get_client_secret();
	}

	protected function get_auth_url() {

		$auth_url = $this->get_plugin_setting( 'sample_sfmc_auth_url' );

		return $auth_url;
	}

	protected function get_client_id() {

		$client_id = $this->get_plugin_setting( 'sample_sfmc_client_id' );

		return $client_id;
	}

	protected function get_client_secret() {

		$client_secret = $this->get_plugin_setting( 'sample_sfmc_client_secret' );

		return $client_secret;
	}

	public function send_data( $entry, $form ) {

		$form_id = rgar( $form, 'id' );

		// If this form doesn't have the SFMC send enabled, bail.
		$form_settings = $this->get_form_settings( $form );

		// If this form doesn't have the SFMC send enabled, bail.
		if ( '1' !== $form_settings['sfmc_enabled'] ) {
			$this->log_debug( 'sfmc send not enabled on form ID ' . print_r( $form_id, true ) );
			return;
		}

		// If this form doesn't have the SFMC POST URL entered, bail.
		$post_url = '';
		if ( ! array_key_exists( 'sfmc_post_url', $form_settings ) || '' === $form_settings['sfmc_post_url'] ) {
			$this->log_debug( 'sfmc POST URL not entered on form ID ' . print_r( $form_id, true ) );
			gform_update_meta( $entry['id'], 'sent_to_sfmc', 'failure | POST URL not filled in' );
			return;
		}
		else {
			$post_url = $form_settings['sfmc_post_url'];
		}

		$id_token = get_transient( 'sample_sfmc_bearer_token' );
		$this->log_debug( 'token from transient ' . print_r( $id_token, true ) );

		if ( false === $id_token ) {

			$id_token = $this->authenticate();
			$this->log_debug( 'token from transient was expired, got a new one ' . print_r( $id_token, true ) );
		}

		if ( ! $id_token || is_wp_error( $id_token ) ) {

			$this->log_debug( 'gform_sfmc_api_send: could not get bearer token' );
			gform_update_meta( $entry['id'], 'sent_to_sfmc', 'failure | bearer token' );
			return new \WP_Error( 'sample-gravity-forms', "could not get bearer token" );
		}

		$headers = array_merge( $this->headers, array(
			'Authorization' => 'Bearer ' . $id_token,
		) );

		$payload = array();
		// Subscribe form.
		if ( 1 === $form_id ) {

			$payload = array(
				"items" => array(
					array(
						"FirstName"  => rgar( $entry, '16' ),
						"LastName"   => rgar( $entry, '17' ),
						"Email"      => rgar( $entry, '20' ),
						"Gender"     => rgar( $entry, '23' ),
						"DOB"        => rgar( $entry, '22' ),
						"Interested" => rgar( $entry, '18' ),
						"SourceURL"  => rgar( $entry, '24' )
					)
				)
			);

		}
		// Subscribe form on home.
		elseif ( 2 === $form_id ) {
			$payload = array(
				"items" => array(
					array(
						"FirstName"  => rgar( $entry, '32' ),
						"LastName"   => rgar( $entry, '33' ),
						"Email"      => rgar( $entry, '28' ),
						"Gender"     => rgar( $entry, '26' ),
						"DOB"        => rgar( $entry, '25' ),
						"Interested" => rgar( $entry, '23' ),
						"SourceURL"  => rgar( $entry, '31' )
					)
				)
			);
		}
		// Order form.
		elseif ( 3 === $form_id ) {

			$patient_guide       = rgar( $entry, '1.1' ) ? '1' : '';
			$fcs_carebook        = rgar( $entry, '1.2' ) ? '1' : '';
			$fcs_toolkit         = rgar( $entry, '1.3' ) ? '1' : '';
			$fcs_genetic_testing = rgar( $entry, '1.4' ) ? '1' : '';

			$payload = array(
				"items" => array(
					array(
						"FirstName"             => rgar( $entry, '3' ),
						"LastName"              => rgar( $entry, '4' ),
						"Email"                 => rgar( $entry, '5' ),
						"Gender"                => rgar( $entry, '14' ),
						"DOB"                   => rgar( $entry, '13' ),
						"Patient_Guide_To_FCS"  => $patient_guide,
						"FCS_Carebook"          => $fcs_carebook,
						"FCS_Nutrition_Toolkit" => $fcs_toolkit,
						"FCS_Genetic_Testing"   => $fcs_genetic_testing,
						"Address1"              => rgar( $entry, '6' ),
						"Address2"              => rgar( $entry, '7' ),
						"City"                  => rgar( $entry, '8' ),
						"State"                 => rgar( $entry, '15' ),
						"Zip_Code"              => rgar( $entry, '10' ),
						"Interested"            => rgar( $entry, '11' ),
						"SourceURL"             => rgar( $entry, '16' ),
					)
				)
			);
		}
		// Quiz.
		elseif ( 4 === $form_id ) {

			$Triglyceride_Level_Above880mgDL          = rgar( $entry, '1' );
			$Triglyceride_Level_Above880mgDL_Occasion = rgar( $entry, '4' );
			$Abdominal_Pain                           = rgar( $entry, '5' );
			$Triglyceride_Level_WithOut_Other_Cause   = rgar( $entry, '8' );
			$Pancreatitis                             = rgar( $entry, '10' );
			$Which_Best_Describes_You                 = rgar( $entry, '16' );

			$payload = array(
				"items" => array(
					array(
						"FirstName"                                => rgar( $entry, '13' ),
						"LastName"                                 => rgar( $entry, '14' ),
						"Email"                                    => rgar( $entry, '15' ),
						"Triglyceride_Level_Above880mgDL"          => $Triglyceride_Level_Above880mgDL,
						"Triglyceride_Level_Above880mgDL_Occasion" => $Triglyceride_Level_Above880mgDL_Occasion,
						"Abdominal_Pain"                           => $Abdominal_Pain,
						"Triglyceride_Level_WithOut_Other_Cause"   => $Triglyceride_Level_WithOut_Other_Cause,
						"Pancreatitis"                             => $Pancreatitis,
						"Which_Best_Describes_You"                 => $Which_Best_Describes_You,
					)
				)
			);
		}

		$this->log_debug( 'gform_sfmc_api_send: body => ' . print_r( $payload, true ) );

		if ( '' === $payload ) {
			$this->log_debug( 'gform_sfmc_api_send: no payload found' );
			gform_update_meta( $entry['id'], 'sent_to_sfmc', 'failure | no payload' );
			return;
		}

		$request_args = array(
			'headers' => $headers,
			'body'    => wp_json_encode( $payload ),
		);

		$response = wp_remote_post( $post_url, $request_args );
		$this->log_debug( 'gform_sfmc_api_send: response => ' . print_r( $response, true ) );

		$response_code = (int) wp_remote_retrieve_response_code( $response );
		$response_body = wp_remote_retrieve_body( $response );
		if ( $response instanceof \WP_Error ) {

			$this->log_debug( 'gform_sfmc_api_send: response => ' . print_r( $response->get_error_message(), true ) );
			gform_update_meta( $entry['id'], 'sent_to_sfmc', 'failure | response error' );
			return new \WP_Error( 'sample-gravity-forms', "{$response_body}" );
		}
		elseif ( $response_code > 202 ) {

			$this->log_debug( 'gform_sfmc_api_send: response code => ' . print_r( $response_code, true ) );
			gform_update_meta( $entry['id'], 'sent_to_sfmc', 'failure | response code' );
			return new \WP_Error( 'sample-gravity-forms', "{$response_code}" );

		}
		elseif ( $response_code === 202 ) {

			// Update entry meta about this success.
			gform_update_meta( $entry['id'], 'sent_to_sfmc', 'success' );
		}

	}

	private function authenticate() {

		$payload = array(
			"grant_type"    => "client_credentials",
			"client_id"     => "$this->client_id",
			"client_secret" => "$this->client_secret"
		);

		$request_args = array(
			'headers' => $this->headers,
			'body'    => wp_json_encode( $payload ),
		);

		$response = wp_remote_post( $this->authorization_url, $request_args );

		if ( ! is_wp_error( $response ) ) {

			$response_code = (int) wp_remote_retrieve_response_code( $response );

			if ( 200 === $response_code ) {

				$response_body = json_decode( wp_remote_retrieve_body( $response ) );
				$bearer_token  = $response_body->access_token;
				$transient     = 'sample_sfmc_bearer_token';
				$value         = $bearer_token;
				$expiration    = $response_body->expires_in;

				set_transient( $transient, $value, $expiration );

				return $bearer_token;
			}
		}
	}
}