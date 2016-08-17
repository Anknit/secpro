<?php
    require_once 'config.php';
    require_once PROJECT.'/require.php';
    if(isset($_SESSION) && isset($_SESSION['userdata'])) {
        require_once PROJECT.'/app.php';
    } else if(isset($_REQUEST['verifyaccount'])) {
        require_once PROJECT.'/register.php';
    } else{
        require_once PROJECT.'/index.html';
    }
?>
