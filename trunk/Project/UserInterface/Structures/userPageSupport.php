<?php
/*
 * Author: Ankit
 * Date: 31-jul-2014
 * Description: This page will be displayed when the user click on the Support menu option
 * 				
 */
?> 
<div id="supportTab" class="tabDiV" align="left" style="display:none;float: left">
	<div align="left" style='margin-left:20px'>
		<h3>Inquiry Form</h3>
		<hr width="98%">
	</div>
	<div id='supportSeekingForm' align='left'  class='set_font_12'>
	    <table cellspacing='5px'  class='set_font_12'>
	    	<tr>
	    		<td class='rightAlign'>
	    			Category<span style="color: red"><sup>*</sup></span>
	    		</td>	
	    		<td>
	    			<div id='supportFormSubject' title= '<?php echo TITLE30;?>' class='set_font_12'></div> 
	    		</td>
	    		<td class='rightAlign'>
	    			Pulsar Version<span style="color: red"><sup>*</sup></span>
	    		</td>	
	    		<td style='width:175px' class='rightAlign'>
	    			<input id='supportFormVersion' title= '<?php echo TITLE31;?>' class='set_font_12 mediumInputBox' /> 
	    		</td>
	    	</tr>
	    	<tr>
	    		<td class='rightAlign'>
	    			Summary<span style="color: red"><sup>*</sup></span>
	    		</td>	
	    		<td colspan="3">
	    			<input type='text' title= '<?php echo TITLE32;?>' class="input600x20" id='supportFormSummary' />
	    		</td>
	    	</tr>
	    	<tr>
	    		<td class='rightAlign' style='vertical-align: top'>
	    			Detailed Description<span style="color: red"><sup>*</sup></span>
	    		</td>	
	    		<td colspan="3">
	    			<textarea style="resize:none;" title= '<?php echo TITLE33;?>' class="largeTextAreaBox" id='supportFormDescription' ></textarea>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td class='rightAlign'>
	    			Attachment
	    		</td>	
	    		<td colspan="3">
	    			<input type='file' class="input200x20" name='supportAttachement' title= '<?php echo TITLE34;?>' id='supportFormAttachment' />
	    		</td>
	    	</tr>
	    </table>
	    <div align="center" style="margin-top:10px">
			<button type="button" class="mediumButton" id='supportFormSubmit'>Submit</button>
	    </div>
	</div>
	<div align="left" id= 'supportSubmitStatus'>
	</div>
	<div id='postSupportActions' align='center'>
		<button type="button" class="mediumButton" id='closeSupportstatus'>Close</button>
<!-- <button type="button" class="mediumButton" id='newSupportForm'>New Request</button>
 -->			</div>
</div>
