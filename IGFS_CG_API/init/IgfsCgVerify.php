<?php

require_once("IGFS_CG_API/init/BaseIgfsCgInit.php");
require_once("IGFS_CG_API/Level3Info.php");

class IgfsCgVerify extends BaseIgfsCgInit {

	public $paymentID;

	public $tranID;
	public $authCode;
	public $enrStatus;
	public $authStatus;
	public $brand;
	public $maskedPan;
	public $addInfo1;
	public $addInfo2;
	public $addInfo3;
	public $addInfo4;
	public $addInfo5;
	public $payInstrToken;
	public $expireMonth;
	public $expireYear;
	public $level3Info;
	public $additionalFee;
	public $status;
	public $accountName;

	function __construct() {
		parent::__construct();
	}

	protected function resetFields() {
		parent::resetFields();
		$this->paymentID = NULL;

		$this->tranID = NULL;
		$this->authCode = NULL;
		$this->enrStatus = NULL;
		$this->authStatus = NULL;
		$this->brand = NULL;
		$this->maskedPan = NULL;
		$this->addInfo1 = NULL;
		$this->addInfo2 = NULL;
		$this->addInfo3 = NULL;
		$this->addInfo4 = NULL;
		$this->addInfo5 = NULL;
		$this->payInstrToken = NULL;
		$this->expireMonth = NULL;
		$this->expireYear = NULL;
		$this->level3Info = NULL;
		$this->additionalFee = NULL;
		$this->status = NULL;
		$this->accountName = NULL;
	}


	protected function checkFields() {
		parent::checkFields();
		if ($this->paymentID == NULL || "" == $this->paymentID)
			throw new IgfsMissingParException("Missing paymentID");
	}


	protected function buildRequest() {
		$request = parent::buildRequest();
		$request = $this->replaceRequest($request, "{paymentID}", $this->paymentID);
		return $request;
	}

	protected function setRequestSignature($request) {
		$fields = array(
				$this->getVersion(), // APIVERSION
				$this->tid, // TID
				$this->shopID, // SHOPID
				$this->paymentID); // PAYMENTID
		// signature dove il buffer e' cosi composto APIVERSION|TID|SHOPID|PAYMENTID
		$signature = $this->getSignature($this->kSig, // KSIGN
				$fields); 
		$request = $this->replaceRequest($request, "{signature}", $signature);
		return $request;
	}

	protected function getSoapResponseName() {
		return "ns1:VerifyResponse";
	}

	protected function parseResponseMap($response) {
		parent::parseResponseMap($response);
		// Opzionale
		$this->tranID = IgfsUtils::getValue($response, "tranID");
		// Opzionale
		$this->authCode = IgfsUtils::getValue($response, "authCode");
		// Opzionale
		$this->enrStatus = IgfsUtils::getValue($response, "enrStatus");
		// Opzionale
		$this->authStatus = IgfsUtils::getValue($response, "authStatus");
		// Opzionale
		$this->brand = IgfsUtils::getValue($response, "brand");
		// Opzionale
		$this->maskedPan = IgfsUtils::getValue($response, "maskedPan");
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
		// Opzionale
		$this->payInstrToken = IgfsUtils::getValue($response, "payInstrToken");
		// Opzionale
		$this->expireMonth = IgfsUtils::getValue($response, "expireMonth");
		// Opzionale
		$this->expireYear = IgfsUtils::getValue($response, "expireYear");
		// Opzionale
		$this->level3Info = Level3Info::fromXml(IgfsUtils::getValue($response, "level3Info"));
		// Opzionale
		$this->additionalFee = IgfsUtils::getValue($response, "additionalFee");
		// Opzionale
		$this->status = IgfsUtils::getValue($response, "status");
		// Opzionale
		$this->accountName = IgfsUtils::getValue($response, "accountName");
	}

	protected function getResponseSignature($response) {
		$fields = array(
				IgfsUtils::getValue($response, "tid"), // TID
				IgfsUtils::getValue($response, "shopID"), // SHOPID
				IgfsUtils::getValue($response, "rc"), // RC
				IgfsUtils::getValue($response, "errorDesc"),// ERRORDESC
				IgfsUtils::getValue($response, "paymentID"),// PAYMENTID
				IgfsUtils::getValue($response, "tranID"),// ORDERID
				IgfsUtils::getValue($response, "authCode"),// AUTHCODE
				IgfsUtils::getValue($response, "enrStatus"),// ENRSTATUS
				IgfsUtils::getValue($response, "authStatus"));// AUTHSTATUS
		// signature dove il buffer e' cosi composto TID|SHOPID|RC|ERRORDESC|PAYMENTID|REDIRECTURL
		return $this->getSignature($this->kSig, // KSIGN
				$fields); 
	}
	
	protected function getFileName() {
		return "IGFS_CG_API/init/IgfsCgVerify.request";
	}

}

?>
