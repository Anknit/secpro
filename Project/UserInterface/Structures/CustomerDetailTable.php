<?php
/*
 * Author: Ankit
* date: 08-Aug-2014
* Description: This page is displayed on the subscription menu when the user is a customer(Account Manager)
*/ 
?>
<table id="CustomerUserTable" class="convertTojqGrid ui-grid-Font" url="Structures/ppuGridData.php?data=2" colNames=",User Name, Name, Status, Plan, Add-on Features, Auto Renewal, Renewal Date," colModel="SalescolModel" sortBy="userinfo.UserID" gridComplete="salescoModelFormatterFunction"></table>
<div id="gridpager_CustomerUserTable"></div>
<script src="../js/CustomerUser.js" type="text/javascript"></script>