<?php
/*
 * Author: Ankit
 * Date: 31-jul-2014
 * Description: This page will be displayed when the user click on the Reports menu option
 * 				
 *
<div id="HomePageLayoutSetting" class="container tabDiV" style="display: none">
	<h3 style="  width: 98%;  margin: 15px auto;"> Layout Settings</h3>
	<hr style="width: 98%;  margin: auto;">
*/?> 
	<div class="modal_ui_blocker" id="layout-setting-modal">
		<div class='settingContainerForLayout' id='operatorMonitorSetting' >
			<table cellpadding="5" cellspacing="0" class="settingLayoutTable">
				<thead style='background-color:#aaa'>
					<tr>
						<th>Username</th>
						<th>Monitoring Layout</th>
					</tr>
				</thead>
				<tbody>
					<tr class='noOperatorInitMsg' style='display:none'>
						<td colspan="2" style='color: red;text-align:center'>You do not have any operators for source monitoring.</td>
					</tr>
				</tbody>
			</table>
			<div style='text-align:center;margin-top:5px;display:none;'>
				<input class='jqxbutton c_p' title='save layout settings' type='button' value='Save' onclick='saveLayoutSettings()' />
				<input class='jqxbutton c_p' title='cancel layout settings' type='button' value='Cancel' onclick='hideLayoutPopup()' />
			</div>
		</div>
	</div>
<script type="text/javascript" src="./../js/NovaLayoutSettings.js"></script>
<?php
/*
</div>
*/
?>