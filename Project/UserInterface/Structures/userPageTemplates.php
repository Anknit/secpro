<?php ?>
<div id='HomePageTemplates' style='display:none' class='container tabDiV'>
	<div class='container_div menu_container'>
		<div class='item_container_div f_l'>
			<div class='menu_item'>
				<input type='button' class='jqxbutton c_p' value='Add' title="Add new Monitor setting" onclick='openNewItemForm(this)' openDivID='templateForm'/>
			</div>
		</div>
		<div class='item_container_div f_l'>
			<div class='menu_item'>
				<input type='button' class='jqxbutton menu_item_disable c_p' value='Edit' title="Edit Monitor setting" disabled="disabled" onclick='editTemplate()'/>
			</div>
		</div>
		<div class='item_container_div f_l'>
			<div class='menu_item'>
				<input type='button' class='jqxbutton menu_item_disable c_p' value='Remove' title="Remove Monitor setting" disabled="disabled" onclick='deleteTemplate()'/>
			</div>
		</div>
	</div>
	<hr />
	<div class='container_div'>
		<div>
			<table id="TemplateTable" class="convertTojqGrid ui-grid-Font" url="fetchData.php?data=template&act=grid" colNames=", Name, Description" colModel="templateColModel" sortBy="templateId" gridComplete="templateColModelFormatterFunction" gridWidth='0.97', gridHeight='0.75'></table>
			<div id="gridpager_TemplateTable"></div>
		</div>
		<div style="clear:both"></div>
	</div>
	<div id='templateForm'>
		<div class='windowHead'>
			Add setting
		</div>
		<div class='windowBody'>
			<form style='max-height:88%; overflow:auto;'>
				<div class='item_Row' style='height:50px;'>
					<div class='item textInline'>
						Name
					</div>
					<div class='item'>
						<input type='text' name='TemplateName' id='TemplateName' title='Name of Monitor setting' />
					</div>
					<div class='item textInline'>
						Description
					</div>
					<div class='item'>
						<textarea name='TemplateDescription' id='TemplateDescription' title='Description of Monitor setting' ></textarea>
					</div>
				</div>
	
<!--			<div class='item_Row'>
					<div class='item'>
						<input type='checkbox' name='blackFrameDetection' id='blackFrameDetection' />
					</div>
					<div class='item'>
						Black Frame
					</div>
					<div class='item bind_hidden'>
						Duration
					</div>
					<div class='item bind_hidden'>
						<input class='checkVal' type='number' min='0' name='blackFrameDuration' id='blackFrameDuration' xmlName='Duration' templateErrorMessage='1'/>
					</div>
					<div class='item bind_hidden'>
						Seconds
					</div>
				</div>
				
 				<div class='item_Row'>
					<div class='item'>
						<input type='checkbox' name='freezeFrameDetection' id='freezeFrameDetection' />
					</div>
					<div class='item'>
						Freeze Frame
					</div>
					<div class='item bind_hidden'>
						Duration
					</div>
					<div class='item bind_hidden'>
						<input class='checkVal' type='number' min='0' name='freezeFrameDuration' id='freezeFrameDuration' xmlName='Duration' templateErrorMessage='2' />
					</div>
					<div class='item bind_hidden'>
						Seconds
					</div>
				</div>
	
				<div class='item_Row'>
					<div class='item'>
						<input type='checkbox' name='solidColorDetection' id='solidColorDetection' />
					</div>
					<div class='item'>
						Solid color
					</div>
					<div class='item bind_hidden'>
						Duration
					</div>
					<div class='item bind_hidden'>
						<input class='checkVal' type='number' min='0' name='solidColorDuration' id='solidColorDuration' xmlName='Duration' templateErrorMessage='3' />
					</div>
					<div class='item bind_hidden'>
						Seconds
					</div>
				</div>
	
				<div class='item_Row'>
					<div class='item'>
						<input type='checkbox' name='muteDetection' id='muteDetection' />
					</div>
					<div class='item'>
						Mute
					</div>
					<div class='item bind_hidden'>
						Duration
					</div>
					<div class='item bind_hidden'>
						<input class='checkVal' type='number' min='0' name='muteDuration' id='muteDuration' xmlName='Duration' templateErrorMessage='4' />
					</div>
					<div class='item bind_hidden'>
						Seconds
					</div>
				</div>
	
				<div class='item_Row'>
					<div class='item'>
						<input type='checkbox' name='silenceDetection' id='silenceDetection' />
					</div>
					<div class='item'>
						Silence
					</div>
					<div class='item bind_hidden'>
						Duration
					</div>
					<div class='item bind_hidden'>
						<input class='checkVal' type='number' min='0' name='silenceDuration' id='silenceDuration' xmlName='Duration' templateErrorMessage='5' />
					</div>
					<div class='item bind_hidden'>
						Seconds
					</div>
				</div>
 -->		
				<div class='item_Row'>
					<div class='item'>
						<input type='checkbox' name='avSignalDrop' id='avSignalDrop' disabled="disabled" checked="checked"/>
					</div>
					<div class='item textInline'>
						Audio-Video signal drop
					</div>
					<div class='item textInline'>
						Duration
					</div>
					<div class='item'>
						<input class='checkVal' type='number' min='1' name='avSignalDropDuration' id='avSignalDropDuration' xmlName='duration' templateErrorMessage='17' value='1' />
					</div>
					<div class='item textInline'>
						Seconds
					</div>
					<div style='float:left; margin-top:3px;'>
						<a href="#null" title="<?php echo M_Title_1?>">[?]</a>
					</div>
				</div>

				<div class='item_Row'>
					<div class='item'>
						<input type='checkbox' checked='checked' disabled='disabled' name='fileIntegrity' id='fileIntegrity' />
					</div>
					<div class='item textInline'>
						File Integrity
					</div>
					<div style='float:left; margin-top:3px;'>
						<a href="#null" title="<?php echo M_Title_2?>">[?]</a>
					</div>
					<div class='bind_hidden' style="width: 95%; margin-left: 25px; display:block;">
						<div class='item_Row'>
							<div class='item'>
								<input class='checkVal' type='checkbox' checked='checked' disabled='disabled' name='missingProfile' id='missingProfile' xmlName='missingProfile' />
							</div>
							<div class='item textInline'>
								Profile Missing
							</div>
							<div style='float:left; margin-top:3px;'>
								<a href="#null" title="<?php echo M_Title_3?>">[?]</a>
							</div>
						</div>
						<div class='item_Row'>
							<div class='item'>
								<input class='checkVal' type='checkbox' checked='checked' disabled='disabled' name='missingSegment' id='missingSegment' xmlName='missingSegment' />
							</div>
							<div class='item textInline'>
								Segment Missing
							</div>
							<div style='float:left; margin-top:3px;'>
								<a href="#null" title="<?php echo M_Title_4?>">[?]</a>
							</div>
						</div>
						<div class='item_Row'>
							<div class='item'>
								<input class='checkVal' type='checkbox' checked='checked' disabled='disabled' name='invalidSegment' id='invalidSegment' xmlName='invalidSegment' />
							</div>
							<div class='item textInline'>
								Invalid Segment Order
							</div>
							<div style='float:left; margin-top:3px;'>
								<a href="#null" title="<?php echo M_Title_5?>">[?]</a>
							</div>
						</div>
						<div class='item_Row' style='margin:2px'>
							<div class='item'>
								<input class='checkVal' type='checkbox' checked='checked' disabled='disabled' name='indexFileDoesNotRefresh' id='indexFileDoesNotRefresh' xmlName='indexFileDoesNotRefresh' />
							</div>
							<div class='item textInline'>
								Index File not refreshing
							</div>
							<div style='float:left; margin-top:3px;'>
								<a href="#null" title="<?php echo M_Title_6?>">[?]</a>
							</div>
						</div>
					</div>
				</div>

				<div class='item_Row' style='float:left;'>
					<div class='item'>
						<input type='checkbox' class='TemplateCheckException' name='loudnessDetection' id='loudnessDetection' validateCheckFunction='loudnessCheckValidate' />
					</div>
					<div class='item textInline'>
						Loudness
					</div>
					<div class='bind_hidden item' style="width: 80%; margin-left: 5%; padding-top:0px;">
						<div style="border-bottom: 1px solid #ccc; padding: 5px 0px; float: left;width: 100%;margin-bottom: 5px;">
							<div class='item textInline'>
								<span style='margin-right: 5px; margin-left: -15px;'>Mode</span>
								<select class='checkVal' name='loudnessDetectionMode' id='loudnessDetectionMode' xmlName='Mode' >
									<option value='1'>EBU</option>
									<option value='2'>ATSC</option>
								</select>
							</div>
							<div style='float:left; margin-top:3px;'>
								<a href="#null" title="<?php echo M_Title_7?>">[?]</a>
							</div>
						</div>
						<br />
						<div id='EBU_paramTable' class='loudnessParamTable' loudnessType='1'>
							<table cellspacing="0" cellpadding="2">
								<thead>
									<tr>
										<th>
											<div style="margin: auto;width: 80%;">
												<div style='float: left;margin-right: 5px;'>
													<img src="../../Common/images/add.ico" class="c_p" onclick="ebuParamRow();" style="margin: 0px 5px; vertical-align: sub;"/>
													Timescale
												</div>
												<div style='float:left; margin-top:3px;'>
													<a href="#null" title="<?php echo M_Title_8?>">[?]</a>
												</div>
											</div>
										</th>
										<th colspan="2">
											<div style="margin: auto;width: 60%;">
												<div style='float: left;margin-right: 5px;margin-top:3px'>
													Max Loudness
												</div>
												<div style='float:left; margin-top:3px;'>
													<a href="#null" title="<?php echo M_Title_9?>">[?]</a>
												</div>
											</div>
										</th>
										<th colspan="2">
											<div style="margin: auto;width: 60%;">
												<div style='float: left;margin-right: 5px;margin-top:3px'>
													Min Loudness
												</div>
												<div style='float:left; margin-top:3px;'>
													<a href="#null" title="<?php echo M_Title_10?>">[?]</a>
												</div>
											</div>
										</th>
										<th></th>
									</tr>
									<tr>
										<th>&nbsp;</th>
										<th>Level</th>
										<th>Tolerance</th>
										<th>Level</th>
										<th>Tolerance</th>
										<th>&nbsp;</th>
									</tr>
								</thead>
								<tbody class='loudnessTableBody' align="center" mode="1">
									<tr>
										<td>
											<select class='checkVal' name='EBU_timescaleSelect' id='EBU_timescaleSelect' xmlName='EBUTimescale' >
												<option value='1'>Momentary(M)</option>
												<option value='2'>Short-term(S)</option>
											</select>
										</td>
										<td>
											<select class='checkVal' name='EBU_maxLoudSign' id='EBU_maxLoudSign' xmlName='EBUmaxLevelSign' >
												<option value='1'>-</option>
												<option value='2'>+</option>
											</select>
											<input type="number" min="0" name="EBU_maxLoudLevel" id="EBU_maxLoudLevel" class="size_s checkVal" xmlName='EBUmaxLoudLevel' templateErrorMessage='7' />
										</td>
										<td>
											<input type="number" min="0" name="EBU_maxLoudTolerance" id="EBU_maxLoudTolerance" class="size_s checkVal" xmlName='EBUmaxLoudTolerance' templateErrorMessage='8' />
										</td>
										<td>
											<select class='checkVal' name='EBU_minLoudSign' id='EBU_minLoudSign' xmlName='EBULevelSign' >
												<option value='1'>-</option>
												<option value='2'>+</option>
											</select>
											<input type="number" min="0" name="EBU_minLoudLevel" id="EBU_minLoudLevel" class="size_s checkVal" xmlName='EBUminLoudLevel' templateErrorMessage='9' />
										</td>
										<td>
											<input type="number" min="0" name="EBU_minLoudTolerance" id="EBU_minLoudTolerance" class="size_s checkVal" xmlName='EBUminLoudTolerance' templateErrorMessage='10' />
										</td>
										<td>
											<img src ="../../Common/images/red.PNG" class="c_p" style="height:12px;" onclick='deleteParamRow(this);'/>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div id='ATSC_paramTable' class='loudnessParamTable' loudnessType='2'>
							<table cellspacing="0" cellpadding="2">
								<thead>
									<tr>
										<th>
											<div style="margin: auto;width: 75%;">
												<div style="float: left;margin-right: 5px;">Averaging Type</div>
												<div style='float:left; margin-top:0px;'>
													<a href="#null" title="<?php echo M_Title_11?>">[?]</a>
												</div>
											</div>
										</th>
										<th colspan="2">
											<div style="margin: auto;width: 60%;">
												<div style="float: left;margin-right: 5px;">Max Loudness</div>
												<div style='float:left; margin-top:0px;'>
													<a href="#null" title="<?php echo M_Title_12?>">[?]</a>
												</div>
											</div>
										</th>
										<th colspan="2">
											<div style="margin: auto;width: 60%;">
												<div style="float: left;margin-right: 5px;">Min Loudness</div>
												<div style='float:left; margin-top:0px;'>
													<a href="#null" title="<?php echo M_Title_13?>">[?]</a>
												</div>
											</div>
										</th>
									</tr>
									<tr>
										<th>&nbsp;</th>
										<th>Level</th>
										<th>Tolerance</th>
										<th>Level</th>
										<th>Tolerance</th>
									</tr>
								</thead>
								<tbody align="center" class="loudnessTableBody" mode="2">
									<tr>
										<td>
											<select class='checkVal' name='ATSC_timescaleSelect' id='ATSC_timescaleSelect' xmlName='ATSCTimescale' >
												<option value='2'>Short-term(10 sec)</option>
											</select>
										</td>
										<td>
											<select class='checkVal' name='ATSC_maxLoudSign' id='ATSC_maxLoudSign' xmlName='ATSCmaxLevelSign' >
												<option value='1'>-</option>
												<option value='2'>+</option>
											</select>
											<input type="number" min="0" name="ATSC_maxLoudLevel" id="ATSC_maxLoudLevel" class="size_s checkVal" xmlName='ATSCmaxLoudLevel' templateErrorMessage='11' />
										</td>
										<td>
											<input type="number" min="0" name="ATSC_maxLoudTolerance" id="ATSC_maxLoudTolerance" class="size_s checkVal" xmlName='ATSCmaxLoudTolerance' templateErrorMessage='12' />
										</td>
										<td>
											<select class='checkVal' name='ATSC_minLoudSign' id='ATSC_minLoudSign' xmlName='ATSCLevelSign' >
												<option value='1'>-</option>
												<option value='2'>+</option>
											</select>
											<input type="number" min="0" name="ATSC_minLoudLevel" id="ATSC_minLoudLevel" class="size_s checkVal" xmlName='ATSCminLoudLevel' templateErrorMessage='13' />
										</td>
										<td>
											<input type="number" min="0" name="ATSC_minLoudTolerance" id="ATSC_minLoudTolerance" class="size_s checkVal" xmlName='ATSCminLoudTolerance' templateErrorMessage='14' />
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
	
	<!--			<div class='item_Row' style='border-bottom: 1px solid #ccc !important;'>
					<div class='item'>
						<input type='checkbox' name='closedCaptionMissing' id='closedCaptionMissing' />
					</div>
					<div class='item textInline'>
						Closed captioning missing
					</div>
					<div class='item textInline bind_hidden'>
						Duration
					</div>
					<div class='item bind_hidden'>
						<input class='checkVal' type='number' min='0' name='ccMissingDuration' id='ccMissingDuration' xmlName='Duration' templateErrorMessage='18'/>
					</div>
					<div class='item textInline bind_hidden'>
						Minutes
					</div>
					<!--
						<select class='checkVal' name='closedCaptionMissing' id='closedCaptionMissing' xmlName='Presence' >
							<option value='1'>Must be present</option>
							<option value='2'>Must not be present</option>
						</select>
					//End of comment
					<div class='bind_hidden' style='float:left; margin-top:3px;'>
						<a href="#null" title="<?php echo M_Title_14;?>">[?]</a>
					</div>
				</div>
				-->
				<div class='item_Row'>
					<div class='item'>
						<input type='checkbox' checked='checked' disabled='disabled' name='bitRate' id='bitRate' />
					</div>
					<div class='item textInline'>
						Bit Rate
					</div>
					<div style='float:left; margin-top:3px;'>
						<a href="#null" title="<?php echo M_Title_16?>">[?]</a>
					</div>
					<div style="width: 95%; margin-left: 25px; display:none;">
						<div class='item_Row'>
							<div class='item'>
								<input class='checkVal' type='checkbox' checked='checked' disabled='disabled' name='bitRateCheck' id='bitRateCheck' xmlName='check' value="1"/>
							</div>
						</div>
					</div>
				</div>
				
				<div class='item_Row'>
					<div class='item'>
						<input type='checkbox' checked='checked' disabled='disabled' name='connectionDrop' id='connectionDrop' />
					</div>
					<div class='item textInline'>
						Connection Drop
					</div>
					<div style='float:left; margin-top:3px;'>
						<a href="#null" title="<?php echo M_Title_17?>">[?]</a>
					</div>
					<div style="width: 95%; margin-left: 25px; display:none;">
						<div class='item_Row'>
							<div class='item'>
								<input class='checkVal' type='checkbox' checked='checked' disabled='disabled' name='connectionDropCheck' id='connectionDropCheck' xmlName='check' value="1"/>
							</div>
						</div>
					</div>
				</div>
				
				<div class='item_Row'>
					<div class='item'>
						<input type='checkbox' checked='checked' disabled='disabled' name='downloadingTimeAnalysis' id='downloadingTimeAnalysis' />
					</div>
					<div class='item textInline'>
						Downloading Time Analysis
					</div>
					<div style='float:left; margin-top:3px;'>
						<a href="#null" title="<?php echo M_Title_18?>">[?]</a>
					</div>
					<div style="width: 95%; margin-left: 25px; display:none;">
						<div class='item_Row'>
							<div class='item'>
								<input class='checkVal' type='checkbox' checked='checked' disabled='disabled' name='downloadingTimeAnalysisCheck' id='downloadingTimeAnalysisCheck' xmlName='check' value="1"/>
							</div>
						</div>
					</div>
				</div>
				
					<!--
				<div class='item_Row'>
					<div class='item'>
						<input class='onlyCheckBoxValue' type='checkbox' name='bufferUnderRun' id='bufferUnderRun' />
					</div>
					<div class='item textInline'>
						Buffer under run
					</div>
					<div style='float:left; margin-top:3px;'>
						<a href="#null" title="<?php /*echo M_Title_15*/?>">[?]</a>
					</div>
				</div>
					-->
			</form>
				<div style='position: absolute; bottom: 5px;text-align: center; width: 98%;'>
					<div class='item_Row'>
						<div class='item' style='display:inline;float:none'>
							<input type='button' class='jqxbutton c_p' value='Add' onclick='saveTemplate()' style='margin:3px'/>
						</div>
						<div class='item' style='display:inline;float:none'>
							<input type='button' class='jqxbutton c_p' value='Cancel' onclick='cancelSaveTemplate()' style='margin:3px'/>
						</div>
					</div>
				</div>
			
		</div>
	</div>
</div>
<script type="text/javascript" src="./../js/NovaTemplate.js"></script>