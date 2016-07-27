<?php
/*
 * Author: Nitin Aloria
 * Date: 01-October-2015
 * Description: This page is used for making Submenu for operator login details.
 *
 */
?>
<div id='HomePageLoginDetails' style='display:none' class='container tabDiV'>
	<h3 style="  width: 98%;  margin: 15px auto;">Login Details</h3>
	<hr style="width: 98%;  margin: auto;">
	<div class='container_div'>
		<div>
			<table id="LoginDetailsTable" class="convertTojqGrid ui-grid-Font" url="fetchData.php?data=logindetails&act=grid" colNames=", Operator Name, Operator Email, Login Time (UTC), Duration" colModel="loginDetailsColModel" sortBy="sessionPrimaryKey" sortOrder="desc" gridComplete="loginDetailsColModelFormatterFunction" gridWidth='0.97', gridHeight='0.75'></table>
			<div id="gridpager_LoginDetailsTable"></div>
		</div>
		<div style="clear:both"></div>
	</div>
</div>
<script type="text/javascript" src="./../js/NovaLoginDetails.js"></script>