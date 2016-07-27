<div align='center'>
<hr style="margin-left: 0px;opacity: 0.5;color: #eee;" />
	<div>
		<p><u><b>Payment Confirmation</b></u></p>
	</div>
	<span>Your payment details are verified successfully.<br /> Press Confirm to proceed with this payment <br /> OR <br /> Press Cancel to abort this transaction</span>
	<form action='UserPage.php' METHOD='POST'>
		 <input type="hidden" name="paymentConfirmvalue" size="15" maxlength="15" tabindex="1" onfocus="this.select()" align="left"  value="confirm" />	 	
		 <!-- <input type='image' name='submit' value="confirm"  src='https://www.paypalobjects.com/webstatic/en_US/btn/btn_paynow_107x26.png' border='0' align='top' alt='Pay with PayPal'/> -->
		 <input type='submit' style='margin-top:15px' name='payment_Confirm' value="Confirm"  border='0' align='top'/>
		 <input type='submit' name='payment_Cancel' value="Cancel"  border='0' align='top'/>
	</form>
</div>