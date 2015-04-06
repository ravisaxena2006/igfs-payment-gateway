<?php
/**
 * Name : IGFS Payment Gateway (UniCredit)
 * Ver : 1.0
 * Author : RaviSaxena2006
 * Release :  April 2015
 */
include_once(dirname(__FILE__) ."/IGFS_CG_API/init/IgfsCgInit.php");


class Igfs 
{
	public $ssl = true;	
	public $testmode = true;	
	public $testurl = 'https://testuni.netsw.it/UNI_CG_SERVICES/services';
	public $liveurl = 'https://IPGATEWAY/UNI_CG_SERVICES/services';
	public $IgfsNotifyURL = '';
	public $IgfsErrorURL = '';
	public $IgfsTimeout = 1500;
	public $IgfsTreminalId = 'UNI_ECOM';
	public $IgfsApikSig = 'UNI_TESTKEY';
	public $IgfsShopUserRef = 'UNIBO';
	public $IgfsCurrencyCode = 'EUR'; //ISO
	public $IgfsLangID = 'EN'; //ISO
	
    function __construct() {
		//parent::__construct();
	}
	
	public function processPayment($paymentData = array()){
	
	    
			$init = new IgfsCgInit();			
			
			if($this->testmode==true){
				$init->serverURL = $this->testurl; 
				$init->disableCheckSSLCert();				
			}else{
				$init->serverURL = $this->liveurl; 
			}
			
			$this->setCookiesValue('cart_id',$paymentData['cart_id']);
			
			$init->timeout 		= $this->IgfsTimeout;			
			$init->tid 			= $this->IgfsTreminalId;
			$init->kSig 		= $this->IgfsApikSig;
			$init->shopID 		= $paymentData['cart_id']; //$cart_id  . strtotime($date);
			$init->shopUserRef 	= $this->IgfsShopUserRef;
			$init->trType = "PURCHASE";
			$init->currencyCode = $this->IgfsCurrencyCode;//iso_code;
			$init->amount = str_replace('.', '', number_format($paymentData['amount'], 2, '.', ''));
			$init->langID = $this->IgfsLangID;
			$init->notifyURL = $this->IgfsNotifyURL;
			$init->errorURL = $this->IgfsErrorURL;
			
			if(!$init->execute()){
			//assign error 
			echo $init->rc . "<br>";
			echo $init->errorDesc;
			}else{
			//redirect to success page.
			$payment_id = $init->paymentID;
			$this->setCookiesValue('payment_id',$payment_id);
			header("location: ".$init->redirectURL);
			}
			
			
	
	}
	
	
	
	function verifyPayment(){
	
	include_once(dirname(__FILE__) ."/IGFS_CG_API/init/IgfsCgVerify.php");
	
		$verify = new IgfsCgVerify();
		$payment_id =  $this->getCookiesValue('payment_id');
		$cart_id =  $this->getCookiesValue('cart_id');
		if($payment_id) { 
				
				if($this->testmode==true){
					$verify->serverURL = $this->testurl; 
					$verify->disableCheckSSLCert();
				}else{
					$verify->serverURL = $this->liveurl; 
				}

				$verify->timeout = $this->IgfsTimeout;		
				$verify->tid = $this->IgfsTreminalId;
				$verify->kSig = $this->IgfsApikSig;
				$verify->shopID = $cart_id;
				$verify->paymentID = $payment_id;
				
				if ($verify->execute()){			   
					$this->deleteCookiesValue('payment_id');
					return $verify->paymentID;
				}
		}
	
	return false;
	
	}
	
	
	protected function getCookiesValue($key=null){
			
			if(isset($_COOKIE[$key])){
				return $_COOKIE[$key];
			}
			else{
				return false;
			}		
	
	}	

	protected function setCookiesValue($cookie_name=null,$cookie_value=null){
	
				if($cookie_value!=null){				
						setcookie($cookie_name, $cookie_value, time() + (3600 * 30), "/"); // 3600 = 1 hour
				}
	}
	
	public function deleteCookiesValue($key=null){	     
		setcookie($key, "", time() - (8400 * 30), "/"); // 3600 = 1 hour	
	}
	
	
	
	
	
}