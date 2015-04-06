<?php

require_once("IGFS_CG_API/tran/BaseIgfsCgTran.php");

class IgfsCgCredit extends BaseIgfsCgTran {

	public $shopUserRef;
	public $amount;
	public $currencyCode;
	public $refTranID;
	public $splitTran;
	public $pan;
	public $payInstrToken;
	public $expireMonth;
	public $expireYear;
	public $addInfo1;
	public $addInfo2;
	public $addInfo3;
	public $addInfo4;
	public $addInfo5;
	public $description;

	public $pendingAmount;

	function __construct() {
		parent::__construct();
	}

	protected function resetFields() {
		parent::resetFields();
		$this->shopUserRef = NULL;
		$this->amount = NULL;
		$this->currencyCode = NULL;
		$this->refTranID = NULL;
		$this->splitTran = NULL;
		$this->pan = NULL;
		$this->payInstrToken = NULL;
		$this->expireMonth = NULL;
		$this->expireYear = NULL;
		$this->addInfo1 = NULL;
		$this->addInfo2 = NULL;
		$this->addInfo3 = NULL;
		$this->addInfo4 = NULL;
		$this->addInfo5 = NULL;
		$this->description = NULL;

		$this->pendingAmount = NULL;
	}

	protected function checkFields() {
		parent::checkFields();
		if ($this->amount == NULL)
			throw new IgfsMissingParException("Missing amount");

		if ($this->refTranID == NULL)
		if ($this->pan == NULL)
		if ($this->payInstrToken == NULL)
			throw new IgfsMissingParException("Missing refTranID");

		if ($this->pan != NULL) {
			// Se è stato impostato il pan verifico...
			if ($this->pan == "")
				throw new IgfsMissingParException("Missing pan");
		}
		if ($this->payInstrToken != NULL) {
			// Se è stato impostato il payInstrToken verifico...
			if ($this->payInstrToken == "")
				throw new IgfsMissingParException("Missing payInstrToken");
		}

		if ($this->pan != NULL or $this->payInstrToken != NULL) {
			if ($this->currencyCode == NULL)
				throw new IgfsMissingParException("Missing currencyCode");
		}
	}

	protected function buildRequest() {
		$request = parent::buildRequest();
		if ($this->shopUserRef != NULL)
			$request = $this->replaceRequest($request, "{shopUserRef}", "<shopUserRef><![CDATA[" . $this->shopUserRef . "]]></shopUserRef>");
		else
			$request = $this->replaceRequest($request, "{shopUserRef}", "");
		$request = $this->replaceRequest($request, "{amount}", $this->amount);
		if ($this->currencyCode != NULL)
			$request = $this->replaceRequest($request, "{currencyCode}", "<currencyCode><![CDATA[" . $this->currencyCode . "]]></currencyCode>");
		else
			$request = $this->replaceRequest($request, "{currencyCode}", "");

		if ($this->refTranID != NULL)
			$request = $this->replaceRequest($request, "{refTranID}", "<refTranID><![CDATA[" . $this->refTranID . "]]></refTranID>");
		else
			$request = $this->replaceRequest($request, "{refTranID}", "");
		if ($this->splitTran != NULL)
			$request = $this->replaceRequest($request, "{splitTran}", "<splitTran><![CDATA[" . $this->splitTran . "]]></splitTran>");
		else
			$request = $this->replaceRequest($request, "{splitTran}", "");

		if ($this->pan != NULL)
			$request = $this->replaceRequest($request, "{pan}", "<pan><![CDATA[" . $this->pan . "]]></pan>");
		else
			$request = $this->replaceRequest($request, "{pan}", "");

		if ($this->payInstrToken != NULL)
			$request = $this->replaceRequest($request, "{payInstrToken}", "<payInstrToken><![CDATA[" . $this->payInstrToken . "]]></payInstrToken>");
		else
			$request = $this->replaceRequest($request, "{payInstrToken}", "");

		if ($this->expireMonth != NULL)
			$request = $this->replaceRequest($request, "{expireMonth}", "<expireMonth><![CDATA[" . $this->expireMonth . "]]></expireMonth>");
		else
			$request = $this->replaceRequest($request, "{expireMonth}", "");
		if ($this->expireYear != NULL)
			$request = $this->replaceRequest($request, "{expireYear}", "<expireYear><![CDATA[" . $this->expireYear . "]]></expireYear>");
		else
			$request = $this->replaceRequest($request, "{expireYear}", "");

		if ($this->addInfo1 != NULL)
			$request = $this->replaceRequest($request, "{addInfo1}", "<addInfo1><![CDATA[" . $this->addInfo1 . "]]></addInfo1>");
		else
			$request = $this->replaceRequest($request, "{addInfo1}", "");
		if ($this->addInfo2 != NULL)
			$request = $this->replaceRequest($request, "{addInfo2}", "<addInfo2><![CDATA[" . $this->addInfo2 . "]]></addInfo2>");
		else
			$request = $this->replaceRequest($request, "{addInfo2}", "");
		if ($this->addInfo3 != NULL)
			$request = $this->replaceRequest($request, "{addInfo3}", "<addInfo3><![CDATA[" . $this->addInfo3 . "]]></addInfo3>");
		else
			$request = $this->replaceRequest($request, "{addInfo3}", "");
		if ($this->addInfo4 != NULL)
			$request = $this->replaceRequest($request, "{addInfo4}", "<addInfo4><![CDATA[" . $this->addInfo4 . "]]></addInfo4>");
		else
			$request = $this->replaceRequest($request, "{addInfo4}", "");
		if ($this->addInfo5 != NULL)
			$request = $this->replaceRequest($request, "{addInfo5}", "<addInfo5><![CDATA[" . $this->addInfo5 . "]]></addInfo5>");
		else
			$request = $this->replaceRequest($request, "{addInfo5}", "");

		if ($this->description != NULL)
			$request = $this->replaceRequest($request, "{description}", "<description><![CDATA[" . $this->description . "]]></description>");
		else
			$request = $this->replaceRequest($request, "{description}", "");

		return $request;
	}

	protected function setRequestSignature($request) {
		// signature dove il buffer e' cosi composto APIVERSION|TID|SHOPID|AMOUNT|CURRENCYCODE|REFORDERID|PAN|PAYINSTRTOKEN|EXPIREMONTH|EXPIREYEAR
		$fields = array(
				$this->getVersion(), // APIVERSION
				$this->tid, // TID
				$this->shopID, // SHOPID
				$this->shopUserRef, // SHOPUSERREF
				$this->amount, // AMOUNT
				$this->currencyCode, // CURRENCYCODE
				$this->refTranID, // REFORDERID
				$this->pan, // PAN
				$this->payInstrToken, // PAYINSTRTOKEN
				$this->expireMonth, // EXPIREMONTH
				$this->expireYear, // EXPIREYEAR
				$this->addInfo1, // UDF1
				$this->addInfo2, // UDF2
				$this->addInfo3, // UDF3
				$this->addInfo4, // UDF4
				$this->addInfo5); // UDF5
		$signature = $this->getSignature($this->kSig, // KSIGN
				$fields); 
		$request = $this->replaceRequest($request, "{signature}", $signature);
		return $request;
	}

	protected function getSoapResponseName() {
		return "ns1:CreditResponse";
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
		// Opzionale
		$this->pendingAmount = IgfsUtils::getValue($response, "pendingAmount");
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
		return "IGFS_CG_API/tran/IgfsCgCredit.request";
	}

}

?>
