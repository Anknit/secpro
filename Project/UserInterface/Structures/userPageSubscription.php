<?php
/*
 * Author: Ankit
 * Date: 31-jul-2014
 * Description: This page will be displayed when account manager click on the Subscriptions menu option 
 * 				or when other users click on the Customers menu option
 * 				
 */
?> 
<div id="myUsersSubscription" class="tabDiV" align="center" style="display:none;float: left; margin-top:10px; ">
<?php 
if($_SESSION['userTYPE'] == CUSTOMER){
	require_once 'CustomerDetailTable.php';
}
elseif ($_SESSION['userTYPE'] == VENERA_SALES ){
	require_once 'VeneraSalesDetailTable.php';
}
elseif ($_SESSION['userTYPE'] == RESELLER){
	require_once 'ResellerDetailTable.php';
}
elseif ($_SESSION['userTYPE'] == SUPERUSER){
	require_once 'SuperUserDetailTable.php';
}?>
	<div id="addNewUserButton" class="minimumMargins">
		<button type="button" class="mediumButton" title="Add new user" id="jqgridadduserbutton">Add</button>
    </div>    
    <div id="NewUserdiv" style="display: none; float: left; width:100%; text-align:center" align="center">
   		<table cellpadding="2" cellspacing="0" style="font-family:Arial; font-size:12px; margin-top:5px">
            <tr class="usrtyperow">
                    <td>
                    	User Type<span style="color:red"><sup>*</sup></span>
                    </td>
                    <td>
                        <select id="usertype" customDropDownId="usertypeoption" width="175" dropDownHeight="80" style='display: none'>
                            <option value="2">Reseller</option>
                            <option value="3">Customer</option>
<?php if ($_SESSION['userTYPE'] == SUPERUSER){ ?>
                            <option value="5">Sales</option>
<?php }?>                            
                            <option value="6">Representative</option>
                        </select>
                    </td>
            </tr>
            <tr>
                <td width="30%">
                    Email<span style="color:red"><sup>*</sup></span>
                </td>
                <td>
                    <input name="type" type="hidden" id="type">
                    <input name="email" type="email" id="email" class="mediumInputBox"> 
                </td>
            </tr>
           <tr id="demoCreditsRow">
	            <td width="30%">
                    Demo credits
                </td>
                <td title="<?php echo TITLE36; ?>">
                    <div class="convertToJqxCheckBox" name="checkDemoCredits" id="checkDemoCredits"></div>
                </td>
            </tr>
         </table>
        <div align="center" style="position:absolute; bottom:10; margin-left:20%">
            <button class="mediumButton" id="addButton" type="button" onclick="addUser();">OK</button>
            <button class="mediumButton" id="cancelAddUser" type="button">Cancel</button>
        </div>
	</div>
	<div id="DeleteUserDiv" style="display: none; float: left; width:100%" align="center">
		<span style="font-size:14px; font-style:Arial">Are you sure you want to delete this user ?</span><br /><br />
	    <button id="deleteButton" class="mediumButton" type="button" onclick="deleteUser();">Delete</button>
	    <button id="canceldeleteUserButton" class="mediumButton" type="button">Cancel</button>
 	</div>
</div>