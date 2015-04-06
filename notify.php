<?php

include_once(dirname(__FILE__) ."/igfs.php");
$PayObj = new Igfs();
echo $payment_id = $PayObj->verifyPayment();
if($payment_id){
//write your logic after success payment.
}else{
//error
}


