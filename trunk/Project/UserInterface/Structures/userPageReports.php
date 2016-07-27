<?php
/*
 * Author: Nitin Aloria
 * Date: 28-July-2015
 * Description: This page is used for making Menu and Submenu for reports tab.
 *
 */
?>
<div id='HomePageReports' style='display:none' class='container tabDiV'>
	<h3 style="  width: 98%;  margin: 15px auto;"> Payment History</h3>
	<hr style="width: 98%;  margin: auto;">
	<div class='container_div'>
		<div>
			<table id="AccountPaymentTable" class="convertTojqGrid ui-grid-Font" url="fetchData.php?data=accountpayment&act=grid" colNames=", Transaction ID, Date (UTC), Amount Paid (USD), Credit Amount (USD), Service Rate (USD/hour), Minutes Credited, Account Expiry, Mode, Status" colModel="accountPaymentColModel" sortBy="paymentDate" gridComplete="accountPaymentColModelFormatterFunction" gridWidth='0.97', gridHeight='0.75'></table>
			<div id="gridpager_AccountPaymentTable"></div>
		</div>
		<div style="clear:both"></div>
	</div>
</div>
<script type="text/javascript" src="./../js/NovaAccountPayment.js"></script>