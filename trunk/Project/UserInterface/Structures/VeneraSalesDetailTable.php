<?php
/*
 * Author: Ankit
* date: 08-Aug-2014
* Description: This page is displayed on the customer menu when the user is a Venera sales person or superuser
*/ 
?>
<table id="SalesUserTable" class="convertTojqGrid ui-grid-Font" url="Structures/ppuGridData.php?data=2" colNames=",User Name, Name, Status, Organization, Registered By, Registered On, Account Type, Credits($)," colModel="SalescolModel" sortBy="UserID" gridComplete="salescoModelFormatterFunction"></table>
<div id="gridpager_SalesUserTable" class="fontsGridPager"></div>
<script src="../js/SalesUser.js" type="text/javascript"></script>