<?php ?>
<div id='HomePageAgents' style='display:none' class='container tabDiV'>
<!--
	<div class='container_div menu_container'>
		<div class='item_container_div f_l'>
			<div class='menu_item'>
				<input type='button' class='jqxbutton menu_item_disable c_p' value='Edit' disabled="disabled" onclick='editAgent()'/>
			</div>
		</div>
		<div class='item_container_div f_l'>
			<div class='menu_item'>
				<input type='button' class='jqxbutton menu_item_disable c_p' value='Apply' disabled="disabled" onclick='saveAgent()'/>
			</div>
		</div>
		<div class='item_container_div f_l'>
			<div class='menu_item'>
				<input type='button' class='jqxbutton menu_item_disable c_p' value='Remove' disabled="disabled" onclick='deleteAgent(this)'/>
			</div>
		</div>
	</div>
-->
	<h3 style="  width: 98%;  margin: 15px auto;"> Agents</h3>
	<hr style="width: 98%;  margin: auto;" />

	<div class='container_div'>
		<div>
			<table id="AgentTable" class="convertTojqGrid ui-grid-Font" url="fetchData.php?data=agent&act=grid" colNames="Agent Name, Description, Assigned Node, Agent Type, Agent State" colModel="agentColModel" sortBy="agentId" tableDataVar="AgentTableData" gridComplete="agentColModelFormatterFunction" gridWidth='0.97', gridHeight='0.80'></table>
			<div id="gridpager_AgentTable"></div>
		</div>
		<div style="clear:both"></div> 
	</div>
<script type="text/javascript" src="./../js/NovaAgent.js"></script>
</div>