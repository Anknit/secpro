<?php ?>
<div id='HomePageChannels' class='container tabDiV' style='display:none'>
	<div class='container_div menu_container'>
		<div class='item_container_div f_l'>
			<div class='menu_item'>
				<input type='button' class='jqxbutton c_p' value='Add' title="Add New Source" onclick='openNewItemForm(this)' openDivID='channel_add_form'/>
			</div>
		</div>
		<div class='item_container_div f_l'>
			<div class='menu_item'>
				<input type='button' class='jqxbutton menu_item_disable c_p' value='Edit' title="Edit Source" disabled="disabled" onclick='editChannel()'/>
			</div>
		</div>
		<div class='item_container_div f_l'>
			<div class='menu_item'>
				<input type='button' class='jqxbutton menu_item_disable c_p' value='Remove' title="Remove Source" disabled="disabled" onclick='deleteChannel()'/>
			</div>
		</div>
		<div class='item_container_div f_l'>
			<div class='menu_item'>
				<input type='button' class='jqxbutton menu_item_disable c_p' value='Update' title="Update Source" disabled="disabled" onclick='updateChannel()'/>
			</div>
		</div>
	</div>
	<hr />
	<div class='container_div'>
		<div>
			<table id="ChannelTable" class="convertTojqGrid ui-grid-Font" url="fetchData.php?data=channel&act=grid" colNames=", Source Name, Source URL, Total Profiles, Active Profiles, Node, Node Description, Status, Email Alert" colModel="channelColModel" sortBy="channelId" gridComplete="channelColModelFormatterFunction" gridWidth='0.97', gridHeight='0.75'></table>
			<div id="gridpager_ChannelTable"></div>
		</div>
		<div style="clear:both"></div>
	</div>
	<div id='channel_add_form' class='modal_div'>
		<div class='windowHead'>
			Add Source
		</div>
		<div class='windowBody'>
			<table cellpadding='3'>
				<tr>
					<td>Select Node</td>
					<td>
						<select name='nodeListSelect' id='nodeListSelect' title="Select node location for source" >
						</select>
					</td>
				</tr>
				<tr>
					<td>Source URL</td>
					<td>
						<input type='text' name='newChannelURL' class='urlInput' id='newChannelURL' title="Provide URL of source" />
					</td>
				</tr>
				<tr>
					<td>Source Name</td>
					<td>
						<input type='text' name='newChannelName' id='newChannelName' title="Name of source" />
					</td>
				</tr>
				<tr>
					<td>Analysis Setting</td>
					<td>
						<select name='templateListSelect' id='templateListSelect' class='mapTemplateList' title="Select template configuration" >
						</select>
					</td>
				</tr><!--
				<tr>
					<td>
						<div class='jqxRadioButton checked' name='monitoringType' onclick='toggleScheduleOption(1);'><span style='vertical-align: bottom;'>Immediate Monitoring</span></div>
					</td>
					<td>
						<div class='jqxRadioButton' name='monitoringType' onclick='toggleScheduleOption(2);' ><span style='vertical-align: bottom;'>Scheduled Monitoring</span></div>
					</td>
				</tr>
				<tr class='scheduleInput' style='display:none'>
					<td colspan="2">
						<table cellpadding="4"  style='margin:10px 5px;'>
							<tr>
								<td>Start Time</td>
								<td>
									<div class="dateTimeInput" id="scheduleStartTime"></div>
								</td>
							</tr>
							<tr>
								<td>End Time</td>
								<td>
									<div class="dateTimeInput" id="scheduleEndTime"></div>
								</td>
							</tr>
							<tr>
								<td>Timezone</td>
								<td>
									<div id='timeZoneOffset'></div>
									<select id='timezoneSelect' style='width:200px;display:none;'>
										<option data-timeZoneId="1" data-data-gmtAdjustment="GMT-12:00" data-data-useDaylightTime="0" value="-12">(GMT-12:00) International Date Line West</option>
										<option data-timeZoneId="2" data-gmtAdjustment="GMT-11:00" data-useDaylightTime="0" value="-11">(GMT-11:00) Midway Island, Samoa</option>
										<option data-timeZoneId="3" data-gmtAdjustment="GMT-10:00" data-useDaylightTime="0" value="-10">(GMT-10:00) Hawaii</option>
										<option data-timeZoneId="4" data-gmtAdjustment="GMT-09:00" data-useDaylightTime="1" value="-9">(GMT-09:00) Alaska</option>
										<option data-timeZoneId="5" data-gmtAdjustment="GMT-08:00" data-useDaylightTime="1" value="-8">(GMT-08:00) Pacific Time (US & Canada)</option>
										<option data-timeZoneId="6" data-gmtAdjustment="GMT-08:00" data-useDaylightTime="1" value="-8">(GMT-08:00) Tijuana, Baja California</option>
										<option data-timeZoneId="7" data-gmtAdjustment="GMT-07:00" data-useDaylightTime="0" value="-7">(GMT-07:00) Arizona</option>
										<option data-timeZoneId="8" data-gmtAdjustment="GMT-07:00" data-useDaylightTime="1" value="-7">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
										<option data-timeZoneId="9" data-gmtAdjustment="GMT-07:00" data-useDaylightTime="1" value="-7">(GMT-07:00) Mountain Time (US & Canada)</option>
										<option data-timeZoneId="10" data-gmtAdjustment="GMT-06:00" data-useDaylightTime="0" value="-6">(GMT-06:00) Central America</option>
										<option data-timeZoneId="11" data-gmtAdjustment="GMT-06:00" data-useDaylightTime="1" value="-6">(GMT-06:00) Central Time (US & Canada)</option>
										<option data-timeZoneId="12" data-gmtAdjustment="GMT-06:00" data-useDaylightTime="1" value="-6">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
										<option data-timeZoneId="13" data-gmtAdjustment="GMT-06:00" data-useDaylightTime="0" value="-6">(GMT-06:00) Saskatchewan</option>
										<option data-timeZoneId="14" data-gmtAdjustment="GMT-05:00" data-useDaylightTime="0" value="-5">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
										<option data-timeZoneId="15" data-gmtAdjustment="GMT-05:00" data-useDaylightTime="1" value="-5">(GMT-05:00) Eastern Time (US & Canada)</option>
										<option data-timeZoneId="16" data-gmtAdjustment="GMT-05:00" data-useDaylightTime="1" value="-5">(GMT-05:00) Indiana (East)</option>
										<option data-timeZoneId="17" data-gmtAdjustment="GMT-04:00" data-useDaylightTime="1" value="-4">(GMT-04:00) Atlantic Time (Canada)</option>
										<option data-timeZoneId="18" data-gmtAdjustment="GMT-04:00" data-useDaylightTime="0" value="-4">(GMT-04:00) Caracas, La Paz</option>
										<option data-timeZoneId="19" data-gmtAdjustment="GMT-04:00" data-useDaylightTime="0" value="-4">(GMT-04:00) Manaus</option>
										<option data-timeZoneId="20" data-gmtAdjustment="GMT-04:00" data-useDaylightTime="1" value="-4">(GMT-04:00) Santiago</option>
										<option data-timeZoneId="21" data-gmtAdjustment="GMT-03:30" data-useDaylightTime="1" value="-3.5">(GMT-03:30) Newfoundland</option>
										<option data-timeZoneId="22" data-gmtAdjustment="GMT-03:00" data-useDaylightTime="1" value="-3">(GMT-03:00) Brasilia</option>
										<option data-timeZoneId="23" data-gmtAdjustment="GMT-03:00" data-useDaylightTime="0" value="-3">(GMT-03:00) Buenos Aires, Georgetown</option>
										<option data-timeZoneId="24" data-gmtAdjustment="GMT-03:00" data-useDaylightTime="1" value="-3">(GMT-03:00) Greenland</option>
										<option data-timeZoneId="25" data-gmtAdjustment="GMT-03:00" data-useDaylightTime="1" value="-3">(GMT-03:00) Montevideo</option>
										<option data-timeZoneId="26" data-gmtAdjustment="GMT-02:00" data-useDaylightTime="1" value="-2">(GMT-02:00) Mid-Atlantic</option>
										<option data-timeZoneId="27" data-gmtAdjustment="GMT-01:00" data-useDaylightTime="0" value="-1">(GMT-01:00) Cape Verde Is.</option>
										<option data-timeZoneId="28" data-gmtAdjustment="GMT-01:00" data-useDaylightTime="1" value="-1">(GMT-01:00) Azores</option>
										<option data-timeZoneId="29" data-gmtAdjustment="GMT+00:00" data-useDaylightTime="0" value="0">(GMT+00:00) Casablanca, Monrovia, Reykjavik</option>
										<option data-timeZoneId="30" data-gmtAdjustment="GMT+00:00" data-useDaylightTime="1" value="0">(GMT+00:00) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London</option>
										<option data-timeZoneId="31" data-gmtAdjustment="GMT+01:00" data-useDaylightTime="1" value="1">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
										<option data-timeZoneId="32" data-gmtAdjustment="GMT+01:00" data-useDaylightTime="1" value="1">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
										<option data-timeZoneId="33" data-gmtAdjustment="GMT+01:00" data-useDaylightTime="1" value="1">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
										<option data-timeZoneId="34" data-gmtAdjustment="GMT+01:00" data-useDaylightTime="1" value="1">(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb</option>
										<option data-timeZoneId="35" data-gmtAdjustment="GMT+01:00" data-useDaylightTime="1" value="1">(GMT+01:00) West Central Africa</option>
										<option data-timeZoneId="36" data-gmtAdjustment="GMT+02:00" data-useDaylightTime="1" value="2">(GMT+02:00) Amman</option>
										<option data-timeZoneId="37" data-gmtAdjustment="GMT+02:00" data-useDaylightTime="1" value="2">(GMT+02:00) Athens, Bucharest, Istanbul</option>
										<option data-timeZoneId="38" data-gmtAdjustment="GMT+02:00" data-useDaylightTime="1" value="2">(GMT+02:00) Beirut</option>
										<option data-timeZoneId="39" data-gmtAdjustment="GMT+02:00" data-useDaylightTime="1" value="2">(GMT+02:00) Cairo</option>
										<option data-timeZoneId="40" data-gmtAdjustment="GMT+02:00" data-useDaylightTime="0" value="2">(GMT+02:00) Harare, Pretoria</option>
										<option data-timeZoneId="41" data-gmtAdjustment="GMT+02:00" data-useDaylightTime="1" value="2">(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius</option>
										<option data-timeZoneId="42" data-gmtAdjustment="GMT+02:00" data-useDaylightTime="1" value="2">(GMT+02:00) Jerusalem</option>
										<option data-timeZoneId="43" data-gmtAdjustment="GMT+02:00" data-useDaylightTime="1" value="2">(GMT+02:00) Minsk</option>
										<option data-timeZoneId="44" data-gmtAdjustment="GMT+02:00" data-useDaylightTime="1" value="2">(GMT+02:00) Windhoek</option>
										<option data-timeZoneId="45" data-gmtAdjustment="GMT+03:00" data-useDaylightTime="0" value="3">(GMT+03:00) Kuwait, Riyadh, Baghdad</option>
										<option data-timeZoneId="46" data-gmtAdjustment="GMT+03:00" data-useDaylightTime="1" value="3">(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
										<option data-timeZoneId="47" data-gmtAdjustment="GMT+03:00" data-useDaylightTime="0" value="3">(GMT+03:00) Nairobi</option>
										<option data-timeZoneId="48" data-gmtAdjustment="GMT+03:00" data-useDaylightTime="0" value="3">(GMT+03:00) Tbilisi</option>
										<option data-timeZoneId="49" data-gmtAdjustment="GMT+03:30" data-useDaylightTime="1" value="3.5">(GMT+03:30) Tehran</option>
										<option data-timeZoneId="50" data-gmtAdjustment="GMT+04:00" data-useDaylightTime="0" value="4">(GMT+04:00) Abu Dhabi, Muscat</option>
										<option data-timeZoneId="51" data-gmtAdjustment="GMT+04:00" data-useDaylightTime="1" value="4">(GMT+04:00) Baku</option>
										<option data-timeZoneId="52" data-gmtAdjustment="GMT+04:00" data-useDaylightTime="1" value="4">(GMT+04:00) Yerevan</option>
										<option data-timeZoneId="53" data-gmtAdjustment="GMT+04:30" data-useDaylightTime="0" value="4.5">(GMT+04:30) Kabul</option>
										<option data-timeZoneId="54" data-gmtAdjustment="GMT+05:00" data-useDaylightTime="1" value="5">(GMT+05:00) Yekaterinburg</option>
										<option data-timeZoneId="55" data-gmtAdjustment="GMT+05:00" data-useDaylightTime="0" value="5">(GMT+05:00) Islamabad, Karachi, Tashkent</option>
										<option data-timeZoneId="56" data-gmtAdjustment="GMT+05:30" data-useDaylightTime="0" value="5.5">(GMT+05:30) Sri Jayawardenapura</option>
										<option data-timeZoneId="57" data-gmtAdjustment="GMT+05:30" data-useDaylightTime="0" value="5.5">(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
										<option data-timeZoneId="58" data-gmtAdjustment="GMT+05:45" data-useDaylightTime="0" value="5.75">(GMT+05:45) Kathmandu</option>
										<option data-timeZoneId="59" data-gmtAdjustment="GMT+06:00" data-useDaylightTime="1" value="6">(GMT+06:00) Almaty, Novosibirsk</option>
										<option data-timeZoneId="60" data-gmtAdjustment="GMT+06:00" data-useDaylightTime="0" value="6">(GMT+06:00) Astana, Dhaka</option>
										<option data-timeZoneId="61" data-gmtAdjustment="GMT+06:30" data-useDaylightTime="0" value="6.5">(GMT+06:30) Yangon (Rangoon)</option>
										<option data-timeZoneId="62" data-gmtAdjustment="GMT+07:00" data-useDaylightTime="0" value="7">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
										<option data-timeZoneId="63" data-gmtAdjustment="GMT+07:00" data-useDaylightTime="1" value="7">(GMT+07:00) Krasnoyarsk</option>
										<option data-timeZoneId="64" data-gmtAdjustment="GMT+08:00" data-useDaylightTime="0" value="8">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
										<option data-timeZoneId="65" data-gmtAdjustment="GMT+08:00" data-useDaylightTime="0" value="8">(GMT+08:00) Kuala Lumpur, Singapore</option>
										<option data-timeZoneId="66" data-gmtAdjustment="GMT+08:00" data-useDaylightTime="0" value="8">(GMT+08:00) Irkutsk, Ulaan Bataar</option>
										<option data-timeZoneId="67" data-gmtAdjustment="GMT+08:00" data-useDaylightTime="0" value="8">(GMT+08:00) Perth</option>
										<option data-timeZoneId="68" data-gmtAdjustment="GMT+08:00" data-useDaylightTime="0" value="8">(GMT+08:00) Taipei</option>
										<option data-timeZoneId="69" data-gmtAdjustment="GMT+09:00" data-useDaylightTime="0" value="9">(GMT+09:00) Osaka, Sapporo, Tokyo</option>
										<option data-timeZoneId="70" data-gmtAdjustment="GMT+09:00" data-useDaylightTime="0" value="9">(GMT+09:00) Seoul</option>
										<option data-timeZoneId="71" data-gmtAdjustment="GMT+09:00" data-useDaylightTime="1" value="9">(GMT+09:00) Yakutsk</option>
										<option data-timeZoneId="72" data-gmtAdjustment="GMT+09:30" data-useDaylightTime="0" value="9.5">(GMT+09:30) Adelaide</option>
										<option data-timeZoneId="73" data-gmtAdjustment="GMT+09:30" data-useDaylightTime="0" value="9.5">(GMT+09:30) Darwin</option>
										<option data-timeZoneId="74" data-gmtAdjustment="GMT+10:00" data-useDaylightTime="0" value="10">(GMT+10:00) Brisbane</option>
										<option data-timeZoneId="75" data-gmtAdjustment="GMT+10:00" data-useDaylightTime="1" value="10">(GMT+10:00) Canberra, Melbourne, Sydney</option>
										<option data-timeZoneId="76" data-gmtAdjustment="GMT+10:00" data-useDaylightTime="1" value="10">(GMT+10:00) Hobart</option>
										<option data-timeZoneId="77" data-gmtAdjustment="GMT+10:00" data-useDaylightTime="0" value="10">(GMT+10:00) Guam, Port Moresby</option>
										<option data-timeZoneId="78" data-gmtAdjustment="GMT+10:00" data-useDaylightTime="1" value="10">(GMT+10:00) Vladivostok</option>
										<option data-timeZoneId="79" data-gmtAdjustment="GMT+11:00" data-useDaylightTime="1" value="11">(GMT+11:00) Magadan, Solomon Is., New Caledonia</option>
										<option data-timeZoneId="80" data-gmtAdjustment="GMT+12:00" data-useDaylightTime="1" value="12">(GMT+12:00) Auckland, Wellington</option>
										<option data-timeZoneId="81" data-gmtAdjustment="GMT+12:00" data-useDaylightTime="0" value="12">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
										<option data-timeZoneId="82" data-gmtAdjustment="GMT+13:00" data-useDaylightTime="0" value="13">(GMT+13:00) Nuku'alofa</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Repeat</td>
								<td>
									<div id='scheduleRepeatDropDown'></div>
									<select id='scheduleRepeat' style='display:none'>
										<option selected="selected" value='0'>Monitor Once</option>
										<option value='10'>Daily</option>
										<option value='11'>Weekly</option>
									</select>
								</td>
							</tr>
							<tr>
								<td></td>
								<td>
									<div class='weekdayContainer' style='padding-top:2px; display:none'>
										<span data-day='1' data-dayName='Sunday'>S</span>
										<span data-day='2' data-dayName='Monday'>M</span>
										<span data-day='3' data-dayName='Tuesday'>T</span>
										<span data-day='4' data-dayName='Wednesday'>W</span>
										<span data-day='5' data-dayName='Thursday'>T</span>
										<span data-day='6' data-dayName='Friday'>F</span>
										<span data-day='7' data-dayName='Saturday'>S</span>
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				--><tr>
					<td colspan="2">
						<div class='new_node_item_container' align='center' style='height:30px'>
							<input type='button' class='jqxbutton c_p' value='OK' onclick='addChannel()' style='margin:3px'/>
							<input type='button' class='jqxbutton c_p' value='Cancel' onclick='cancelNewChannel()' style='margin:3px'/>
						</div>	
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div id='channel_edit_form' class='' >
		<div class='windowHead'>
			Edit Source
		</div>
		<div class='windowBody'>
			<div id='editChannelTabContainer'>
				<ul>
					<li>Analysis Settings</li>
					<li>Source Scheduling</li>
				</ul>
				<div class='windowTabContent'>
					<table class='popupTable'><!--
		--><!-- 			<tr>
							<td><b>Source Status</b></td>
							<td>
								<select id='editChannelStatusSelect' title="Only active sources will be monitored" >
									<option value='1'>Active</option>
									<option value='2'>Inactive</option>
								</select>
							</td>
						</tr>  -->
						<tr>
							<td style='width:50%'><b>Source Name :</b><span id='editChannelNameSpan'></span>							
							</td>
							<td>
								<b>Analysis Setting</b>&nbsp;
								<select id='editChannelTemplateSelect'  class='mapTemplateList' title="change monitoring settings" ></select>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<table id='editChannelProfileTable' class='popupTable'>
									<thead style="background-color: #ccc;">
										<tr>
											<td style='padding:5px; width:50%'>
												<b>Profile Bitrate (Kbps)</b>
											</td>
											<td>
												<b>Profile Status</b>
											</td>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</td>
						</tr><!--
						<tr>
							<td colspan="2">
								<div class='edit_channel_item_container' align='center' style='margin-top:10px;'>
									<input type='button' class='jqxbutton c_p' value='Apply' onclick='saveChannel()'/>
									<input type='button' class='jqxbutton c_p' value='Cancel' onclick='cancelEditChannel()'/>
								</div>	
							</td>
						</tr>
					--></table>
				</div>
				<div class='windowTabContent'>
					<div class='schedulerOption'>
						<div class='item_container_div f_l'>
							<div class='menu_item'>
								<input type='button' class='jqxbutton c_p' value='Add' title="Add New Schedulling" onclick='addChannelSchedulling()'/>
							</div>
						</div>
						<div class='item_container_div f_l'>
							<div class='menu_item'>
								<input type='button' class='jqxbutton menu_item_disable c_p' value='Edit' title="Edit Schedulling" disabled="disabled" onclick='editChannelSchedulling()'/>
							</div>
						</div><!--
						<div class='item_container_div f_l'>
							<div class='menu_item'>
								<input type='button' class='jqxbutton menu_item_disable c_p' value='Stop' title="Stop schedulling" disabled="disabled" onclick='stopChannelSchedulling()'/>
							</div>
						</div>
						--><div class='item_container_div f_l'>
							<div class='menu_item'>
								<input type='button' class='jqxbutton menu_item_disable c_p' value='Remove' title="Remove Schedulling " disabled="disabled" onclick='removeChannelSchedulling()'/>
							</div>
						</div>
					</div>
					<div id="currentTimezone"></div>
					<br/>
					<div class='allDayContainer' style='margin-top: 25px;visibility:hidden;'>
						<label for='allDayContainerCheckInput' style='margin-left:20px'>
							<input type='checkbox' id='allDayContainerCheckInput' name='allDayContainerCheckInput' />All-day Event
						</label>
					</div>
					<div id='scheduleGridContainer' style='margin-top:5px; overflow:hidden;'>
						<div id='scheduleScrollDiv' style='max-height:200px;overflow:hidden; height:200px'>
							<table class='popupTable' id='scheduleListTable'>
								<thead>
									<tr>
										<th>&nbsp;</th>
                                        <th>Start Time <span class="channel-time-zone"></span></th>
										<th>End Time</th><!--
										<th>Timezone</th>
										--><th>Repeat</th>
										<th>Until</th>
										<th>Reminder</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody id='scheduleTableBody'>
									<tr class='optionRow' style='display:none;'>
										<td>&nbsp;</td>
										<td><div class='dateTimeInput' style='margin:auto' id='newScheduleStart' name='newScheduleStart'></div></td>
										<td><div class='dateTimeInput' style='margin:auto' id='newScheduleEnd' name='newScheduleEnd'></div></td><!--
										<td>
											<select name='newScheduleTimeZone'>
												<option data-timeZoneId="1" data-gmtAdjustment="GMT-12:00" data-useDaylightTime="0" value="-12">(GMT-12:00) International Date Line West</option>
												<option data-timeZoneId="2" data-gmtAdjustment="GMT-11:00" data-useDaylightTime="0" value="-11">(GMT-11:00) Midway Island, Samoa</option>
												<option data-timeZoneId="3" data-gmtAdjustment="GMT-10:00" data-useDaylightTime="0" value="-10">(GMT-10:00) Hawaii</option>
												<option data-timeZoneId="4" data-gmtAdjustment="GMT-09:00" data-useDaylightTime="1" value="-9">(GMT-09:00) Alaska</option>
												<option data-timeZoneId="5" data-gmtAdjustment="GMT-08:00" data-useDaylightTime="1" value="-8">(GMT-08:00) Pacific Time (US & Canada)</option>
												<option data-timeZoneId="6" data-gmtAdjustment="GMT-08:00" data-useDaylightTime="1" value="-8">(GMT-08:00) Tijuana, Baja California</option>
												<option data-timeZoneId="7" data-gmtAdjustment="GMT-07:00" data-useDaylightTime="0" value="-7">(GMT-07:00) Arizona</option>
												<option data-timeZoneId="8" data-gmtAdjustment="GMT-07:00" data-useDaylightTime="1" value="-7">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
												<option data-timeZoneId="9" data-gmtAdjustment="GMT-07:00" data-useDaylightTime="1" value="-7">(GMT-07:00) Mountain Time (US & Canada)</option>
												<option data-timeZoneId="10" data-gmtAdjustment="GMT-06:00" data-useDaylightTime="0" value="-6">(GMT-06:00) Central America</option>
												<option data-timeZoneId="11" data-gmtAdjustment="GMT-06:00" data-useDaylightTime="1" value="-6">(GMT-06:00) Central Time (US & Canada)</option>
												<option data-timeZoneId="12" data-gmtAdjustment="GMT-06:00" data-useDaylightTime="1" value="-6">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
												<option data-timeZoneId="13" data-gmtAdjustment="GMT-06:00" data-useDaylightTime="0" value="-6">(GMT-06:00) Saskatchewan</option>
												<option data-timeZoneId="14" data-gmtAdjustment="GMT-05:00" data-useDaylightTime="0" value="-5">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
												<option data-timeZoneId="15" data-gmtAdjustment="GMT-05:00" data-useDaylightTime="1" value="-5">(GMT-05:00) Eastern Time (US & Canada)</option>
												<option data-timeZoneId="16" data-gmtAdjustment="GMT-05:00" data-useDaylightTime="1" value="-5">(GMT-05:00) Indiana (East)</option>
												<option data-timeZoneId="17" data-gmtAdjustment="GMT-04:00" data-useDaylightTime="1" value="-4">(GMT-04:00) Atlantic Time (Canada)</option>
												<option data-timeZoneId="18" data-gmtAdjustment="GMT-04:00" data-useDaylightTime="0" value="-4">(GMT-04:00) Caracas, La Paz</option>
												<option data-timeZoneId="19" data-gmtAdjustment="GMT-04:00" data-useDaylightTime="0" value="-4">(GMT-04:00) Manaus</option>
												<option data-timeZoneId="20" data-gmtAdjustment="GMT-04:00" data-useDaylightTime="1" value="-4">(GMT-04:00) Santiago</option>
												<option data-timeZoneId="21" data-gmtAdjustment="GMT-03:30" data-useDaylightTime="1" value="-3.5">(GMT-03:30) Newfoundland</option>
												<option data-timeZoneId="22" data-gmtAdjustment="GMT-03:00" data-useDaylightTime="1" value="-3">(GMT-03:00) Brasilia</option>
												<option data-timeZoneId="23" data-gmtAdjustment="GMT-03:00" data-useDaylightTime="0" value="-3">(GMT-03:00) Buenos Aires, Georgetown</option>
												<option data-timeZoneId="24" data-gmtAdjustment="GMT-03:00" data-useDaylightTime="1" value="-3">(GMT-03:00) Greenland</option>
												<option data-timeZoneId="25" data-gmtAdjustment="GMT-03:00" data-useDaylightTime="1" value="-3">(GMT-03:00) Montevideo</option>
												<option data-timeZoneId="26" data-gmtAdjustment="GMT-02:00" data-useDaylightTime="1" value="-2">(GMT-02:00) Mid-Atlantic</option>
												<option data-timeZoneId="27" data-gmtAdjustment="GMT-01:00" data-useDaylightTime="0" value="-1">(GMT-01:00) Cape Verde Is.</option>
												<option data-timeZoneId="28" data-gmtAdjustment="GMT-01:00" data-useDaylightTime="1" value="-1">(GMT-01:00) Azores</option>
												<option data-timeZoneId="29" data-gmtAdjustment="GMT+00:00" data-useDaylightTime="0" value="0">(GMT+00:00) Casablanca, Monrovia, Reykjavik</option>
												<option data-timeZoneId="30" data-gmtAdjustment="GMT+00:00" data-useDaylightTime="1" value="0">(GMT+00:00) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London</option>
												<option data-timeZoneId="31" data-gmtAdjustment="GMT+01:00" data-useDaylightTime="1" value="1">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
												<option data-timeZoneId="32" data-gmtAdjustment="GMT+01:00" data-useDaylightTime="1" value="1">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
												<option data-timeZoneId="33" data-gmtAdjustment="GMT+01:00" data-useDaylightTime="1" value="1">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
												<option data-timeZoneId="34" data-gmtAdjustment="GMT+01:00" data-useDaylightTime="1" value="1">(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb</option>
												<option data-timeZoneId="35" data-gmtAdjustment="GMT+01:00" data-useDaylightTime="1" value="1">(GMT+01:00) West Central Africa</option>
												<option data-timeZoneId="36" data-gmtAdjustment="GMT+02:00" data-useDaylightTime="1" value="2">(GMT+02:00) Amman</option>
												<option data-timeZoneId="37" data-gmtAdjustment="GMT+02:00" data-useDaylightTime="1" value="2">(GMT+02:00) Athens, Bucharest, Istanbul</option>
												<option data-timeZoneId="38" data-gmtAdjustment="GMT+02:00" data-useDaylightTime="1" value="2">(GMT+02:00) Beirut</option>
												<option data-timeZoneId="39" data-gmtAdjustment="GMT+02:00" data-useDaylightTime="1" value="2">(GMT+02:00) Cairo</option>
												<option data-timeZoneId="40" data-gmtAdjustment="GMT+02:00" data-useDaylightTime="0" value="2">(GMT+02:00) Harare, Pretoria</option>
												<option data-timeZoneId="41" data-gmtAdjustment="GMT+02:00" data-useDaylightTime="1" value="2">(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius</option>
												<option data-timeZoneId="42" data-gmtAdjustment="GMT+02:00" data-useDaylightTime="1" value="2">(GMT+02:00) Jerusalem</option>
												<option data-timeZoneId="43" data-gmtAdjustment="GMT+02:00" data-useDaylightTime="1" value="2">(GMT+02:00) Minsk</option>
												<option data-timeZoneId="44" data-gmtAdjustment="GMT+02:00" data-useDaylightTime="1" value="2">(GMT+02:00) Windhoek</option>
												<option data-timeZoneId="45" data-gmtAdjustment="GMT+03:00" data-useDaylightTime="0" value="3">(GMT+03:00) Kuwait, Riyadh, Baghdad</option>
												<option data-timeZoneId="46" data-gmtAdjustment="GMT+03:00" data-useDaylightTime="1" value="3">(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
												<option data-timeZoneId="47" data-gmtAdjustment="GMT+03:00" data-useDaylightTime="0" value="3">(GMT+03:00) Nairobi</option>
												<option data-timeZoneId="48" data-gmtAdjustment="GMT+03:00" data-useDaylightTime="0" value="3">(GMT+03:00) Tbilisi</option>
												<option data-timeZoneId="49" data-gmtAdjustment="GMT+03:30" data-useDaylightTime="1" value="3.5">(GMT+03:30) Tehran</option>
												<option data-timeZoneId="50" data-gmtAdjustment="GMT+04:00" data-useDaylightTime="0" value="4">(GMT+04:00) Abu Dhabi, Muscat</option>
												<option data-timeZoneId="51" data-gmtAdjustment="GMT+04:00" data-useDaylightTime="1" value="4">(GMT+04:00) Baku</option>
												<option data-timeZoneId="52" data-gmtAdjustment="GMT+04:00" data-useDaylightTime="1" value="4">(GMT+04:00) Yerevan</option>
												<option data-timeZoneId="53" data-gmtAdjustment="GMT+04:30" data-useDaylightTime="0" value="4.5">(GMT+04:30) Kabul</option>
												<option data-timeZoneId="54" data-gmtAdjustment="GMT+05:00" data-useDaylightTime="1" value="5">(GMT+05:00) Yekaterinburg</option>
												<option data-timeZoneId="55" data-gmtAdjustment="GMT+05:00" data-useDaylightTime="0" value="5">(GMT+05:00) Islamabad, Karachi, Tashkent</option>
												<option data-timeZoneId="56" data-gmtAdjustment="GMT+05:30" data-useDaylightTime="0" value="5.5">(GMT+05:30) Sri Jayawardenapura</option>
												<option data-timeZoneId="57" data-gmtAdjustment="GMT+05:30" data-useDaylightTime="0" value="5.5">(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
												<option data-timeZoneId="58" data-gmtAdjustment="GMT+05:45" data-useDaylightTime="0" value="5.75">(GMT+05:45) Kathmandu</option>
												<option data-timeZoneId="59" data-gmtAdjustment="GMT+06:00" data-useDaylightTime="1" value="6">(GMT+06:00) Almaty, Novosibirsk</option>
												<option data-timeZoneId="60" data-gmtAdjustment="GMT+06:00" data-useDaylightTime="0" value="6">(GMT+06:00) Astana, Dhaka</option>
												<option data-timeZoneId="61" data-gmtAdjustment="GMT+06:30" data-useDaylightTime="0" value="6.5">(GMT+06:30) Yangon (Rangoon)</option>
												<option data-timeZoneId="62" data-gmtAdjustment="GMT+07:00" data-useDaylightTime="0" value="7">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
												<option data-timeZoneId="63" data-gmtAdjustment="GMT+07:00" data-useDaylightTime="1" value="7">(GMT+07:00) Krasnoyarsk</option>
												<option data-timeZoneId="64" data-gmtAdjustment="GMT+08:00" data-useDaylightTime="0" value="8">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
												<option data-timeZoneId="65" data-gmtAdjustment="GMT+08:00" data-useDaylightTime="0" value="8">(GMT+08:00) Kuala Lumpur, Singapore</option>
												<option data-timeZoneId="66" data-gmtAdjustment="GMT+08:00" data-useDaylightTime="0" value="8">(GMT+08:00) Irkutsk, Ulaan Bataar</option>
												<option data-timeZoneId="67" data-gmtAdjustment="GMT+08:00" data-useDaylightTime="0" value="8">(GMT+08:00) Perth</option>
												<option data-timeZoneId="68" data-gmtAdjustment="GMT+08:00" data-useDaylightTime="0" value="8">(GMT+08:00) Taipei</option>
												<option data-timeZoneId="69" data-gmtAdjustment="GMT+09:00" data-useDaylightTime="0" value="9">(GMT+09:00) Osaka, Sapporo, Tokyo</option>
												<option data-timeZoneId="70" data-gmtAdjustment="GMT+09:00" data-useDaylightTime="0" value="9">(GMT+09:00) Seoul</option>
												<option data-timeZoneId="71" data-gmtAdjustment="GMT+09:00" data-useDaylightTime="1" value="9">(GMT+09:00) Yakutsk</option>
												<option data-timeZoneId="72" data-gmtAdjustment="GMT+09:30" data-useDaylightTime="0" value="9.5">(GMT+09:30) Adelaide</option>
												<option data-timeZoneId="73" data-gmtAdjustment="GMT+09:30" data-useDaylightTime="0" value="9.5">(GMT+09:30) Darwin</option>
												<option data-timeZoneId="74" data-gmtAdjustment="GMT+10:00" data-useDaylightTime="0" value="10">(GMT+10:00) Brisbane</option>
												<option data-timeZoneId="75" data-gmtAdjustment="GMT+10:00" data-useDaylightTime="1" value="10">(GMT+10:00) Canberra, Melbourne, Sydney</option>
												<option data-timeZoneId="76" data-gmtAdjustment="GMT+10:00" data-useDaylightTime="1" value="10">(GMT+10:00) Hobart</option>
												<option data-timeZoneId="77" data-gmtAdjustment="GMT+10:00" data-useDaylightTime="0" value="10">(GMT+10:00) Guam, Port Moresby</option>
												<option data-timeZoneId="78" data-gmtAdjustment="GMT+10:00" data-useDaylightTime="1" value="10">(GMT+10:00) Vladivostok</option>
												<option data-timeZoneId="79" data-gmtAdjustment="GMT+11:00" data-useDaylightTime="1" value="11">(GMT+11:00) Magadan, Solomon Is., New Caledonia</option>
												<option data-timeZoneId="80" data-gmtAdjustment="GMT+12:00" data-useDaylightTime="1" value="12">(GMT+12:00) Auckland, Wellington</option>
												<option data-timeZoneId="81" data-gmtAdjustment="GMT+12:00" data-useDaylightTime="0" value="12">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
												<option data-timeZoneId="82" data-gmtAdjustment="GMT+13:00" data-useDaylightTime="0" value="13">(GMT+13:00) Nuku'alofa</option>
											</select>
										</td>
										--><td>
											<select name='newScheduleRepeat' id='newScheduleRepeat'>
												<option value='0'>Once</option>
												<option value='1,2,3,4,5,6,7'>Daily</option>
												<option value='8'>Weekly</option>
											</select>
											<div class='weekdayContainer' style='padding-top:2px; display:none'>
												<span data-day='1' data-dayName='Sunday'>S</span>
												<span data-day='2' data-dayName='Monday'>M</span>
												<span data-day='3' data-dayName='Tuesday'>T</span>
												<span data-day='4' data-dayName='Wednesday'>W</span>
												<span data-day='5' data-dayName='Thursday'>T</span>
												<span data-day='6' data-dayName='Friday'>F</span>
												<span data-day='7' data-dayName='Saturday'>S</span>
											</div>
											</td>
										<td>
											<div class='dateTimeInput' style='margin:auto; visibility:hidden' id='newScheduleUntill'  name='newScheduleUntill'></div>
											<div style='padding:5px' id='foreverSchedule'>
												<div id='repeatForeverCheckBox'>Forever</div>
											</div>	
										</td>
										<td>
											<select name='newScheduleReminder'>
												<option value='5'>5 min Before</option>
												<option value='15'>15 min Before</option>
												<option value='30'>30 min Before</option>
												<option value='60'>1 hour Before</option>
											</select>
										</td>
										<td>
											<select name='newScheduleStatus'>
												<option value='1'>Active</option>
												<option value='2'>Inactive</option>
											</select>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div style='text-align:center; margin-top:15px;'> 
				<input type='button' class='jqxbutton c_p' value='Save' title="Save Changes" onclick='saveChannel()'/>
				<input type='button' class='jqxbutton c_p' value='Cancel' title="Cancel Changes" onclick='cancelEditChannel()'/>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="./../js/NovaChannel.js"></script>
<script type="text/javascript" src="./../js/channelScheduling.js"></script>