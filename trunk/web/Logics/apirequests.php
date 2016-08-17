<?php
header('Access-Control-Allow-Origin: *');
require_once __DIR__.'./../require.php';
require_once __DIR__.'/userMethods.php';
require_once __DIR__.'/streamMethods.php';
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
                $requestResponse = (new userClass)->initiateSignup($_REQUEST['email']);
                if($requestResponse['error'] == 0) {
                    if(isset($_REQUEST['mobileNumber']) &&  trim($_REQUEST['mobileNumber']) != '') {
                        // send OTP to mobile
                    }
                    else{
                        // send verification link to email address
                    }
                } else{
                    $error = $requestResponse['error'];
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