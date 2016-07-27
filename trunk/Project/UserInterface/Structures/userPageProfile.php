<?php
/*
 * Author: Ankit
 * Date: 31-jul-2014
 * Description: This page will be displayed when the user click on the My Profile link
 * 				
 */
?> 
<div class="tabDiV" id= "personalInfoDiv" align="center" style="float: left;display: none; overflow:hidden;">
        <div style="float: left;padding:15px" ><b>My Profile</b></div>
        <hr style="margin-top: 50px; margin-left: 25px;color: #EEE;opacity: 0.3;">
        <div id="profileDetails" style="float: left">
            <table class = "detailsTable" cellspacing ="1px" style="border:1px solid #cacaca ; width: 600px;">
                <tr>
                    <td style="background-color: #eee"><b>Name</b></td>
                    <td id ="profileName"></td>
                </tr>
                <tr>
                    <td style="background-color: #eee"><b>Organization</b></td>
                    <td id ="profileOrg"></td>
                </tr>
                <tr>
                    <td style="background-color: #eee"><b>Website</b></td>
                    <td id ="profileWeb"></td>
                </tr>
                <tr>
                    <td style="background-color: #eee"><b>Address</b></td>
                    <td id ="profileAdd"></td>
                </tr>
                <tr>
                    <td style="background-color: #eee"><b>Email</b></td>
                    <td id ="profileEmail"></td>
                </tr>
                <tr>
                    <td style="background-color: #eee"><b>Mobile</b></td>
                    <td id ="profilePersP"></td>
                </tr>
                <tr>
                    <td style="background-color: #eee"><b>Phone</b></td>
                    <td id ="profileOffP"></td>
                </tr>
                <tr>
                    <td style="background-color: #eee"><b>Registered On</b></td>
                    <td id ="profileRegTime"></td>
                </tr>
                <tr>
                    <td style="background-color: #eee"><b>Registered By</b></td>
                    <td id ="profileRegAuth"></td>
                </tr>
                <tr>
                    <td colspan=2; align="center">
                        <button type="button" class="mediumButton" id="editProfileButton" onclick="editProfile();">Edit</button>		
                    </td>
                </tr>
            </table>
        </div>
    </div>