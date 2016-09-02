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
                    $this->data['socketid'] = $userRow[0]['id'].time();
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
    public function initiateSignup ($email, $fname = '' , $lname = '', $pswd = '', $phone = '') {
        $userExist = $this->checkUserExist($email);
        if(!$userExist){
            $createUser = $this->createUser($email,$fname,$lname,$pswd,$phone);
            if(!$createUser) {
                $this->error = 2;
            } else{
                $this->data = array('email'=>$email, 'userid' =>$createUser);
            }
        }
        else{
            $this->error = 1;
        }
        return array('error'=>$this->error,'data'=>$this->data);
    }
    public function generateVerifyLink ($email, $userid) {
        $secureLink = md5($email.$userid);
        $storeLink = DB_Insert(array(
            'Table' => 'verificationlinks',
            'Fields'=> array(
                'userId' => $userid,
                'verificationLink' => $secureLink
            )
        ));
        return $secureLink.$storeLink;
    }
    public function registerUser ($email, $password, $fname, $lname, $reflink, $linkid) {
        $userId = DB_Read(array(
            'Table'=>'verificationlinks',
            'Fields'=>'userId',
            'clause'=>'linkId='.$linkid.' and verificationlink = "'.$reflink.'"'
        ));
        if($userId && count($userId) == 1) {
            $userId = $userId[0]['userId'];
            $updateUser = Db_Update(array(
                'Table' => 'userdata',
                'Fields'=> array(
                    'userstatus' => ACTIVE_USER,
                    'password' => md5($password),
                    'firstname' => $fname,
                    'lastname' => $lname,
                    'registeredusing' => REGISTER_BY_MAIL
                ),
                'clause' => 'id='.$userId.' and email = "'.$email.'"'
            ));
            if($updateUser) {
                $deleteVerificationLink = DB_Delete(array(
                    'Table' => 'verificationlinks',
                    'clause' => 'linkId='.$linkid
                ));
                if(!$deleteVerificationLink) {
                    $this->error = 3;
                }
            } else {
                $this->error = 2;
            }
        } else {
            $this->error = 1;
        }
        return array('error'=>$this->error,'data'=>$this->data);
    }
    public function updateDeviceInfo ($mobileNum, $userId) {
        $updateMobileNum = DB_Update(array(
            'Table' => 'userdata',
            'Fields'=> array(
                'phone' => $mobileNum
            ),
            'clause' => 'id='.$userId
        ));
        if(!$updateMobileNum) {
            $this->error = 1;
        }
        return array('error'=> $this->error, 'data' => array());
    }
    private function createUser ($email,$fname,$lname,$pswd,$phone) {
        $userId = DB_Insert(array(
            'Table' => 'userdata',
            'Fields'=> array(
                'email' => $email,
                'username' => $email,
                'firstname' => $fname,
                'lastname' => $lname,
                'password' => md5($pswd),
                'phone' => $phone,
                'userstatus' => UNVERIFIED_USER,
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