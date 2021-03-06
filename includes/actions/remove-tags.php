<?php

namespace AutomateWoo;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * @class Action_AgileCRM_Remove_Tags
 */
class Action_AgileCRM_Remove_Tags extends Action_AgileCRM_Abstract {


	function load_admin_details() {
		$this->title = __( 'Remove Tags From Contact', 'automatewoo-agilecrm');
	}


	function load_fields() {
		$this->add_contact_email_field();
		$this->add_tags_field();
	}


	function run() {
		$email = Clean::email( $this->get_option( 'email', true ) );
		$tags = $this->parse_tags_string( $this->get_option( 'tags', true ) );

		if ( empty( $tags ) || empty( $email ) || ! AW_AgileCRM()->api() )
			return;

		$contact_id = AW_AgileCRM()->api()->get_contact_id_by_email( $email );

		if ( $contact_id ) {
			// add tags
			$response = AW_AgileCRM()->api()->request( 'PUT', '/contacts/delete/tags', [
				'id' => $contact_id,
				"tags" => $tags
			]);
		}

	}

}
