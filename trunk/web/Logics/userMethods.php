<?php
class userClass {
    private $error, $data;
    public function __construct () {
        $this->error = 0;
        $this->data = array();
    }
    public function __destruct () {
        
    }
    public function validateLogin ($email, $password) {
        $userRow = $this->checkUserExist($email);
        if($userRow && count($userRow) == 1){
            if($userRow[0]['userstatus'] == ACTIVE_USER) {
                if(md5($password) == $userRow[0]['password']){
                    unset($userRow[0]['password']);
                    $this->data = $userRow[0];
                }
                else{
                    $this->error = 3;
                }
            }
            else{
                $this->error = 2;
            }
        }
        else{
            $this->error = 1;
        }
        return array('error'=>$this->error,'data'=>$this->data);
    }
    public function initiateSignup ($email) {
        $userExist = $this->checkUserExist($email);
        if(!$userExist){
            $createUser = $this->createUser($email);
            if(!$createUser) {
                $this->error = 2;
            }
        }
        else{
            $this->error = 1;
        }
        return $this->error;
    }
    private function createUser ($email) {
        $userId = DB_Insert(array(
            'Table' => 'userdata',
            'Fields'=> array(
                'email' => $email,
                'username' => $email,
                'userstatus' => USER_UNVERIFIED,
                'usertype' => NORMAL,
                'logintype' => EMAIL,
                'registeredon' => date("Y-m-d H:i:s")
            )
        ));
        return $userId;
    }
    private function checkUserExist ($email) {
        $userData = DB_Read(array(
            'Table' => 'userdata',
            'Fields' => '*',
            'clause' => 'username = "'.$email.'"'
        ),"ASSOC","");
        return $userData;
    }
    
}
?>