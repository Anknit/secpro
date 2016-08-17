<?php
    if(isset($_REQUEST['verifyaccount']) && trim($_REQUEST['verifyaccount']) != '') {
        $verifyLink = trim($_REQUEST['verifyaccount']);
        if (strlen($verifyLink) > 32) {
            $secureLink = substr($verifyLink, 0, 32);
            $linkId = substr($verifyLink, 32);
            $linkUser = DB_Query('Select userdata.email from userdata left join verificationlinks on userdata.id = verificationlinks.userId where verificationlinks.linkId='.$linkId.' and verificationlinks.verificationLink="'.$secureLink.'"','ASSOC','');
            if($linkUser && count($linkUser) == 1) {
                $userEmail = $linkUser[0]['email'];
            } else {
                echo "Invalid request";
                die();
            }
        }
    } else {
        header ('location: ./');
        exit();
    }
?>
