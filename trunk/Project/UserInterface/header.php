<?php
/*
 * Author: Aditya
* date: 08-Aug-2014
* Description: Header html for all pages. to include top navigation menu, and all neccessary files
*/
    require_once __DIR__.'./../require.php';
    ob_start();
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../NOVA/css/style.css" type="text/css" />
	<script type="text/javascript" src="../../Common/js/jquery.js"></script>
	<script type="text/javascript" src="../../Common/js/jqx/jqxcore.js"></script>
	<script type="text/javascript" src="../../Common/js/jqx/jqxbuttons.js"></script>
	<script type="text/javascript" src="../../Common/js/jqx/jqxinput.js"></script>
	<script type="text/javascript" src="../../NOVA/js/spoofData.js"></script>
	<script type="text/javascript" src="../../NOVA/js/alertMessages.js"></script>
	<script type="text/javascript" src="../js/novaCommon.js"></script>
    <script type="text/javascript" src="../../Common/js/commonFunctions.js"></script>
    <title>Nova</title>
</head>
<body>
    <img id="LoadingImage" class="browseFrame" src="../../Common/images/aloader.gif" style="display:none;width:auto;background:transparent;z-index: 100000;border: none;border-radius: 0px;margin:auto" />
    <div id="LayOutDiv" style="background-color: rgb(255, 255, 255); position: absolute; top: 0px; z-index: 99999999; opacity: 0.3; display: none;width:100%;height:100%" ></div>
    
    <script type="text/javascript">
		var callBacksFirstLevel	= new Object();
		$(function(){
			ResizePage();
			loadImage();
		});
		var ResizePage = function(){
			var bodyHeight	=	$('body')[0].clientHeight;
			var HeaderHeight	=	$('.Header')[0].clientHeight;
			var FooterHeight	=	$('.Footer')[0].clientHeight;
			var allowedheight	=	bodyHeight-(HeaderHeight + FooterHeight);
			$('.CenterBody').css('height',allowedheight);
		    $('#contentPANE').css('height', allowedheight-34);
		}
    </script>
    <div class="CompletePage" style="visibility:hidden">	<!--Closed in footer.php-->

<?php // NEEDED TO HIDE LOGO ON OPERATOR PAGE
	if(isset($_SESSION['userTYPE']) && $_SESSION['userTYPE'] == OPERATOR){
?>
    <div class="Header" style="height:0px;">
    </div>
<?php		
	}
	else{
?>
    <div class="Header">
        <a class="NovaTagline" href='./UserPage.php'><img src="../images/Nova_2_40px.png" class="NovaLogo" alt="NOVA"/></a>
    </div>    
<?php } ?>
    <div class="CenterBody">
    <div class="GlobalInfoSection">
    	<div></div>
    </div>
    
    <?php
    $Elements_DisplayNone		=	array();
    $Elements_DisplayBlock		=	array();
    $Elements_DisplayTable		=	array();
    $Elements_CreateTooltip		=	array();
    $CustomHtml					=	array();
    $CustomData					=	array();
    $ElementsValue_ToAddSubMenu	=	array();
    
    if(isset($_SESSION['userID']) && $_SESSION['userID'] != ""){
        $Elements_DisplayBlock[]	=	'.GlobalProfileInfo';
    }
    ?>
