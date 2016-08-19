<?php
class streamDataClass {
    private $error, $data, $storePath;
    
    public function __construct () {
        $this->error = 0;
        $this->data = array();
        $this->storePath = str_replace('web/Logics', 'uploads/', __DIR__);
    }
    public function __destruct () {
        $this->error = 0;
        $this->data = array();
    }
    public function getDeviceImage () {
        $imageUrl = $this->getImageUrl();
        $imageComments = $this->getImageComments();
        return array('error'=> 0, 'data' => array('url' => $imageUrl, 'comments' => $imageComments, 'timestamp' => microtime(true)));
    }
    public function storeImage ($file) {
/*
     	$file_loc = $_FILES['file']['tmp_name'];
		$file_size = $_FILES['file']['size'];
		$new_size = $file_size/1024;
*/
        $fileName = time();
        $fileType = $file['type'];
        if(move_uploaded_file($file['tmp_name'],$this->storePath.$fileName.'.'.$fileType)) {
			 $this->data['filename'] = $fileName.'.'.$fileType;
		} else {
            this->error = 1;
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