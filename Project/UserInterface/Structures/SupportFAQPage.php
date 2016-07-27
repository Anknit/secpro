<?php
/*
 * Author: Ankit
 * Date: 31-jul-2014
 * Description: This page will be displayed when the user click on the Support menu option
 * 				
 */
?> 
<div id="supportFAQDiv" class="tabDiV" style="display:none;float: left" align="center">
	<div align="left" style='margin-left:20px'>
		<h3>FAQ</h3>
		<hr width="98%">
	</div>
	<div class='container_FAQ' align='left'>
		<div class='ques_FAQ' align='justify'>
			<div class='ques_text'>When I start the ‘Pulsar Controller’, I get a message saying ‘Dongle not found’. How do I resolve this issue?</div>
		</div>
		<div class='ans_FAQ' align='justify'>
			<div class='ans_text'>
				We are using an integrated installer for the Pulsar Pay-Per-Use and the other editions requiring a hardware dongle. Pulsar Pay-Per-Use doesn’t require a USB hardware dongle however you must do the following before starting the ‘Pulsar Controller’ application.<br /><br />1. Exit both the ‘Pulsar Controller’ and ‘Pulsar Verification Unit’ applications from the task bar.<br />2. Go to Pulsar home-page. This will typically be http://localhost or http://localhost:81 depending on the port available during installation. You can also use the ‘Open Interface’ option in the Windows Start Menu.<br />3. Login to Pulsar using your Pulsar portal credentials. Ensure that your machine is connected to Internet when you do this.<br />4. Start the ‘Pulsar Controller’ and ‘Pulsar Verification Unit’ using the desktop or the Start Menu icon.<br />5. Both should start normally now. If not, please send us a support request using the support form in the Pulsar portal.
			</div>
		</div>
		<div class='ques_FAQ' align='justify'>
			<div class='ques_text'>I moved my Pulsar PPU installer to a different machine and now seeing the error “SUID mismatch in license database”. How do I resolve this issue?</div>
		</div>
		<div class='ans_FAQ' align='justify'>
			<div class='ans_text'>
				Within Pulsar PPU, each user is hard linked to a particular machine on which you started using Pulsar. If you try to use the same user from another machine then you will see this error. If you indeed need to move the user to a new machine then send us an inquiry using the support form in the Pulsar portal and we will reset the SUID for you. Once done, you will be able to work with this Pulsar user on the new machine. This process needs to be done whenever you need to change the machine for a particular user.
			</div>
		</div>
	</div>
</div>