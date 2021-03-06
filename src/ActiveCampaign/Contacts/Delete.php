<?php

namespace FernleafSystems\ApiWrappers\Email\ActiveCampaign\Contacts;

/**
 * Class Delete
 * @package FernleafSystems\ApiWrappers\Email\ActiveCampaign\Contacts
 */
class Delete extends Base {

	const REQUEST_METHOD = 'delete';

	/**
	 * @param string $sEmail
	 * @return bool
	 */
	public function byEmail( $sEmail ) {
		$oContact = ( new Retrieve() )
			->setConnection( $this->getConnection() )
			->byEmail( $sEmail );
		return ( $oContact instanceof ContactVO ) ? $this->byId( $oContact->id ) : false;
	}

	/**
	 * @param string $sId
	 * @return bool
	 */
	public function byId( $sId ) {
		return $this->setParam( 'id', $sId )
					->req()
					->isLastRequestSuccess();
	}

	/**
	 * @return string
	 */
	protected function getUrlEndpoint() {
		return sprintf( '%s/%s', parent::getUrlEndpoint(), $this->getParam( 'id' ) );
	}
}