<?php
?>
<link rel="stylesheet" href="../../NOVA/css/commonLayout.css" type="text/css" />
<link rel="stylesheet" href="../../NOVA/css/multiLayout.css" type="text/css" />
<div id='HomePageMonitor' style='display:none;' class='monitor_container tabDiV'>
<?php 
/*
	<a href='./UserPage.php?viewType=multi' style="  position: fixed; top: 15px; margin-left: 45%; text-align: center; text-decoration: underline;">Change View</a>*/
?>
	<div id="ChannelMonitortable">
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
						<th style="width: 90px;">Profile Bitrate (Kbps)</th>
						<th style="width: 140px;">Error</th>
						<th style="width: 105px;">Start Time (UTC)</th>
						<th style="width: 70px;">Duration (sec)</th>
						<th style="width: 140px;">Message</th>
					</tr>
				</thead>
				<tbody id="channelInfoBody">
				</tbody>
			</table>
		</div>
	</div>
</div>
<script src='./../js/tableMonitorMultiple.js' type="text/javascript"></script>
<script src='./../js/monitorPageupdate.js' type="text/javascript"></script>
