<?php
/*
 * Author: Ankit
 * Date: 31-jul-2014
 * Description: This page will be displayed when the Account manager click on the credits menu option
 * 				
 */
?> 
<div id ="CreditGenerationOption" class="tabDiV" style="display: none; float: left">
	<div align="left" style='margin-left:20px'>
		<h3>Add credit</h3>
		<hr width="98%">
	</div>
	<div class="SubHeadingDiv">
		<div id='Credit_Gen_Options' style="float:left;width:170px">
			<span>Choose a payment mode</span>
			<br />
			<br />
			<div id='pay_Using_Voucher' class='Enforce_font_x13'>Activate voucher</div>
			<br />
			<div id='pay_Using_PayPal' class='Enforce_font_x13'>
				Pay with paypal
				<a href="#null" title="<?php echo TITLE26;?>">[?]</a>
			</div>
		</div>
		<div style="float:left">
			<br />
			<br />
	        <div id='voucher_Payment_options' style='visibility:visible'>
		    	<input placeholder=" Voucher Code" type="text" id="voucherCodeValue" name="voucherCodeValue" />
                <button style="margin-left:20px" class="mediumButton" type="button" onclick="activateVoucher();">Activate</button>
		    </div>
		    <br />
		    <div id='paypal_Payment_options' style='visibility:hidden;'>
		    	<div style='float:left; margin-top: 2px; font-size: 13px;'>Amount (USD)</div>
		    	<div style='float:left; margin-left:20px'>
					<form id="payPalPurchaseForm" action='../../Common/php/PaypalModule/PaypalCheckoutFile.php' METHOD='POST'>
						<input id='payPalPurchaseAmount' class='miniInputBox' placeholder=" Enter Amount" type="text" name="Payment_Amount" size="15" maxlength="15" tabindex="1" onfocus="this.select()" align="left"  value='<?php
						if(  (isset($_SESSION)) && (isset($_SESSION["Payment_Amount"])) )
							echo $_SESSION["Payment_Amount"];
						?>' />
						<img src='../../Common/php/PaypalModule/btn_xpressCheckout.gif' height="32" style="margin-left:20px; cursor:pointer;margin-top: -4px;" border='0' align='top' alt='Check out with PayPal' onclick="startPaypalTransaction();"/>
					</form>
				</div>
		    </div>
		</div>    
    </div>
</div>
<script type="text/javascript" src="../js/PurchaseCredit.js" ></script>