<?php
?>
<div id='HomePagePayments' style='display:none' class='container tabDiV'>
	<div class='container_div menu_container'>
		<div class='item_container_div f_l'>
			<div class='menu_item'>
				<input type='button' class='jqxbutton c_p' value='Add' title="Create new payment entry" onclick='openNewItemForm(this)' openDivID='payment_add_form'/>
			</div>
		</div>
	</div>
	<hr />
	<div class='container_div'>
		<div>
			<table id="PaymentTable" class="convertTojqGrid ui-grid-Font" url="fetchData.php?data=payment&act=grid" colNames=", Customer, Transaction ID, Date (UTC), Amount Paid(USD), Credit Amount(USD), Service Rate(USD/hour), Minutes Credited, Account Expiry, Mode, Status" colModel="paymentColModel" sortBy="paymentDate" gridComplete="paymentColModelFormatterFunction" gridWidth='0.97', gridHeight='0.75'></table>
			<div id="gridpager_PaymentTable"></div>
		</div>
		<div style="clear:both"></div>
	</div>
	<div id='payment_add_form' class='modal_div'>
		<div class='windowHead'>
			New Payment
		</div>
		<div class='windowBody'>
			<table cellpadding='3'>
				<tr>
					<td>Select Customer</td>
					<td>
						<select name='customerListSelect' id='customerListSelect' title="Select customer">
						</select>
					</td>
				</tr>
				<tr>
					<td>Amount Paid (USD)</td>
					<td>
						<input type='number' name='payAmountP' id='payAmountP' title="Amount paid by customer" />
					</td>
				</tr>
				<tr>
					<td>Credit Amount (USD)</td>
					<td>
						<input type='number' name='payAmountC' id='payAmountC' title="Amount credit to customer" />
					</td>
				</tr>
				<tr>
					<td>Service Rate (USD/hour)</td>
					<td>
						<input type='number' name='serviceRate' id='serviceRate' title="Current rate of service charged to the customer" />
					</td>
				</tr>
				<tr>
					<td>Credit Minutes</td>
					<td>
						<input type='number' name='creditMin' id='creditMin' title="Credit minutes added to customer account" />
					</td>
				</tr>
				<tr>
					<td>Account Expiry Date</td>
					<td>
						<div class='dateTimeInput' style='margin:auto' id='validityCur' name='validityCur' disabled></div>
					</td>
				</tr>
				<tr>
					<td>Account Validity Extension</td>
					<td>
						<div class='dateTimeInput' style='margin:auto' id='validityExt' name='validityExt'></div>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<div class='new_node_item_container' align='center' style='height:30px'>
							<input type='button' class='jqxbutton c_p' value='OK' onclick='addPayment()' style='margin:3px'/>
							<input type='button' class='jqxbutton c_p' value='Cancel' onclick='cancelPayment()' style='margin:3px'/>
						</div>	
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript" src="./../js/NovaPayment.js"></script>