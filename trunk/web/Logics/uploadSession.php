<?php
class uploadSession {
    private $error, $data;
    public function __construct () {
        $this->error = 0;
        $this->data = array ();
    }
    public function __destruct () {
        $this->error = 0;
        $this->data = array ();
    }
    public function startSession ($sessionName = '', $sessionType = MANUAL) {
        if($sessionName == '') {
            $sessionName = time();
        }
        $_SESSION['uploadSession'] = array ();
        $_SESSION['uploadSession']['sessName'] = $sessionName;
        $_SESSION['uploadSession']['sessType'] = $sessionType;
        $this->insertSessionInfo();
        return array('error' => $this->error, 'data' => $this->data);
    }
    private function insertSessionInfo () {
        $insertResult = DB_Insert(array(
            'Table' => 'sessiondata',
            'Fields' => array(
                'sessionname' =>$_SESSION['uploadSession']['sessName'],
                'sessiontype' =>$_SESSION['uploadSession']['sessType'],
                'sessionstart' =>'now()',
                'sessionend' =>'now()'
            )
        ));
        if($insertResult) {
            $_SESSION['uploadSession']['sessId'] = $insertResult;
            $this->data['sessid'] = $insertResult;
        } else {
            $this->error = 1;
        }
    }
    public function updateSession () {
        $updateResult = DB_Update(array(
            'Table' => 'sessiondata',
            'Fields' => array(
                'sessionend' =>'now()'
            ),
            'clause' => 'sessionid = '.$_SESSION['uploadSession']['sessId']
        ));
        if(!$updateResult) {
            $this->error = 1;
        }
    }
    public function closeUploadSession () {
        unset ($_SESSION['uploadSession']);
    }
}
?>
