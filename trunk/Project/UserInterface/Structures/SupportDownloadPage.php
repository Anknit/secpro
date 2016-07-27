<?php
/*
 * Author: Ankit
 * Date: 31-jul-2014
 * Description: This page will be displayed when the user click on the Support menu option
 * 				
 */
?> 
<div id="supportDownloadDiv" class="tabDiV" style="display:none;float: left" align="center">
	<div align="left" style='margin-left:20px'>
		<h3>Downloads</h3>
		<hr width="98%">
	</div>
    <div id="installerDownload" class="SubHeadingDiv set_font_12" align='left'>
    	<table cellpadding ="10px" cellspacing='0px' class='table_borders'>
	    	<tr>
		    	<td style="border-right: 1px solid #eee">
		    		<span style="font-size:14px">Pulsar.exe</span>
		    	</td>
		    	<td>
			    	<a href="action/download.php?Request=1" title="Download Pulsar installer">
			    		<img src="../../Common/images/downRep.PNG" alt="Download Pulsar installer" width= "16px" height="18px"/>&nbsp;Download
			    	</a>
			    </td>
	    	</tr>
	    	<tr>
		    	<td style="border-right: 1px solid #eee">
		    		<span style="font-size:14px">Installation Guide</span>
		    	</td>
		    	<td title="Download Pulsar installation Guide" onclick="window.open('action/download.php?Request=2');" style="cursor:pointer">
                	<a href="#null">
                        <img src="../../Common/images/pdf.png" alt="Download Pulsar installation Guide" width= "16px" />&nbsp;View
                    </a>
		    	</td>
	    	</tr>
	    	<tr>
		    	<td style="border-right: 1px solid #eee">
			    	<span style="font-size:14px">Release Notes</span>
		    	</td>
		    	<td title="Download Pulsar Release Notes" onclick="window.open('action/download.php?Request=3');" style="cursor:pointer">
                	<a href="#null">
                        <img src="../../Common/images/pdf.png" alt="Download Pulsar Release Notes" width= "16px"/>&nbsp;View
                    </a>
		    	</td>
		    </tr>
    	</table>
    </div>
</div>