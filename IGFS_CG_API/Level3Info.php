<?php

require_once("IGFS_CG_API/Level3InfoProduct.php");

class Level3Info {
	
	public $invoiceNumber;
	public $senderPostalCode;
	public $senderCountryCode;
	public $destinationName;
	public $destinationStreet;
	public $destinationStreet2;
	public $destinationStreet3;
	public $destinationCity;
	public $destinationState;
	public $destinationPostalCode;
	public $destinationCountryCode;
	public $billingName;
	public $billingStreet;
	public $billingStreet2;
	public $billingStreet3;
	public $billingCity;
	public $billingState;
	public $billingPostalCode;
	public $billingCountryCode;
	public $freightAmount;
	public $taxAmount;
	public $vat;
	public $note;
	public $product;

    function __construct() {
	}


	public function toXml() {
		$sb = "";
		$sb .= "<level3Info>";
		if ($this->invoiceNumber != NULL) {
			$sb .= "<invoiceNumber><![CDATA[";
			$sb .= $this->invoiceNumber;
			$sb .= "]]></invoiceNumber>";
		}
		if ($this->senderPostalCode != NULL) {
			$sb .= "<senderPostalCode><![CDATA[";
			$sb .= $this->senderPostalCode;
			$sb .= "]]></senderPostalCode>";
		}
		if ($this->senderCountryCode != NULL) {
			$sb .= "<senderCountryCode><![CDATA[";
			$sb .= $this->senderCountryCode;
			$sb .= "]]></senderCountryCode>";
		}
		if ($this->destinationName != NULL) {
			$sb .= "<destinationName><![CDATA[";
			$sb .= $this->destinationName;
			$sb .= "]]></destinationName>";
		}
		if ($this->destinationStreet != NULL) {
			$sb .= "<destinationStreet><![CDATA[";
			$sb .= $this->destinationStreet;
			$sb .= "]]></destinationStreet>";
		}
		if ($this->destinationStreet2 != NULL) {
			$sb .= "<destinationStreet2><![CDATA[";
			$sb .= $this->destinationStreet2;
			$sb .= "]]></destinationStreet2>";
		}
		if ($this->destinationStreet3 != NULL) {
			$sb .= "<destinationStreet3><![CDATA[";
			$sb .= $this->destinationStreet3;
			$sb .= "]]></destinationStreet3>";
		}
		if ($this->destinationCity != NULL) {
			$sb .= "<destinationCity><![CDATA[";
			$sb .= $this->destinationCity;
			$sb .= "]]></destinationCity>";
		}
		if ($this->destinationState != NULL) {
			$sb .= "<destinationState><![CDATA[";
			$sb .= $this->destinationState;
			$sb .= "]]></destinationState>";
		}
		if ($this->destinationPostalCode != NULL) {
			$sb .= "<destinationPostalCode><![CDATA[";
			$sb .= $this->destinationPostalCode;
			$sb .= "]]></destinationPostalCode>";
		}
		if ($this->destinationCountryCode != NULL) {
			$sb .= "<destinationCountryCode><![CDATA[";
			$sb .= $this->destinationCountryCode;
			$sb .= "]]></destinationCountryCode>";
		}
		if ($this->billingName != NULL) {
			$sb .= "<billingName><![CDATA[";
			$sb .= $this->billingName;
			$sb .= "]]></billingName>";
		}
		if ($this->billingStreet != NULL) {
			$sb .= "<billingStreet><![CDATA[";
			$sb .= $this->billingStreet;
			$sb .= "]]></billingStreet>";
		}
		if ($this->billingStreet2 != NULL) {
			$sb .= "<billingStreet2><![CDATA[";
			$sb .= $this->billingStreet2;
			$sb .= "]]></billingStreet2>";
		}
		if ($this->billingStreet3 != NULL) {
			$sb .= "<billingStreet3><![CDATA[";
			$sb .= $this->billingStreet3;
			$sb .= "]]></billingStreet3>";
		}
		if ($this->billingCity != NULL) {
			$sb .= "<billingCity><![CDATA[";
			$sb .= $this->billingCity;
			$sb .= "]]></billingCity>";
		}
		if ($this->billingState != NULL) {
			$sb .= "<billingState><![CDATA[";
			$sb .= $this->billingState;
			$sb .= "]]></billingState>";
		}
		if ($this->billingPostalCode != NULL) {
			$sb .= "<billingPostalCode><![CDATA[";
			$sb .= $this->billingPostalCode;
			$sb .= "]]></billingPostalCode>";
		}
		if ($this->billingCountryCode != NULL) {
			$sb .= "<billingCountryCode><![CDATA[";
			$sb .= $this->billingCountryCode;
			$sb .= "]]></billingCountryCode>";
		}		
		if ($this->freightAmount != NULL) {
			$sb .= "<freightAmount><![CDATA[";
			$sb .= $this->freightAmount;
			$sb .= "]]></freightAmount>";
		}
		if ($this->taxAmount != NULL) {
			$sb .= "<taxAmount><![CDATA[";
			$sb .= $this->taxAmount;
			$sb .= "]]></taxAmount>";
		}
		if ($this->vat != NULL) {
			$sb .= "<vat><![CDATA[";
			$sb .= $this->vat;
			$sb .= "]]></vat>";
		}
		if ($this->note != NULL) {
			$sb .= "<note><![CDATA[";
			$sb .= $this->note;
			$sb .= "]]></note>";
		}
		if ($this->product != NULL) {
			foreach ($this->product as $item) {
				$sb .= $item->toXml();
			}
		}
		$sb .= "</level3Info>";
		return $sb;
	}

	public static function fromXml($xml) {

		if ($xml=="" || $xml==NULL) {
			return;
		}

		$dom = new SimpleXMLElement($xml, LIBXML_NOERROR, false);
		if (count($dom)==0) {
			return;
		}

		$response = IgfsUtils::parseResponseFields($dom);
		$level3Info = NULL;
		if (isset($response) && count($response)>0) {
			$level3Info = new Level3Info();
			
			$level3Info->invoiceNumber = (IgfsUtils::getValue($response, "invoiceNumber"));
			$level3Info->senderPostalCode = (IgfsUtils::getValue($response, "senderPostalCode"));
			$level3Info->senderCountryCode = (IgfsUtils::getValue($response, "senderCountryCode"));

			$level3Info->destinationName = (IgfsUtils::getValue($response, "destinationName"));
			$level3Info->destinationStreet = (IgfsUtils::getValue($response, "destinationStreet"));
			$level3Info->destinationStreet2 = (IgfsUtils::getValue($response, "destinationStreet2"));
			$level3Info->destinationStreet3 = (IgfsUtils::getValue($response, "destinationStreet3"));
			$level3Info->destinationCity = (IgfsUtils::getValue($response, "destinationCity"));
			$level3Info->destinationState = (IgfsUtils::getValue($response, "destinationState"));
			$level3Info->destinationPostalCode = (IgfsUtils::getValue($response, "destinationPostalCode"));
			$level3Info->destinationCountryCode = (IgfsUtils::getValue($response, "destinationCountryCode"));

			$level3Info->billingName = (IgfsUtils::getValue($response, "billingName"));
			$level3Info->billingStreet = (IgfsUtils::getValue($response, "billingStreet"));
			$level3Info->billingStreet2 = (IgfsUtils::getValue($response, "billingStreet2"));
			$level3Info->billingStreet3 = (IgfsUtils::getValue($response, "billingStreet3"));
			$level3Info->billingCity = (IgfsUtils::getValue($response, "billingCity"));
			$level3Info->billingState = (IgfsUtils::getValue($response, "billingState"));
			$level3Info->billingPostalCode = (IgfsUtils::getValue($response, "billingPostalCode"));
			$level3Info->billingCountryCode = (IgfsUtils::getValue($response, "billingCountryCode"));

			$level3Info->freightAmount = (IgfsUtils::getValue($response, "freightAmount"));
			$level3Info->taxAmount = (IgfsUtils::getValue($response, "taxAmount"));
			$level3Info->vat = (IgfsUtils::getValue($response, "vat"));
			$level3Info->note = (IgfsUtils::getValue($response, "note"));

			if (isset($response["product"])) {
				$product = array();
				foreach ($dom->children() as $item) {
					if ($item->getName() == "product") {
					    $product[] = Level3InfoProduct::fromXml($item->asXML());
					}
				}
				$level3Info->product = $product;
			}
		}
		return $level3Info;
	}

}
?>
