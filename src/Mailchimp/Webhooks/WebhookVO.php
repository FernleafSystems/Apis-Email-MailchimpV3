<?php

namespace FernleafSystems\Apis\Email\Mailchimp\Webhooks;

/**
 * Class WebhookVO
 * @package FernleafSystems\Apis\Email\Mailchimp\Webhooks
 */
class WebhookVO extends \FernleafSystems\Apis\Email\Common\Webhooks\WebhookVO {

	/**
	 * @return string
	 */
	public function getEventType() {
		return $this->getStringParam( 'type' );
	}

	/**
	 * @return string
	 */
	public function getListId() {
		return $this->getSubscriberData()[ 'list_id' ];
	}

	/**
	 * @return array
	 */
	public function getSubscriberCustomFields() { // MERGE FIELD
		return $this->getSubscriberData()[ 'merges' ];
	}

	/**
	 * @alias
	 * @return array
	 */
	public function getSubscriberData() {
		return $this->getWebhookData();
	}

	/**
	 * @return string
	 */
	public function getSubscriberEmail() {
		return $this->getSubscriberData()[ 'email' ];
	}

	/**
	 * @return string
	 */
	public function getSubscriberId() {
		return $this->getSubscriberData()[ 'id' ];
	}

	/**
	 * @return array
	 */
	public function getWebhookData() {
		return $this->getArrayParam( 'data' );
	}

	/**
	 * @return bool
	 */
	public function isEventUserSubscribe() {
		return ( $this->getEventType() == 'subscribe' );
	}
}