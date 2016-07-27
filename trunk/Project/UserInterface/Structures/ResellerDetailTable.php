<?php
/*
 * Author: Ankit
* date: 08-Aug-2014
* Description: This page is displayed on the customer menu when the user is a reseller
*/ 
?>
<table id="ResellerUserTable" class="convertTojqGrid ui-grid-Font" url="Structures/ppuGridData.php?data=2" colNames=",User Name, Name, Status,Organisation, Registered On, Credits($)" colModel="SalescolModel" sortBy="UserID" gridComplete="salescoModelFormatterFunction"></table>
<div id="gridpager_ResellerUserTable"></div>
<script src="../js/ResellerUser.js" type="text/javascript"></script>