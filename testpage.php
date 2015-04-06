<?php
$siteUrl = 'http://localhost/igfs/'
if($_POST) {

		include_once(dirname(__FILE__) ."/igfs.php");
		$PayObj = new Igfs();
		$PayObj->IgfsNotifyURL = $siteUrl . 'notify.php';
		$PayObj->IgfsErrorURL  = $siteUrl . 'error.php';

		$paymentData = array();
		$paymentData['cart_id'] = time();
		$paymentData['amount'] = $_POST['amount'];
		$PayObj->processPayment($paymentData);
		

}


?>

<form action="" method="post">
<input name="amount" type="text" />
<input type="submit" value="Payment" />
</form>


