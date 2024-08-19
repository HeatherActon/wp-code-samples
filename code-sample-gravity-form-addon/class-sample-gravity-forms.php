<?php

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

GFForms::include_addon_framework();

class SampleGravityForms extends GFAddOn {

	protected $_version = SAMPLE_GRAVITY_FORMS_VERSION;
	protected $_min_gravityforms_version = '1.9';
	protected $_slug = 'code-sample-gravity-form-addon';
	protected $_path = 'code-sample-gravity-form-addon/code-sample-gravity-form-addon.php';
	protected $_full_path = __FILE__;
	protected $_title = 'Sample Gravity Forms Saleforce Marketing Cloud Connector';
	protected $_short_title = 'SAMPLE GF SFMC';

	private static $_instance = null;

	public static function get_instance() {

		if ( null === self::$_instance ) {
			self::$_instance = new self;
		}

		return self::$_instance;

	}

	/**
	 * Autoload the required libraries.
	 *
	 * @since  4.0
	 * @access public
	 *
	 * @uses GFAddOn::is_gravityforms_supported()
	 */
	public function pre_init() {

		parent::pre_init();

		if ( $this->is_gravityforms_supported() ) {

			if ( ! class_exists( 'Sample_Gravity_Forms' ) ) {
				require_once( 'app/Admin.php' );
				require_once( 'app/API.php' );
			}
		}
	}

	public function init() {

		parent::init();

		// Send to SFMC.
		add_action( 'gform_after_submission', array( new Sample_Gravity_Forms_API(), 'send_data' ), 99, 2 );

		// Add admin column to gravity forms entry list.
		add_filter( 'gform_entry_meta', array( new Sample_Gravity_Forms_Admin(), 'admin_column' ), 10, 2 );
	}

	public function log_debug( $message ) {
		return GFAddOn::log_debug( $message );
	}

	/**
	 * Configures plugin settings to enter SFMC client ID and client secret.
	 *
	 * @return array
	 */
	public function plugin_settings_fields() {

		return array(
			array(
				'title'  => esc_html__( 'Sample Salesforce Marketing Cloud Connection Settings', 'sample-gravity-forms' ),
				'fields' => array(
					array(
						'label'   => esc_html__( 'Authentication URL', 'sample-gravity-forms' ),
						'type'    => 'text',
						'name'    => 'sample_sfmc_auth_url',
						'tooltip' => false,
						'class'   => 'medium',
					),
					array(
						'label'   => esc_html__( 'Client ID', 'sample-gravity-forms' ),
						'type'    => 'text',
						'name'    => 'sample_sfmc_client_id',
						'tooltip' => false,
						'class'   => 'medium',
					),
					array(
						'label'      => esc_html__( 'Client Secret', 'sample-gravity-forms' ),
						'type'       => 'text',
						'input_type' => 'password',
						'name'       => 'sample_sfmc_client_secret',
						'tooltip'    => false,
						'class'      => 'medium',
					),

				),
			),
		);
	}

	/**
	 * Configures the settings which should be rendered on the Form Settings > Add-On tab.
	 *
	 * @return array
	 */
	public function form_settings_fields( $form ) {
		return array(
			array(
				'title'  => esc_html__( 'SAMPLE Salesforce Marketing Cloud Form Settings', 'kytg-gravity-forms' ),
				'fields' => array(
					array(
						'label'   => esc_html__( 'Enable Send to SFMC', 'kytg-gravity-forms' ),
						'type'    => 'checkbox',
						'name'    => 'sfmc_enabled',
						'tooltip' => false,
						'choices' => array(
							array(
								'label' => esc_html__( 'Enabled', 'kytg-gravity-forms' ),
								'name'  => 'sfmc_enabled',
							),
						),
					),
					array(
						'label'   => esc_html__( 'POST to URL', 'kytg-gravity-forms' ),
						'type'    => 'text',
						'name'    => 'sfmc_post_url',
						'tooltip' => esc_html__( 'Enter the URL to POST this form\'s entry data to. If the payload has changed, contact the developer to remap the fields.', 'kytg-gravity-forms' ),
						'class'   => 'medium',
					),
				),
			),
		);
	}
}