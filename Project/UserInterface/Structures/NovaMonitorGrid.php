<?php
error_reporting(0);
?>
<div class='monitor_container'>
	<table id="ChannelMonitorgrid">
		<tr>
			<td>
				<?php 
				if($_GET['canvas']=='1'){?>
				<canvas channelId='101' customValueOf='bouquet_1_channel_1_thumb' customValueAs='attr' width='140' height='80' style='border:1px solid #d3d3d3;'></canvas>
				<?php }
				else{?>
				<img src='' channelId='101' customValueOf='bouquet_1_channel_1_thumb' customValueAs='attr' />
				<?php }
				?>
				<div channel='101' align='center'></div>
			</td>
			<td>
			<img src='' channelId='102' customValueOf='bouquet_1_channel_2_thumb' customValueAs='attr' />
			<div channel='102' align='center'></div>
			</td>
			<td>
			<img src='' channelId='103' customValueOf='bouquet_1_channel_3_thumb' customValueAs='attr' />
			<div channel='103' align='center'></div>
			</td>
		</tr>
		<tr>
			<td>
			<img src='' channelId='201' customValueOf='bouquet_2_channel_1_thumb' customValueAs='attr' />
			<div channel='201' align='center'></div>
			</td>
			<td>
			<img src='' channelId='202' customValueOf='bouquet_2_channel_2_thumb' customValueAs='attr' />
			<div channel='202' align='center'></div>
			</td>
			<td>
			<img src='' channelId='203' customValueOf='bouquet_2_channel_3_thumb' customValueAs='attr' />
			<div channel='203' align='center'></div>
			</td>
		</tr>
		<tr>
			<td>
			<img src='' channelId='301' customValueOf='bouquet_3_channel_1_thumb' customValueAs='attr' />
			<div channel='301' align='center'></div>
			</td>
			<td>
			<img src='' channelId='302' customValueOf='bouquet_3_channel_2_thumb' customValueAs='attr' />
			<div channel='302' align='center'></div>
			</td>
			<td>
			<img src='' channelId='303' customValueOf='bouquet_3_channel_3_thumb' customValueAs='attr' />
			<div channel='303' align='center'></div>
			</td>
		</tr>
	</table>
</div>
<?php 
if($_GET['canvas']=='1'){?>
<script src='./../js/CgridMonitor.js' type="text/javascript"></script>

<?php }
else{?>
<script src='./../js/gridMonitor.js' type="text/javascript"></script>
<?php }
?>
<script src='./../js/monitorPageupdate.js' type="text/javascript"></script> 