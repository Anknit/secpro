<?php
/*
 * Author: Nitin Aloria
 * Date: 28-July-2015
 * Description: This page is used for making Submenu for usage info reports.
 *
 */
?>
<div id='HomePageUsageInfo' style='display:none' class='container tabDiV'>
	<h3 style="  width: 98%;  margin: 15px auto;"> Usage Information</h3>
	<hr style="width: 98%;  margin: auto;">
	<div class='container_div'>
		<div>
			<table id="UsageInfoTable" class="convertTojqGrid ui-grid-Font" url="fetchData.php?data=usageinfo&act=grid" colNames=", Source Name, Usage Date, Start Time (UTC), End Time, Minutes Used" colModel="usageInfoColModel" sortBy="usageDate" gridComplete="usageInfoColModelFormatterFunction" gridWidth='0.97', gridHeight='0.75'></table>
			<div id="gridpager_UsageInfoTable"></div>
		</div>
		<div style="clear:both"></div>
	</div>
</div>
<script type="text/javascript" src="./../js/NovaUsageInfo.js"></script>