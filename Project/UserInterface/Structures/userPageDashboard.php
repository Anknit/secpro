<?php ?>
<div id='HomePageDashboard' class='container tabDiV' style='display:none;  width: 98%;  margin: auto;'>
	<div id="DashboardInput">
		<select id="channelsList" style="display:none">
			<option value="0">All</option>
		</select>
		<span class="inputLabel">Select sources</span>
		<div id="channelsListDropDown"></div>
		<span class="inputLabel">Start time</span>
		<div class="dateTimeInput" id="dashboardStartTime"></div>
		<span class="inputLabel">End time</span>
		<div class="dateTimeInput" id="dashboardEndTime"></div>
		<button class="jqxbutton c_p" id="dashboardReportButton" onclick="generateDashBoardReport();" style="float:left;margin:15px;">View Report</button>
		<button class="jqxbutton c_p" title='Export Dashboard Report' id='dashboardReportExportIcon' style="display:none;float:left;margin:15px;" onclick="exportJQGrid('DashboardReportTable', 'Dashboard Report');" >Export</button>
	</div>
	<table id="DashboardReportTable" class="ui-grid-Font" url="fetchData.php?data=dash&act=grid" colNames="Source, Profile Bitrate (Kbps), Error, Start Time (UTC), Duration(sec), Message" colModel="dashboardColModel" sortBy="Channel" gridComplete="dashboardColModelFormatterFunction" gridWidth='0.97' gridHeight='0.75' gridRowListValues='20,50,100'></table>
	<div id="gridpager_DashboardReportTable"></div>
</div>
<script type="text/javascript" src="./../js/NovaDashboard.js"></script>