<?php
/*
 * Author: Ankit
 * Date: 31-jul-2014
 * Description: This page will be displayed only to the Super User under the System menu option
 * 				
 */
?> 
<div id="SMTPdiv" class="tabDiV" style="display:none; float: left">
	<div align="left" style="margin-left:20px">
		<h3>System settings</h3>
		<hr width="98%">
	</div>
	<div style="width:100%;float:left;margin-left:20px;margin-top:20px">
        <div style="float:left">
            <table class="tableBorder1" cellpadding="3" cellspacing="3">
                <caption>
                    <b><font color="#444">Smtp settings</font></b>
                    
                </caption>
                <tr>
                    <td align="right" width="35%">
                        SMTP Host
                        <font color="red">* </font>
                    </td>
                    <td colspan="2" align="left">&nbsp;&nbsp;
                        <input class="mediumInputBox input200x20" name="smtpHostName" id="smtpHostName" type="text" />
                        <a href="#null" title="Enter the SMTP Host URL.&#13; i.e. mail.domainname.domaintype. IP address is also acceptable">[?]</a>
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        Port Number
                        <font color="red">* </font>
                    </td>
                    <td colspan="2" align="left">&nbsp;&nbsp;
                        <input class="mediumInputBox input200x20" name="SmtpPortNumber" id="SmtpPortNumber" maxlength="3" type="text">
                        <a href="#null" title="SMTP server port number">[?]</a>
                    </td>
                </tr>
                <tr>
                    <td align="right"><br /></td>
                    <td colspan="2" align="left"><br />&nbsp;&nbsp;<b><font color="#444">Sender's Information</font></b></td>
                </tr>	
                <tr>
                    <td align="right">
                        From
                        <font color="red">* </font>
                    </td>
                    <td colspan="2" align="left">&nbsp;&nbsp;
                        <input class="mediumInputBox input200x20" name="SmtpSenderName" id="SmtpSenderName" maxlength="50" type="text" />
                        <a href="#null" title="Account from which the email will be sent. This could either be an email address or a display name &#13;Blank spaces are not allowed in display name">[?]</a>
                    </td>
                </tr>	
                <tr>
                    <td align="right"><br /></td>
                    <td colspan="2" align="left"><br />&nbsp;&nbsp;<b><font color="#444">Authentication Information</font></b></td>
                </tr>
                <tr>
                    <td align="right">Username</td>
                    <td colspan="2" align="left">&nbsp;&nbsp;
                        <input class="mediumInputBox input200x20" name="smtpUserName" id="smtpUserName" maxlength="50" type="text" />
                        <a href="#null" title="User name for authentication">[?]</a>
                    </td>
                </tr>	
                <tr>
                    <td align="right">Password</td>
                    <td colspan="2" align="left">&nbsp;&nbsp;
                        <input class="mediumInputBox input200x20" name="smtpPassword" id="smtpPassword" maxlength="50" type="password" />
                        <a href="#null" title="Password for authentication">[?]</a>
                    </td>
                </tr>	
                <tr>
                    <td align="right">Confirm Password</td>
                    <td colspan="2" align="left">&nbsp;&nbsp;
                        <input class="mediumInputBox input200x20" name="smtpRetypePassword" id="smtpRetypePassword" maxlength="50" type="password" />
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center">&nbsp;</td>
                </tr>	
                <tr>
                    <td colspan="3" align="center">
                        <button type="button" class="mediumButton" name="Save" id="Save" onclick="SuperUser.SubmitSMTP();">Save</button>
                    </td>
                </tr>
            </table>
        </div>
        <div align="center" style="float:left;width:350px;margin-left:40px">
            <table align="center" class="tableBorder1" cellpadding="3" cellspacing="3" width="100%">
                <caption>
                    <b><font color="#444">System support email address</font></b>
                </caption>
                <tr>
                    <td align="right" width="30%">
                        Email
                        <font color="red">* </font>
                    </td>
                    <td colspan="2" align="left">&nbsp;&nbsp;
                        <input class="mediumInputBox input200x20" name="supportEmailID" id="supportEmailID" type="text" />
                        <a href="#null" title="Enter the email address to which the support requests should be mailed">[?]</a>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        <button type="button" class="mediumButton" name="SaveSupportEmailID" id="SaveSupportEmailID" onclick="SuperUser.saveSupportEmailID();">Save</button>
                    </td>
                </tr>
            </table>
        </div>
        <div align="center" style="float:left;width:200px">
            <table align="center" class="tableBorder1" cellpadding="3" cellspacing="3">
                <caption>
                    <b><font color="#444">Download/Backup database</font></b>
                </caption>
                <tr>
                    <td align="center">
                         <a href="#" id="dbBackupLink" onclick="SuperUser.downloadMysqlbackup();">Click to download Database</a>
                   </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript" src="../js/SuperUser.js" ></script>