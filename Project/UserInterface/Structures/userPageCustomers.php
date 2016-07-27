<?php
?>
<div id='HomePageCustomers' style='display:none' class='container tabDiV'>
	<div class='container_div menu_container'>
		<div class='item_container_div f_l'>
			<div class='menu_item'>
				<input type='button' class='jqxbutton c_p' value='Add' title="Add New Customer" onclick='openNewItemForm(this)' openDivID='user_add_form'/>
			</div>
		</div>
		<div class='item_container_div f_l'>
			<div class='menu_item'>
				<input type='button' class='jqxbutton menu_item_disable c_p' title="Remove Customer" value='Remove' disabled="disabled" onclick='deleteUser()'/>
			</div>
		</div>
		<div class='item_container_div f_l'>
			<div class='menu_item'>
				<input type='button' class='jqxbutton menu_item_disable c_p hide' style='display:none' title="Deactivate Customer account" value='Deactivate' disabled="disabled" onclick='changeAccountStatus()'/>
			</div>
		</div>
	</div>
	<hr />
	<div class='container_div'>
		<div>
			<table id="UserTable" class="convertTojqGrid ui-grid-Font" url="fetchData.php?data=user&act=grid" colNames=", Username, Account Status, Registered On, Registered By, Credit Minutes, Usage Minutes, Account Expiry Date" colModel="userColModel" sortBy="userId" gridComplete="userColModelFormatterFunction" gridWidth='0.97', gridHeight='0.75'></table>
			<div id="gridpager_UserTable"></div>
		</div>
		<div style="clear:both"></div>
	</div>
	<div id='user_add_form' class='modal_div'>
		<div class='windowHead'>
			Add User
		</div>
		<div class='windowBody'>
			<table>
				<tr>
					<td>Email</td>
					<td>
						<input type='text' name='newUserEmail' id='newUserEmail' title="Enter a valid email" />
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<div align='center' style='height:30px'>
							<input type='button' class='jqxbutton c_p' value='OK' onclick='addUser()' style='margin:3px'/>
							<input type='button' class='jqxbutton c_p' value='Cancel' onclick='cancelNewUser()' style='margin:3px'/>
						</div>	
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript" src="./../js/NovaCustomer.js"></script>