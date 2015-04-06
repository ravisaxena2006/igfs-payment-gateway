<?php

require_once("IGFS_CG_API/init/BaseIgfsCgInit.php");
require_once("IGFS_CG_API/Level3Info.php");

class IgfsCgInit extends BaseIgfsCgInit {

	public $paymentID;
	public $amount;
	public $level3Info;

	public $redirectURL;

	function __construct() {
		parent::__construct();
	}

	protected function resetFields() {
		parent::resetFields();
		$this->paymentID = NULL;
		$this->amount = NULL;
		$this->level3Info = NULL;

		$this->redirectURL = NULL;
	}

	protected function checkFields() {
		parent::checkFields();
		if ($this->payInstrToken == NULL || $this->payInstrToken == "") {
			throw new IgfsMissingParException("Missing payInstrToken");
		}
		if ($this->amount == NULL)
			throw new IgfsMissingParException("Missing amount");
		if ($this->level3Info != NULL) {
			$i = 0;
			if ($this->level3Info->product != NULL) {
				foreach ($this->level3Info->product as $product) {
					if ($product->productCode == NULL)
						throw new IgfsMissingParException("Missing productCode[" . i . "]");
					if ($product->productDescription == NULL)
						throw new IgfsMissingParException("Missing productDescription[" . i . "]");
				}
				$i++;
			}
		}
	}

	protected function buildRequest() {
		$request = parent::buildRequest();
		$request = $this->replaceRequest($request, "{paymentID}", $this->paymentID);
		$request = $this->replaceRequest($request, "{amount}", $this->amount);
		if ($this->level3Info != NULL)
			$request = $this->replaceRequest($request, "{level3Info}", $this->level3Info->toXml());
		else
			$request = $this->replaceRequest($request, "{level3Info}", "");
		return $request;
	}

	protected function setRequestSignature($request) {
		// signature dove il buffer e' cosi composto APIVERSION|TID|SHOPID|PAYMENTID
		$fields = array(
				$this->getVersion(), // APIVERSION
				$this->tid, // TID
				$this->shopID, // SHOPID
				$this->paymentID, // PAYMENTID
				$this->amount); // AMOUNT
		$signature = $this->getSignature($this->kSig, // KSIGN
				$fields); 
		$request = $this->replaceRequest($request, "{signature}", $signature);
		return $request;
	}

	protected function getSoapResponseName() {
		return "ns1:CheckoutResponse";
	}

	protected function parseResponseMap($response) {
		parent::parseResponseMap($response);
		// Opzionale
		$this->paymentID = IgfsUtils::getValue($response, "paymentID");
		// Opzionale
		$this->redirectURL = IgfsUtils::getValue($response, "redirectURL");
	}

	protected function getResponseSignature($response) {
		$fields = array(
				IgfsUtils::getValue($response, "tid"), // TID
				IgfsUtils::getValue($response, "shopID"), // SHOPID
				IgfsUtils::getValue($response, "rc"), // RC
				IgfsUtils::getValue($response, "errorDesc"),// ERRORDESC
				IgfsUtils::getValue($response, "paymentID"), // PAYMENTID
				IgfsUtils::getValue($response, "redirectURL"));// REDIRECTURL	
		// signature dove il buffer e' cosi composto TID|SHOPID|RC|ERRORDESC|PAYMENTID|REDIRECTURL
		return $this->getSignature($this->kSig, // KSIGN
				$fields); 
	}
	
	protected function getFileName() {
		return "IGFS_CG_API/init/IgfsCgCheckout.request";
	}

}

?>
