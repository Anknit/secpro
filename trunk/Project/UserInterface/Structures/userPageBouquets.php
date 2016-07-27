<?php ?>
<div class='tabDiV' id='HomePageBouquets'>
	<div class='container_div menu_container'>
		<div class='item_container_div f_l'>
			<div class='menu_item'>
				<input type='button' class='jqxbutton c_p' value='Add' title="Add New Group" onclick='openNewItemForm(this)' openDivID='bouquet_add_form'/>
			</div>
		</div>
		<div class='item_container_div f_l'>
			<div class='menu_item'>
				<input type='button' class='jqxbutton menu_item_disable c_p' value='Edit' title="Edit Group" disabled="disabled" onclick='editBouquet()'/>
			</div>
		</div>
		<div class='item_container_div f_l'>
			<div class='menu_item'>
				<input type='button' class='jqxbutton menu_item_disable c_p' value='Apply' title="Save changes" disabled="disabled" onclick='saveBouquet()'/>
			</div>
		</div>
		<div class='item_container_div f_l'>
			<div class='menu_item'>
				<input type='button' class='jqxbutton menu_item_disable c_p' value='Remove' title="Remove Group" disabled="disabled" onclick='deleteBouquet()'/>
			</div>
		</div>
	</div>
	<hr />
	<div class='half_page f_l'>
		<div class='container_div'>
			<div>
				<table id="BouquetTable" class="convertTojqGrid ui-grid-Font" url="fetchData.php?data=bouquet&act=grid" colNames=", Group Name, Description, Assigned User" colModel="bouquetColModel" sortBy="bouquetId" gridComplete="bouquetColModelFormatterFunction" selectRowFunc="bouquetColModelFormatterFunction" gridWidth='0.47', gridHeight='0.75'></table>
				<div id="gridpager_BouquetTable"></div>
			</div>
			<div style="clear:both"></div> 
		</div>
		<div class='sub_list_container main_table_linked'>
			<div class='list_table_container f_l' id='BouquetChannelListDiv'>
			</div>
		</div><!--
		<div class='container_div'>
			<table id='BouquetChannelGrid' gridWidth='0.47', gridHeight='0.20'></table>
			<div id='gridpager_BouquetChannelGrid'>
			</div>
		</div>
	--></div>
	
	<div class='half_page f_l'>
		<div class='container_div sub_list_container' id='allBouquetChannelsGridDiv'>
			<table id="AllChannelsTable" class="convertTojqGrid ui-grid-Font" url="fetchData.php?data=channel&act=grid" colNames=", Source Name, Node Name" colModel="allChannelColModel" sortBy="channelName" gridComplete="allChannelColModelFormatterFunction" gridWidth='0.48', gridHeight='0.75'></table>
			<div id="gridpager_AllChannelsTable"></div>
			<div style="clear:both"></div>
<!-- 		<div class='container_div' id='bouquetInfoEditDiv'>
				<table>
					<tr>
						<td>Assigned User</td>
						<td>
							<select id='bouquetEditUserSelect' class='mapOperatorList' title="change assigned operator">
							</select>
						</td>
					</tr>
					<tr>
						<td>Bouquet Description</td>
						<td><textarea id="bouquetDescriptionEdit"></textarea></td>
					</tr>
				</table>
			</div>  -->	 
		</div>
	</div>
	
	<div id='bouquet_add_form' class='modal_div'>
		<div class='windowHead'>
			Add Group
		</div>
		<div class='windowBody'>
			<table>
				<tr>
					<td>Group Name</td>
					<td>
						<input type='text' name='new_bouquet_input_name' id='new_bouquet_input_name' title='Provide a name for this group' />
					</td>
				</tr>
				<tr>
					<td>Description</td>
					<td>
						<textarea name='new_bouquet_input_description' id='new_bouquet_input_description' title='Enter description of group' ></textarea>
					</td>
				</tr>
				<tr>
					<td>User</td>
					<td>
						<select name='bouquetUserSelect' id='bouquetUserSelect' class='mapOperatorList' title="Assigned user can see the monitor data of the sources included in this group">
						</select>
					</td>
				</tr>
				<tr>
					<td colspan='2'>
						<div class='new_node_item_container' align='center' style='height:30px'>
							<input type='button' class='jqxbutton c_p' value='Add' onclick='addBouquet()' style='margin:3px'/>
							<input type='button' class='jqxbutton c_p' value='Cancel' onclick='cancelNewBouquet()' style='margin:3px'/>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript" src="./../js/NovaBouquet.js"></script>