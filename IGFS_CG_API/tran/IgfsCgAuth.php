<?php

require_once("IGFS_CG_API/tran/BaseIgfsCgTran.php");
require_once("IGFS_CG_API/Level3Info.php");

class IgfsCgAuth extends BaseIgfsCgTran {

	public $shopUserRef;
	public $shopUserName;
	public $shopUserAccount;
	public $shopUserIP;
	public $trType = "AUTH";
	public $amount;
	public $currencyCode;
	public $pan;
	public $payInstrToken;
	public $regenPayInstrToken;
	public $payInstrTokenExpire;
	public $payInstrTokenUsageLimit;
	public $cvv2;
	public $expireMonth;
	public $expireYear;
	public $accountName;
	public $addInfo1;
	public $addInfo2;
	public $addInfo3;
	public $addInfo4;
	public $addInfo5;
	public $enrStatus;
	public $authStatus;
	public $cavv;
	public $xid;
	public $level3Info;
	public $description;
	public $recurrent;
	public $freeText;
	public $topUpID;
	public $promoCode;
	public $payPassData;

	public $paymentID;
	public $authCode;
	public $brand;
	public $maskedPan;
	public $additionalFee;
	public $status;

	function __construct() {
		parent::__construct();
	}

	protected function resetFields() {
		parent::resetFields();
		$this->shopUserRef = NULL;
		$this->shopUserName = NULL;
		$this->shopUserAccount = NULL;
		$this->shopUserIP = NULL;
		$this->trType = "AUTH";
		$this->amount = NULL;
		$this->currencyCode = NULL;
		$this->pan = NULL;
		$this->payInstrToken = NULL;
		$this->regenPayInstrToken = NULL;
		$this->payInstrTokenExpire = NULL;
		$this->payInstrTokenUsageLimit = NULL;
		$this->cvv2 = NULL;
		$this->expireMonth = NULL;
		$this->expireYear = NULL;
		$this->accountName = NULL;
		$this->addInfo1 = NULL;
		$this->addInfo2 = NULL;
		$this->addInfo3 = NULL;
		$this->addInfo4 = NULL;
		$this->addInfo5 = NULL;
		$this->enrStatus = NULL;
		$this->authStatus = NULL;
		$this->cavv = NULL;
		$this->xid = NULL;
		$this->level3Info = NULL;
		$this->description = NULL;
		$this->recurrent = NULL;
		$this->freeText = NULL;
		$this->topUpID = NULL;
		$this->promoCode = NULL;
		$this->payPassData = NULL;

		$this->paymentID = NULL;
		$this->authCode = NULL;
		$this->brand = NULL;
		$this->maskedPan = NULL;
		$this->additionalFee = NULL;
		$this->status = NULL;
	}

	protected function checkFields() {
		parent::checkFields();
		if ($this->trType == NULL)
			throw new IgfsMissingParException("Missing trType");
		if ($this->amount == NULL)
			throw new IgfsMissingParException("Missing amount");
		if ($this->currencyCode == NULL)
			throw new IgfsMissingParException("Missing currencyCode");
		if ($this->pan == NULL) {
			if ($this->payInstrToken == NULL)
				throw new IgfsMissingParException("Missing pan");
		}
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
		if ($this->shopUserRef != NULL)
			$request = $this->replaceRequest($request, "{shopUserRef}", "<shopUserRef><![CDATA[" . $this->shopUserRef . "]]></shopUserRef>");
		else
			$request = $this->replaceRequest($request, "{shopUserRef}", "");
		if ($this->shopUserName != NULL)
			$request = $this->replaceRequest($request, "{shopUserName}", "<shopUserName><![CDATA[" . $this->shopUserName . "]]></shopUserName>");
		else
			$request = $this->replaceRequest($request, "{shopUserName}", "");
		if ($this->shopUserAccount != NULL)
			$request = $this->replaceRequest($request, "{shopUserAccount}", "<shopUserAccount><![CDATA[" . $this->shopUserAccount . "]]></shopUserAccount>");
		else
			$request = $this->replaceRequest($request, "{shopUserAccount}", "");
		if ($this->shopUserIP != NULL)
			$request = $this->replaceRequest($request, "{shopUserIP}", "<shopUserIP><![CDATA[" . $this->shopUserIP . "]]></shopUserIP>");
		else
			$request = $this->replaceRequest($request, "{shopUserIP}", "");

		$request = $this->replaceRequest($request, "{trType}", $this->trType);
		$request = $this->replaceRequest($request, "{amount}", $this->amount);
		$request = $this->replaceRequest($request, "{currencyCode}", $this->currencyCode);

		if ($this->pan != NULL)
			$request = $this->replaceRequest($request, "{pan}", "<pan><![CDATA[" . $this->pan . "]]></pan>");
		else
			$request = $this->replaceRequest($request, "{pan}", "");

		if ($this->payInstrToken != NULL)
			$request = $this->replaceRequest($request, "{payInstrToken}", "<payInstrToken><![CDATA[" . $this->payInstrToken . "]]></payInstrToken>");
		else
			$request = $this->replaceRequest($request, "{payInstrToken}", "");
		if ($this->regenPayInstrToken != NULL)
			$request = $this->replaceRequest($request, "{regenPayInstrToken}", "<regenPayInstrToken><![CDATA[" . $this->regenPayInstrToken . "]]></regenPayInstrToken>");
		else
			$request = $this->replaceRequest($request, "{regenPayInstrToken}", "");
		if ($this->payInstrTokenExpire != NULL)
			$request = $this->replaceRequest($request, "{payInstrTokenExpire}", "<payInstrTokenExpire><![CDATA[" . IgfsUtils::formatXMLGregorianCalendar($this->payInstrTokenExpire) . "]]></payInstrTokenExpire>");
		else
			$request = $this->replaceRequest($request, "{payInstrTokenExpire}", "");
		if ($this->payInstrTokenUsageLimit != NULL)
			$request = $this->replaceRequest($request, "{payInstrTokenUsageLimit}", "<payInstrTokenUsageLimit><![CDATA[" . $this->payInstrTokenUsageLimit . "]]></payInstrTokenUsageLimit>");
		else
			$request = $this->replaceRequest($request, "{payInstrTokenUsageLimit}", "");

		if ($this->cvv2 != NULL)
			$request = $this->replaceRequest($request, "{cvv2}", "<cvv2><![CDATA[" . $this->cvv2 . "]]></cvv2>");
		else
			$request = $this->replaceRequest($request, "{cvv2}", "");

		if ($this->expireMonth != NULL)
			$request = $this->replaceRequest($request, "{expireMonth}", "<expireMonth><![CDATA[" . $this->expireMonth . "]]></expireMonth>");
		else
			$request = $this->replaceRequest($request, "{expireMonth}", "");
		if ($this->expireYear != NULL)
			$request = $this->replaceRequest($request, "{expireYear}", "<expireYear><![CDATA[" . $this->expireYear . "]]></expireYear>");
		else
			$request = $this->replaceRequest($request, "{expireYear}", "");

		if ($this->accountName != NULL)
			$request = $this->replaceRequest($request, "{accountName}", "<accountName><![CDATA[" . $this->accountName . "]]></accountName>");
		else
			$request = $this->replaceRequest($request, "{accountName}", "");

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

		if ($this->enrStatus != NULL)
			$request = $this->replaceRequest($request, "{enrStatus}", "<enrStatus><![CDATA[" . $this->enrStatus . "]]></enrStatus>");
		else
			$request = $this->replaceRequest($request, "{enrStatus}", "");
		if ($this->authStatus != NULL)
			$request = $this->replaceRequest($request, "{authStatus}", "<authStatus><![CDATA[" . $this->authStatus . "]]></authStatus>");
		else
			$request = $this->replaceRequest($request, "{authStatus}", "");
		if ($this->cavv != NULL)
			$request = $this->replaceRequest($request, "{cavv}", "<cavv><![CDATA[" . $this->cavv . "]]></cavv>");
		else
			$request = $this->replaceRequest($request, "{cavv}", "");
		if ($this->xid != NULL)
			$request = $this->replaceRequest($request, "{xid}", "<xid><![CDATA[" . $this->xid . "]]></xid>");
		else
			$request = $this->replaceRequest($request, "{xid}", "");

		if ($this->level3Info != NULL)
			$request = $this->replaceRequest($request, "{level3Info}", $this->level3Info->toXml());
		else
			$request = $this->replaceRequest($request, "{level3Info}", "");
		if ($this->description != NULL)
			$request = $this->replaceRequest($request, "{description}", "<description><![CDATA[" . $this->description . "]]></description>");
		else
			$request = $this->replaceRequest($request, "{description}", "");
		if ($this->recurrent != NULL)
			$request = $this->replaceRequest($request, "{recurrent}", "<recurrent><![CDATA[" . $this->recurrent . "]]></recurrent>");
		else
			$request = $this->replaceRequest($request, "{recurrent}", "");
		if ($this->freeText != NULL)
			$request = $this->replaceRequest($request, "{freeText}", "<freeText><![CDATA[" . $this->freeText . "]]></freeText>");
		else
			$request = $this->replaceRequest($request, "{freeText}", "");
		if ($this->topUpID != NULL)
			$request = $this->replaceRequest($request, "{topUpID}", "<topUpID><![CDATA[" . $this->topUpID . "]]></topUpID>");
		else
			$request = $this->replaceRequest($request, "{topUpID}", "");

		if ($this->promoCode != NULL)
			$request = $this->replaceRequest($request, "{promoCode}", "<promoCode><![CDATA[" . $this->promoCode . "]]></promoCode>");
		else
			$request = $this->replaceRequest($request, "{promoCode}", "");

		if ($this->payPassData != NULL)
			$request = $this->replaceRequest($request, "{payPassData}", "<payPassData><![CDATA[" . $this->payPassData . "]]></payPassData>");
		else
			$request = $this->replaceRequest($request, "{payPassData}", "");

		return $request;
	}

	protected function setRequestSignature($request) {
		// signature dove il buffer e' cosi composto APIVERSION|TID|SHOPID|SHOPUSERREF|SHOPUSERNAME|SHOPUSERACCOUNT|SHOPUSERIP|TRTYPE|AMOUNT|CURRENCYCODE|PAN|PAYINSTRTOKEN|CVV2|EXPIREMONTH|EXPIREYEAR|UDF1|UDF2|UDF3|UDF4|UDF5
		$fields = array(
				$this->getVersion(), // APIVERSION
				$this->tid, // TID
				$this->shopID, // SHOPID
				$this->shopUserRef, // SHOPUSERREF
				$this->shopUserName, // SHOPUSERNAME
				$this->shopUserAccount, // SHOPUSERACCOUNT
				$this->shopUserIP, // SHOPUSERIP
				$this->trType,// TRTYPE
				$this->amount, // AMOUNT
				$this->currencyCode, // CURRENCYCODE
				$this->pan, // PAN
				$this->payInstrToken, // PAYINSTRTOKEN
				$this->cvv2, // CVV2
				$this->expireMonth, // EXPIREMONTH
				$this->expireYear, // EXPIREYEAR
				$this->addInfo1, // UDF1
				$this->addInfo2, // UDF2
				$this->addInfo3, // UDF3
				$this->addInfo4, // UDF4
				$this->addInfo5, // UDF5
				$this->topUpID);
		$signature = $this->getSignature($this->kSig, // KSIGN
				$fields); 
		$request = $this->replaceRequest($request, "{signature}", $signature);
		return $request;
	}

	protected function getSoapResponseName() {
		return "ns1:AuthResponse";
	}

	protected function parseResponseMap($response) {
		parent::parseResponseMap($response);
		// Opzionale
		$this->paymentID = IgfsUtils::getValue($response, "paymentID");
		// Opzionale
		$this->authCode = IgfsUtils::getValue($response, "authCode");
		// Opzionale
		$this->brand = IgfsUtils::getValue($response, "brand");
		// Opzionale
		$this->maskedPan = IgfsUtils::getValue($response, "maskedPan");
		// Opzionale
		$this->payInstrToken = IgfsUtils::getValue($response, "payInstrToken");
		// Opzionale
		$this->additionalFee = IgfsUtils::getValue($response, "additionalFee");
		// Opzionale
		$this->status = IgfsUtils::getValue($response, "status");
	}

	protected function getResponseSignature($response) {
		$fields = array(
				IgfsUtils::getValue($response, "tid"), // TID
				IgfsUtils::getValue($response, "shopID"), // SHOPID
				IgfsUtils::getValue($response, "rc"), // RC
				IgfsUtils::getValue($response, "errorDesc"),// ERRORDESC
				IgfsUtils::getValue($response, "tranID"), // ORDERID
				IgfsUtils::getValue($response, "date"), // TRANDATE
				IgfsUtils::getValue($response, "paymentID"), // PAYMENTID
				IgfsUtils::getValue($response, "authCode"));// AUTHCODE	
		// signature dove il buffer e' cosi composto TID|SHOPID|RC|ERRORCODE|ORDERID|PAYMENTID|AUTHCODE
		return $this->getSignature($this->kSig, // KSIGN
				$fields); 
	}
	
	protected function getFileName() {
		return "IGFS_CG_API/tran/IgfsCgAuth.request";
	}

}

?>
