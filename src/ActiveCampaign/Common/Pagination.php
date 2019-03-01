<?php

namespace FernleafSystems\ApiWrappers\Email\ActiveCampaign\Common;

use FernleafSystems\ApiWrappers\Base\BaseVO;

/**
 * Trait Pagination
 * @package FernleafSystems\ApiWrappers\Email\ActiveCampaign\Common
 */
trait Pagination {

	/**
	 * @var int
	 */
	private $nCurrentPage;

	/**
	 * @var int
	 */
	private $nPerPage;

	/**
	 * @return BaseVO[]|mixed
	 */
	protected function runPagedQuery() {
		$aAllTags = [];

		$this->setPaginationPage( 1 );
		do {
			$aTags = null;
			$this->req();
			if ( $this->isLastRequestSuccess() ) {
				$aTags = $this->getDecodedResponseBody()[ $this->getResponseDataKey() ];
				$aAllTags = array_merge(
					$aAllTags,
					array_map(
						function ( $aData ) {
							/** @var BaseVO $oVO */
							$oVO = $this->getVO();
							return $oVO->applyFromArray( $aData );
						},
						$aTags
					)
				);
			}
			$this->incrementPage();

		} while ( !empty( $aTags ) );

		return $aAllTags;
	}

	/**
	 * Overrides the BaseAPI to insert page info. Remember to increment the page after the request
	 * @return array
	 */
	public function getRequestQueryData() {
		$aData = parent::getRequestQueryData();
		$aData[ 'limit' ] = $this->getPageLimit();
		$aData[ 'offset' ] = $this->getPageOffset();
		return $aData;
	}

	/**
	 * @return int
	 */
	public function getPageLimit() {
		return is_numeric( $this->nPerPage ) ? min( 100, abs( $this->nPerPage ) ) : 100;
	}

	/**
	 * @return int
	 */
	public function getPageOffset() {
		return $this->getPageLimit()*max( ( $this->getCurrentPage() - 1 ), 0 );
	}

	/**
	 * @return int
	 */
	public function getCurrentPage() {
		return is_numeric( $this->nCurrentPage ) ? abs( $this->nCurrentPage ) : 1;
	}

	/**
	 * @return string
	 */
	abstract protected function getResponseDataKey();

	/**
	 * @param int $nIncrement
	 * @return $this
	 */
	public function incrementPage( $nIncrement = 1 ) {
		return $this->setPaginationPage( $this->getCurrentPage() + $nIncrement );
	}

	/**
	 * @param int $nPage
	 * @return $this
	 */
	public function setPaginationPage( $nPage ) {
		$this->nCurrentPage = max( $nPage, 1 );
		return $this;
	}

	/**
	 * @param int $nLimit
	 * @return $this
	 */
	public function setPaginationPerPage( $nLimit ) {
		$this->nPerPage = $nLimit;
		return $this;
	}
}