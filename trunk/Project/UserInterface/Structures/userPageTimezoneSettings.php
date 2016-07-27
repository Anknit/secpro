<?php
?>
<div id="HomePageTimezoneSetting"  class="container tabDiV" style="display: none">
	<h3 style="  width: 98%;  margin: 15px auto;"> Timezone Settings</h3>
	<hr style="width: 98%;  margin: auto;">
	<div class='settingContainer'>
		<table cellpadding="5">
			<tr>
				<td>System Timezone</td>
				<td>
					<select id='systemTimezone' class='customSelectBox'>
						<!-- <option data-timeZoneId="1" data-data-gmtAdjustment="GMT-12:00" data-data-useDaylightTime="0" value="-12">(GMT-12:00) International Date Line West</option>
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
						<option data-timeZoneId="82" data-gmtAdjustment="GMT+13:00" data-useDaylightTime="0" value="13">(GMT+13:00) Nuku'alofa</option> -->	
					</select>
				</td>
			</tr>
			<tr>
				<td align='right'>
					<input class='jqxbutton c_p' title='save timezone settings' type='button' value='Save' onclick='saveTimezoneSettings()' />
				</td>
				<td></td>
			</tr>
		</table>
	</div>
</div>