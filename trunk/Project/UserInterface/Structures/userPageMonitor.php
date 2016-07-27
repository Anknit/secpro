<?php
$monitorView	=	DB_Read(array('Table'=>'operatorsettings','Fields'=>'monitorView','clause'=>'userId = '.$_SESSION['userID']),'ASSOC','');
$monitorView	=	$monitorView[0]['monitorView'];
if(isset($monitorView) && $monitorView == '2'){
	require_once('multiNodeMonitor.php');
}
else if(isset($monitorView) && $monitorView == '3'){
	require_once('hybridNodeMonitor.php');
}
else if(isset($monitorView) && $monitorView == '4'){
	require_once('hybrid2NodeMonitor.php');
}
else{
?>
<link rel="stylesheet" href="../../NOVA/css/commonLayout.css" type="text/css" />
<link rel="stylesheet" href="../../NOVA/css/gridLayout.css" type="text/css" />
<div id='HomePageMonitor' style='display:none' class='monitor_container tabDiV'><!--
	<div class="modal_div_1" id="FS_modal">
		<div class='windowHead'>
			&nbsp;
		</div>
		<div class='windowBody'>
			<table><tbody><tr><td><button type="button" id="fullScreenButton"> Enable Full Screen</button></td></tr></tbody></table>
		</div>
	</div>
	-->
<?php 
/*
	<a href='./UserPage.php?viewType=multi' style="  position: fixed; top: 15px; margin-left: 45%; text-align: center; text-decoration: underline;">Change View</a>*/
?>
	<div class="ChannelMonitorgridOuterDiv">
	<div id="ChannelMonitorgrid">
	</div>
	<div id='modalErrorInfo' onclick='hideChannelStatusInfo()'></div>
	<div id="channelInfoHoverDiv">
		<div class="ErrorInfoHeading">
			<div><span id='hoverDivChannelName'></span></div>
			<img src='../../Common/images/close.gif' class='c_p' onclick='hideChannelStatusInfo();' title='Close'/>
		</div>
		<div class="ErrorInfoContent">
			<table cellspacing="0" cellpadding="5">
				<thead>
					<tr>
						<th colspan="5">Total Errors: <span id='hoverDivChannelErrorCount'>0</span></th>
					</tr>
					<tr>
						<th>Profile Bitrate (Kbps)</th>
						<th>Error</th>
						<th>Start Time (UTC)</th>
						<th>Duration (sec)</th>
						<th>Message</th>
					</tr>
				</thead>
				<tbody id="channelInfoBody">
				</tbody>
			</table>
		</div>
	</div>
	</div>
</div>
<script src='./../js/gridMonitorMultiple.js' type="text/javascript"></script>
<script src='./../js/monitorPageupdate.js' type="text/javascript"></script>
<?php 
}
?>