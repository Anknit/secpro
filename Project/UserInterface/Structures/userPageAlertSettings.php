<?php
/*
 * Author: Nitin Aloria
* Date: 05-October-2015
* Description: This page will be displayed when the user clicks on the alert settings sub-menu option
*
*/
?>
<div id="HomePageAlertSettings" class="container tabDiV" style="display: none">
	<h3 style="  width: 98%;  margin: 15px auto;"> Automated Alert Settings</h3>
	<hr style="width: 98%;  margin: auto;">
	<div class='settingContainer'>
		<table cellpadding="5">
			<tr>
				<td>Email Report Frequency (1 - 60 minutes)</td>
				<td>
					<input id="alertFrequency" type="number" name="alertFrequency" min="1" max="60" />
				</td>
			</tr>
			<tr>
				<td>Error Threshold (1 - 100)</td>
				<td>
					<input id="errorThreshold" type="number" name="errorThreshold" min="1" max="100" />
				</td>
			</tr>
			<tr>
				<td>Recipents Email ID (If Any)</td>
				<td>
					<input id="errorAlertEmail" type="email" name="errorAlertEmail" />
				</td>
			</tr>
			<tr>
				<td align='right'>
					<input class='jqxbutton c_p' title='Save alert settings' type='button' value='Save' onclick='saveAutoAlertSettings()' />
				</td>
			</tr>
		</table>
	</div>
</div>
<script type="text/javascript" src="./../js/NovaAlertSettings.js"></script>