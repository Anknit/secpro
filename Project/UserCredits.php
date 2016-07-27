<?php
require '../Common/php/OperateDB/DbMgrInterface.php';

$html	=	"<html><body>";
$Tables	=	array('accountcredit_info', 'licenseinfo', 'payment_info', 'session_info', 'systemsettings', 'usageinfo', 'userinfo', 'usersubscriptioninfo', 'voucherinfotable');

	$result	=	DB_Query('SELECT userinfo.username , accountcredit_info.CreditAmount, accountcredit_info.AccountID from userinfo LEFT JOIN accountcredit_info ON userinfo.AccountID = accountcredit_info.AccountID WHERE userinfo.UserType = 3 AND userinfo.userStatus = 2', 'ASSOC');	
	if($result)
	{
		$html	.=	"<table style='border: 1px solid #E1E1E1'>";
		$html	.=	"<caption style='color: red'><b>Customer credits information</b></caption>";
		$htmlRows	=	"";
		$heading	=	"";
		for($k = 0; $k< count($result); $k++)
		{
			$htmlRows	.=	"<tr>";
			foreach($result[$k] as $key=>$value)
			{
				if($k == 0)
				{
					$heading[]	=	$key;
				}	
				$htmlRows	.=	"<td style='border: 1px solid #E1E1E1'>".$value."</td>";
			}
			$htmlRows	.=	"</tr>";
		}
		
		//Heading row
		$html	.=	"<tr>";
		for($j = 0; $j < count($heading); $j++)
		{
			$html	.=	"<td style='border: 1px solid #E1E1E1'><b>".$heading[$j]."</b></td>";
		}
		$html	.=	"</tr>".$htmlRows;
		$html	.=	"</table>";
	}
	
$html	.=	"</body></html>";
echo $html;
?>
