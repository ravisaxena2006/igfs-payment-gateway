<?php

require_once("IGFS_CG_API/tran/BaseIgfsCgTran.php");

class IgfsCgVoidAuth extends BaseIgfsCgTran {

	public $amount;
	public $refTranID;

	public $addInfo1;
	public $addInfo2;
	public $addInfo3;
	public $addInfo4;
	public $addInfo5;

	function __construct() {
		parent::__construct();
	}

	protected function resetFields() {
		parent::resetFields();
		$this->amount = NULL;
		$this->refTranID = NULL;

		$this->addInfo1 = NULL;
		$this->addInfo2 = NULL;
		$this->addInfo3 = NULL;
		$this->addInfo4 = NULL;
		$this->addInfo5 = NULL;
	}

	protected function checkFields() {
		parent::checkFields();
		if ($this->amount == NULL)
			throw new IgfsMissingParException("Missing amount");

		if ($this->refTranID == NULL)
			throw new IgfsMissingParException("Missing refTranID");
	}

	protected function buildRequest() {
		$request = parent::buildRequest();
		$request = $this->replaceRequest($request, "{amount}", $this->amount);
		$request = $this->replaceRequest($request, "{refTranID}", $this->refTranID);

		return $request;
	}

	protected function setRequestSignature($request) {
		// signature dove il buffer e' cosi composto APIVERSION|TID|SHOPID|AMOUNT|REFORDERID
		$fields = array(
				$this->getVersion(), // APIVERSION
				$this->tid, // TID
				$this->shopID, // SHOPID
				$this->amount, // AMOUNT
				$this->refTranID); // REFORDERID
		$signature = $this->getSignature($this->kSig, // KSIGN
				$fields); 
		$request = $this->replaceRequest($request, "{signature}", $signature);
		return $request;
	}

	protected function getSoapResponseName() {
		return "ns1:VoidAuthResponse";
	}

	protected function parseResponseMap($response) {
		parent::parseResponseMap($response);
		// Opzionale
		$this->addInfo1 = IgfsUtils::getValue($response, "addInfo1");
		// Opzionale
		$this->addInfo2 = IgfsUtils::getValue($response, "addInfo2");
		// Opzionale
		$this->addInfo3 = IgfsUtils::getValue($response, "addInfo3");
		// Opzionale
		$this->addInfo4 = IgfsUtils::getValue($response, "addInfo4");
		// Opzionale
		$this->addInfo5 = IgfsUtils::getValue($response, "addInfo5");
	}

	protected function getResponseSignature($response) {
		$fields = array(
				IgfsUtils::getValue($response, "tid"), // TID
				IgfsUtils::getValue($response, "shopID"), // SHOPID
				IgfsUtils::getValue($response, "rc"), // RC
				IgfsUtils::getValue($response, "errorDesc"),// ERRORDESC
				IgfsUtils::getValue($response, "tranID"), // ORDERID
				IgfsUtils::getValue($response, "date"), // TRANDATE
				IgfsUtils::getValue($response, "addInfo1"), // UDF1
				IgfsUtils::getValue($response, "addInfo2"), // UDF2
				IgfsUtils::getValue($response, "addInfo3"), // UDF3
				IgfsUtils::getValue($response, "addInfo4"), // UDF4
				IgfsUtils::getValue($response, "addInfo5"));// UDF5
		// signature dove il buffer e' cosi composto TID|SHOPID|RC|ERRORDESC|ORDERID|DATE|UDF1|UDF2|UDF3|UDF4|UDF5
		return $this->getSignature($this->kSig, // KSIGN
				$fields); 
	}
	
	protected function getFileName() {
		return "IGFS_CG_API/tran/IgfsCgVoidAuth.request";
	}

}

?>
