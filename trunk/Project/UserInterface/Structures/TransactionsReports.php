<?php
/*
 * Author: Ankit
 * Date: 31-jul-2014
 * Description: This page will be displayed when the user click on the Reports menu option
 * 				
 */
?> 
<div id="transReportTab" align="center" class="tabDiV" style="display: none;float: left;margin-top:10px">
   	<table id="TransRepTable" class="convertTojqGrid ui-grid-Font" url="Structures/ppuGridData.php?data=3" colNames=", , Transaction ID, Amount , Date, User, Payment Mode, Payment Mode ID, " colModel="TransRepColModel" sortBy="PaymentIndex" gridComplete="TransRepColModelFormatterFunction"></table>
	<div id="gridpager_TransRepTable"></div>
	<script src="../js/TransRep.js" type="text/javascript"></script>
	<script src="../js/InvoiceGeneration.js" type="text/javascript"></script>
</div>
