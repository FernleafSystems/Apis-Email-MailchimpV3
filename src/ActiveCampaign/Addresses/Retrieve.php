<?php

namespace FernleafSystems\ApiWrappers\Email\ActiveCampaign\Addresses;

/**
 * Class Retrieve
 * @package FernleafSystems\ApiWrappers\Email\ActiveCampaign\Addresses
 */
class Retrieve extends Base {

	const REQUEST_METHOD = 'get';

	/**
	 * @param string $sId
	 * @return AddressVO
	 */
	public function byId( $sId ) {
		$oVo = null;
		$this->setParam( 'id', $sId )->req();
		if ( $this->isLastRequestSuccess() ) {
			$oVo = $this->getVO()
						->applyFromArray( $this->getDecodedResponseBody()[ static::ENDPOINT_KEY ] );
		}
		return $oVo;
	}

	/**
	 * @return string
	 */
	protected function getUrlEndpoint() {
		return sprintf( '%s/%s', parent::getUrlEndpoint(), $this->getParam( 'id' ) );
	}
}