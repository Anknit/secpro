<?php
    require_once 'config.php';
    require_once PROJECT.'/require.php';
    if(isset($_SESSION) && isset($_SESSION['uid'])) {
        require_once PROJECT.'/app.php';
    }
    else{
        require_once PROJECT.'/index.html';
    }
?>
