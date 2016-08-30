<?php
include_once (__DIR__.'./../php/socket.io.php');
class streamDataClass {
    private $error, $data, $storePath;
    
    public function __construct () {
        $this->error = 0;
        $this->data = array();
        $this->storePath = str_replace('web\Logics', 'uploads\\', __DIR__);
    }
    public function __destruct () {
        $this->error = 0;
        $this->data = array();
    }
    public function getDeviceImage () {
        $socketio = new SocketIO();
        $data = array("username" => "pappa");
        if ($socketio->send('localhost', 3001, json_encode($data))){
            $data = array("message" => "qwhbsd fhjs dhf sd", "from" => "pappa", "to" => "Abba", "action" => "oto_message");
            if ($socketio->send('localhost', 3001, json_encode($data))){
                $imageUrl = $this->getImageUrl();
                $imageComments = $this->getImageComments();
                return array('error'=> 0, 'data' => array('url' => $imageUrl, 'comments' => $imageComments, 'timestamp' => microtime(true)));
            }
        } else {
            return array('error'=> 1, 'data' => array());
        }
    }
    public function storeImage ($file, $uploadSessionId) {
        $fileName = time();
        $userId = $_SESSION['userdata']['uid'];
        $fileType = substr($file['type'],(strrpos($file['type'],'/')+1));
        $completePath = $this->storePath.$userId.'/'.$uploadSessionId;
        if (!file_exists($completePath)) {
            mkdir($completePath, 0777, true);
        }
        if(move_uploaded_file($file['tmp_name'],$completePath.'/'.$fileName.'.'.$fileType)) {
            $this->data['filename'] = $fileName.'.'.$fileType;
		} else {
            $this->error = 1;
        }
        return array('error' => $this->error, 'data' => $this->data);
    }
    private function getImageUrl () {
        return './web/images/people/people-'.rand(1,5).'.png';
    }
    private function getImageComments () {
        return 'New Comment @ '.time();
    }
}
?>