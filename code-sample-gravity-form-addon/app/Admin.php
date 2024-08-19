<?php

class Sample_Gravity_Forms_Admin extends SampleGravityForms {

	// Show column in entries about this, so we can troubleshoot if need be.
	public function admin_column( $entry_meta, $form_id ) {

		$entry_meta['sent_to_sfmc'] = array(
			'label'             => 'Sent to Salesforce Marketing Cloud',
			'is_numeric'        => false,
			'is_default_column' => true,
			'filter'            => array(
				'key'       => 'sent_to_sfmc',
				'text'      => 'success',
				'operators' => array(
					'is',
					'isnot',
				)
			),
		);

		return $entry_meta;
	}
}