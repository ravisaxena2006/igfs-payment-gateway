<?php

require_once("IGFS_CG_API/BaseIgfsCg.php");

abstract class BaseIgfsCgTran extends BaseIgfsCg {

	public $shopID; // chiave messaggio

	public $tranID;

	function __construct() {
		parent::__construct();
	}

	protected function resetFields() {
		parent::resetFields();
		$this->shopID = NULL;

		$this->tranID = NULL;
	}

	protected function checkFields() {
		parent::checkFields();
		if ($this->shopID == NULL || "" == $this->shopID)
			throw new IgfsMissingParException("Missing shopID");
	}

	protected function buildRequest() {
		$request = parent::buildRequest();
		$request = $this->replaceRequest($request, "{shopID}", $this->shopID);
		return $request;
	}

	protected function getServicePort() {
		return "PaymentTranGatewayPort";
	}

	protected function parseResponseMap($response) {
		parent::parseResponseMap($response);
		// Opzionale
		$this->tranID = IgfsUtils::getValue($response, "tranID");
	}

}

?>
