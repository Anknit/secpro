<?php
/*
 * Author: Ankit
 * Date: 31-jul-2014
 * Description: This page will be displayed when the user click on the Reports menu option
 * 				
 */
?> 
<div id="HomePageAutoReport" class="container tabDiV" style="display: none">
	<h3 style="  width: 98%;  margin: 15px auto;"> Automated Report Settings</h3>
	<hr style="width: 98%;  margin: auto;">
	<div class='settingContainer'>
		<table cellpadding="5">
			<tr>
				<td>Email report frequency</td>
				<td>
					<select id='autoReportFrequency' class='customSelectBox'>
						<option value="3"> Every 3 hours</option>
						<option value="6"> Every 6 hours</option>
						<option value="12"> Every 12 hours</option>
						<option value="24"> Every 24 hours</option>
					</select>
				</td>
			</tr>
			<tr id='autoReportInitMsg' class='noOperatorInitMsg' style='display:none'>
				<td colspan="2" style='color: red;text-align:center'>You do not have any operators for source monitoring.</td>
			</tr>
			<tr>
				<td align='right'>
					<input class='jqxbutton c_p' title='save report settings' type='button' value='Save' onclick='saveAutoReportSettings()' />
				</td>
				<td></td>
			</tr>
		</table>
	</div>
</div>
<script type="text/javascript" src="./../js/NovaReport.js"></script>