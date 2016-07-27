<?php
/*
 * Author: Ankit
 * Date: 31-jul-2014
 * Description: This page will be displayed when the user click on the Reports menu option
 * 				
 */
?> 
<div id="usageReportTab" align="center" class="tabDiV" style="display: none;float: left;margin-top:10px">
   	<table id="UsageRepTable" class="convertTojqGrid ui-grid-Font" url="Structures/ppuGridData.php?data=4" colNames=", Job ID, File, Start Time (UTC), End Time, Features, User, Duration (min.), Charges" colModel="UsageRepColModel" sortBy="JobIndex" gridComplete="UsageRepColModelFormatterFunction"></table>
	<div id="gridpager_UsageRepTable"></div>
	<script src="../js/UsageRep.js" type="text/javascript"></script>
</div>
