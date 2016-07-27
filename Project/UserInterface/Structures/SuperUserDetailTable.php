<?php
/*
 * Author: Ankit
* date: 08-Aug-2014
* Description: This page is displayed on the customer menu for superuser
*/ 
?>
<table id="SuperUserTable" class="convertTojqGrid ui-grid-Font" url="Structures/ppuGridData.php?data=2" colNames=",User Name, Status, Organization, Registered By, Registered On, Type," colModel="SupercolModel" sortBy="UserID" gridComplete="SupercolModelFormatterFunction"></table>
<div id="gridpager_SuperUserTable"></div>
<script src="../js/SuperUser.js" type="text/javascript"></script>
	<div id="EditUserdiv" style="display:none;float: left; width:100%" align="center">
        <table class="column1_MyTable" cellpadding="3">
            <tr>
                <td>User &nbsp;</td>
                <td>
                    <div id="user_NAME" style="font-size:12px"></div>
                </td>
            </tr>
            <tr>
                <td>Status&nbsp;</td>
                <td>
                    <div id="user_STATUS" style="font-size:12px"></div>
                </td>
            </tr>
			<tr>
                <td>
                    Registering Authority&nbsp;
                </td>
                <td>
                    <input class="smallInputBox dimension_170x20" id="user_REGAUTH" />
                </td>
            </tr>  
            <tr>
                <td>Subscription&nbsp;</td>
                <td>
                    <div id="user_SUBS" style="font-size:12px"></div>
                </td>
            </tr>
            <tr>
	            <td>Features&nbsp;</td>
	            <td>
	           		<div id="user_FEAT" style="font-size:12px"></div>
	            </td>
            </tr>
            <tr>
            	<td>Credits&nbsp;</td>
            	<td>
	           		<input class="smallInputBox dimension_170x20" id="user_CREDIT" />            	
				</td>
			</tr>
			<tr>
				<td>Validity End Date&nbsp;</td>
            	<td>
	           		<div id="user_VALIDITY" style="font-size:12px"></div>            	
				</td>
			</tr>
			<tr>
				<td>Auto Renewal&nbsp;</td>
            	<td>
	           		<div id="user_RENEW" style="font-size:12px"></div>            	
				</td>
			</tr>
        </table>        
        <div align="center" style="position:absolute; bottom:10; margin-left:30%">
            <button class="mediumButton" id="confirmEditUser" type="button" onclick="edit_USER();">Confirm</button>
            <button class="mediumButton" id="cancelEditUser" type="button">Cancel</button>
        </div>
	</div>
	<div id="MailFormdiv" style="display:none;float: left; width:100%" align="center">
		<table class='set_font_12'>
			<tr>
				<td>To:</td>
				<td><span id='adminMailRecipient'></span></td>
			</tr>
			<tr>
				<td>Subject:</td>
				<td>
	    			<input type='text' class="input600x20" id='AdminMailSubject' />
				</td>
			</tr>
			<tr>
				<td>Description:</td>
				<td>
	    			<textarea style="resize:none;" class="largeTextAreaBox" id='AdminMailDescription' ></textarea>
				</td>
			</tr>
		</table>
        <div align="center" style="position:absolute; bottom:10; margin-left:30%; width: 50%">
            <button class="mediumButton" id="SendMail" type="button" onclick="send_Admin_Mail();">Send</button>
            <button class="mediumButton" id="cancelSendMail" type="button">Cancel</button>
        </div>
	</div>