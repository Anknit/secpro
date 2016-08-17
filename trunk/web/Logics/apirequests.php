<?php
header('Access-Control-Allow-Origin: *');
require_once __DIR__.'./../require.php';
require_once __DIR__.'/userMethods.php';
require_once __DIR__.'/streamMethods.php';
require_once __DIR__.'./../../Common/php/MailMgr.php';
require_once __DIR__.'/mailMethods.php';
$status = false;
$data = array();
$error=0;
$response = array();
if(isset($_REQUEST['requesttype'])) {
    switch($_REQUEST['requesttype']) {
        case 'login':
            if(isset($_REQUEST['email']) && trim($_REQUEST['email']) != '' && isset($_REQUEST['password']) && trim($_REQUEST['password']) != ''){
                $requestResponse = (new userClass)->validateLogin($_REQUEST['email'],$_REQUEST['password']);
                if(is_array($requestResponse) && $requestResponse['error'] == 0){
                    $_SESSION['userdata'] = array();
                    $_SESSION['userdata']['uid'] = $requestResponse['data']['id'];
                    $_SESSION['userdata']['uname'] = $requestResponse['data']['username'];
                    $_SESSION['userdata']['ustatus'] = $requestResponse['data']['userstatus'];
                    $_SESSION['userdata']['utype'] = $requestResponse['data']['usertype'];
                    $_SESSION['userdata']['fname'] = $requestResponse['data']['firstname'];
                    $_SESSION['userdata']['lname'] = $requestResponse['data']['lastname'];
                    $_SESSION['userdata']['plink'] = $requestResponse['data']['profilelink'];
                }
                else {
                    $error = $requestResponse['error'];
                }
            } else{
                $error = 'Email or password cannot be blank';
            }
            break;
        case 'signup':
            if(isset($_REQUEST['email']) && trim($_REQUEST['email']) != ''){
                $requestResponse = (new userClass)->initiateSignup(trim($_REQUEST['email']));
                if($requestResponse['error'] == 0) {
                    if(isset($_REQUEST['mobileNumber']) &&  trim($_REQUEST['mobileNumber']) != '') {
                        // send OTP to mobile
                    }
                    else{
                        // send verification link to email address
                        $verifyLink = (new userClass)->generateVerifyLink($requestResponse['data']['email'],$requestResponse['data']['userid']);
                        $requestResponse = (new mailAccess)->sendVerificationLink($requestResponse['data']['email'],$verifyLink);
                        if($requestResponse['error'] != 0) {
                            $error = 'Mail not sent';
                        }
                    }
                } else{
                    $error = $requestResponse['error'];
                }
            } else {
                $error = 'Email cannot be blank';
            }
            break;
/*
        case 'verify':
            if(isset($_REQUEST['link']) && trim($_REQUEST['link']) != '') {
                $verifyLink = trim($_REQUEST['link']);
                if (strlen($verifyLink) > 32) {
                    $secureLink = substr($verifyLink, 0, 32);
                    $linkId = substr($verifyLink, 32);
                    $linkUser = DB_Query('Select email');
                }
                header ('location: ./../../index.php?link='.trim($_REQUEST['link']));
                exit();
            } else {
                header ('location: ./../../');
                exit();
            }
*/
        case 'logout':
            SM_CloseSession();
            $requestResponse = array();
            $requestResponse['error']  = 0;
            $requestResponse['data'] = array();
            break;
        case 'imagestream':
            $requestResponse = (new streamDataClass)->getDeviceImage();
            break;
        default:
            break;
    }
    if($requestResponse['error'] == 0){
        $status = true;
        $data = $requestResponse['data'];
    }
    else{
        $data = $requestResponse['error'];
    }
}
else{
    $error = 'Invalid request';
}
$response['status'] = $status;
if($status){
    $response['data'] = $data;
}
else{
    $response['error'] = $error;
}
echo json_encode($response);
?>