<?php
header('Access-Control-Allow-Origin: *');
require_once __DIR__.'./../require.php';
require_once __DIR__.'/userMethods.php';
require_once __DIR__.'/uploadSession.php';
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
                if(isset($_REQUEST['mobileNumber']) &&  trim($_REQUEST['mobileNumber']) != '') {
                    $requestResponse = (new userClass)->initiateSignup(trim($_REQUEST['email']),trim($_REQUEST['firstname']),trim($_REQUEST['lastname']),trim($_REQUEST['password']),trim($_REQUEST['mobileNumber']));
                    if($requestResponse['error'] == 0) {
                        $generateOTP = '1234';              // Code for generating OTP //
                        if($generateOTP) {
                             //  code for sending OTP
                            $requestResponse = array('error'=>0,'data'=>array());
                            if($requestResponse['error'] != 0) {
                                $error = 'OTP not sent';
                            }
                        } else{
                            $error = 'OTP not generated';
                        }
                    } else{
                        $error = $requestResponse['error'];
                    }
                } else{
                    $requestResponse = (new userClass)->initiateSignup(trim($_REQUEST['email']));
                    if($requestResponse['error'] == 0) {
                        $verifyLink = (new userClass)->generateVerifyLink($requestResponse['data']['email'],$requestResponse['data']['userid']);
                        $requestResponse = (new mailAccess)->sendVerificationLink($requestResponse['data']['email'],$verifyLink);
                        if($requestResponse['error'] != 0) {
                            $error = 'Mail not sent';
                        }
                    } else{
                        $error = $requestResponse['error'];
                    }
                }
            } else {
                $error = 'Email cannot be blank';
            }
            break;
        case 'logout':
            SM_CloseSession();
            $requestResponse = array();
            $requestResponse['error']  = 0;
            $requestResponse['data'] = array();
            break;
        case 'imagestream':
            $requestResponse = (new streamDataClass)->getDeviceImage();
            break;
        case 'upload':
            if(isset($_FILES)) {
                $sessionId = 0;
                if (isset($_SESSION['uploadSession']) && isset($_SESSION['uploadSession']['sessId'])) {
                    $sessionId = $_SESSION['uploadSession']['sessId'];
                    $updateSession  = (new uploadSession)->updateSession();
                } else {
                    $sesstype = MANUAL;
                    if(isset($_REQUEST['sesstype'])) {
                        $sessType = $_REQUEST['sesstype'];
                    }
                    $sessName = time();
                    if(isset($_REQUEST['sessname'])) {
                        $sessName = $_REQUEST['sessname'];
                    }
                    $uploadSession = (new uploadSession)->startSession();
                    if($uploadSession['error'] == 0) {
                        $sessionId = $uploadSession['data']['sessid'];
                    } else {
                        $requestResponse = array('error' => 'No upload session created');
                    }
                }
                if($sessionId) {
                    $requestResponse = (new streamDataClass)->storeImage($_FILES['file'], $sessionId);
                    if ($requestResponse['error'] == 0) {
                        if($sesstype == MANUAL) {
                            $closeSession = (new uploadSession)->closeUploadSession();
                        }
                    } else {
                        $requestResponse = array('error' => 'File Upload failed');
                    }
                }
            } else {
                $requestResponse = array('error' => 'No files recieved');
            }
            break;
        case 'register':
            if(isset($_REQUEST['email']) && trim($_REQUEST['email']) != '' && isset($_REQUEST['password']) && trim($_REQUEST['password']) != ''){
                $requestResponse = (new userClass)->registerUser($_REQUEST['email'],$_REQUEST['password'],$_REQUEST['fname'],$_REQUEST['lname'],$_REQUEST['referrer'],$_REQUEST['lid']);
                if(is_array($requestResponse) && $requestResponse['error'] == 0){
                    $mailResponse = (new mailAccess)->sendWelcomeMail(trim($_REQUEST['email']));
                    if($mailResponse['error'] != 0) {
                        $error = 'Mail not sent';
                    }
                }
                else {
                    $error = $requestResponse['error'];
                }
            } else{
                $error = 'Email or password cannot be blank';
            }
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