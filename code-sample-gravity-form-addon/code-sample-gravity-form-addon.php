<?php
/*
Plugin Name: Code Sample Gravity Form Add-on
Plugin URI:
Description: Handles connection between Gravity Forms and Salesforce Marketing Cloud API.
Version: 1.0.0
Author:
Author URI:
*/
defined( 'ABSPATH' ) or die;

define( 'SAMPLE_GRAVITY_FORMS_VERSION', '1.0.0' );

// If Gravity Forms is loaded, bootstrap the Add-On.
add_action( 'gform_loaded', array( 'Sample_Gravity_Forms_Bootstrap', 'load' ), 5 );

/**
 * Class Sample_Gravity_Forms_Bootstrap
 *
 * Handles the loading of the Add-On and registers with the Add-On Framework.
 */
class Sample_Gravity_Forms_Bootstrap {

	/**
	 * If the Add-On Framework exists, Add-On is loaded.
	 *
	 * @access public
	 * @static
	 */
	public static function load() {

		if ( ! method_exists( 'GFForms', 'include_addon_framework' ) ) {
			return;
		}

		require_once( 'class-sample-gravity-forms.php' );

		GFAddOn::register( 'SampleGravityForms' );
	}
}

/**
 * Returns an instance of the SAMPLEGravityForms class
 *
 * @see    SAMPLEGravityForms::get_instance()
 *
 * @return SAMPLEGravityForms
 */
function sample_gravity_forms() {
	return SampleGravityForms::get_instance();
}