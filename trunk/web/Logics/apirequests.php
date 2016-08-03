<?php
require_once __DIR__.'./../require.php';
require_once __DIR__.'/userMethods.php';
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
                    $_SESSION['uid'] = $requestResponse['data']['id'];
                    $_SESSION['uname'] = $requestResponse['data']['username'];
                }
            } else{
                $error = 'Email or password cannot be blank';
            }
            break;
        case 'signup':
            if(isset($_REQUEST['email']) && trim($_REQUEST['email']) != ''){
                $requestResponse = (new userClass)->initiateSignup($_REQUEST['email']);
            } else {
                $error = 'Email cannot be blank';
            }
            break;
        case 'logout':
            if(isset($_SESSION['uid'])) {
                SM_CloseSession();
                $requestResponse['error']  = 0;
                $requestResponse['data'] = array();
            }
        default:
            break;
    }
    if(!$requestResponse['error']){
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