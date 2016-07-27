<?php ?>
<div class='tabDiV' id='HomePageNodes'>
	<div class='container_div menu_container'>
		<div class='item_container_div f_l'>
			<div class='menu_item'>
				<input type='button' class='jqxbutton c_p' value='Add' title="Add New Node" onclick='openNewItemForm(this)' openDivID='node_add_form'/>
			</div>
		</div>
		<div class='item_container_div f_l'>
			<div class='menu_item'>
				<input type='button' class='jqxbutton menu_item_disable c_p' value='Edit' title="Edit Node" disabled="disabled" onclick='editNode()'/>
			</div>
		</div>
		<div class='item_container_div f_l'>
			<div class='menu_item'>
				<input type='button' class='jqxbutton menu_item_disable c_p' value='Apply' title="Save Changes" disabled="disabled" onclick='saveNode()'/>
			</div>
		</div>
		<div class='item_container_div f_l'>
			<div class='menu_item'>
				<input type='button' class='jqxbutton menu_item_disable c_p' value='Remove' title="Remove Node" disabled="disabled" onclick='deleteNode()'/>
			</div>
		</div>
	</div>
	<hr />
	<div class='half_page f_l'>
		<div class='container_div'>
			<table id="NodeTable" class="convertTojqGrid ui-grid-Font" url="fetchData.php?data=node&act=grid" colNames=", Node Name, Description, Backup Agents, " colModel="nodeColModel" sortBy="nodeId" gridComplete="nodeColModelFormatterFunction" selectRowFunc="nodeColModelFormatterFunction" gridWidth='0.48', gridHeight='0.75'></table>
			<div id="gridpager_NodeTable"></div>
			<div style="clear:both"></div> 
		</div>
		<div class='container_div sub_list_container main_table_linked'>
			<div class='f_l list_table_container' id='NodeAgentListDiv' style="display:none !important">
			</div>
			<div style="clear:both"></div> 
		</div>
	</div>
	<div class='half_page f_l'>
		<div class='container_div sub_list_container' id='allNodeAgentsGridDiv'>
			<table id="AllAgentsTable" class="convertTojqGrid ui-grid-Font" url="fetchData.php?data=agent&act=grid" colNames=", Agent Name, Node Name, Agent State, Agent Type" colModel="allAgentColModel" sortBy="agentId" gridComplete="allAgentColModelFormatterFunction" gridWidth='0.48', gridHeight='0.75'></table>
			<div id="gridpager_AllAgentsTable"></div>
			<div style="clear:both"></div>
<!-- 		<div class='container_div' id='nodeInfoEditDiv'>
				<table>
					<tr>
						<td>Backup Agents</td>
						<td><input type="number" min="0" id="nodeBackupAgent" /></td>
					</tr>
					<tr>
						<td>Node Description</td>
						<td><textarea id="nodeDescriptionEdit"></textarea></td>
					</tr>
				</table>
			</div>  -->	
		</div>
	</div>
	
	<div id='node_add_form' class='modal_div'>
		<div class='windowHead'>
			Add Node
		</div>
		<div class='windowBody'>
			<table>
				<tr>
					<td>Node Name</td>
					<td>
						<input type='text' name='new_node_input_name' id='new_node_input_name' title='Provide a name for this node'/>
					</td>
				</tr>
				<tr>
					<td>Description</td>
					<td>
						<textarea name='new_node_input_description' id='new_node_input_description' title='Enter description of node'></textarea>
					</td>
				</tr>
				<tr>
					<td colspan='2'>
						<div class='new_node_item_container' align='center'>
							<input type='button' class='jqxbutton c_p' value='OK' onclick='addNode()'/>
							<input type='button' class='jqxbutton c_p' value='Cancel' onclick='cancelNewNode()'/>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript" src="./../js/NovaNode.js"></script>