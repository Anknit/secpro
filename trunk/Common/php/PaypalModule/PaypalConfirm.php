<?php
require_once __DIR__.'/PaypalAPI.php';
$pay_confirmvalue = $_POST['paymentConfirmvalue'];
if($pay_confirmvalue == 'confirm')
{
	$ack = MakePayment($resArray); 
	if($ack == 'SUCCESS')
	{
			$str = '<b><i>Congratulations!</i></b>Your payment transaction is Succesful</br>';
			$str = "User:" . $_SESSION['Username'] . '</br>';
			$str = $str.'Please note the following Details </br></br>';
			$str = $str.'Transcation ID:<b>' . $resArray['PAYMENTINFO_0_TRANSACTIONID']. '</b></br>';
			$str = $str.'Order Time:<b>' . str_replace("Z","",str_replace("T"," ",$resArray['PAYMENTINFO_0_ORDERTIME'])). ' UTC</b></br>';
			$str = $str.'Amount:<b>' . $resArray['PAYMENTINFO_0_AMT']. $resArray['PAYMENTINFO_0_CURRENCYCODE'] .  '</b></br>';
			$str = $str.'Payment Status:<b>' . $resArray['PAYMENTINFO_0_PAYMENTSTATUS']. '</b></br>';
			$str = $str.'Receipt No:<b>' . $resArray['PAYMENTINFO_0_RECEIPTID']. '</b></br>';
			$str = $str.'Invoice No:<b>' . $_SESSION['invoicenum']. '</b></br>';
			$str = $str.'Purchase Description:<b>' . $_SESSION["purchase_descr"]. '</b></br>';
	}	
}
?>