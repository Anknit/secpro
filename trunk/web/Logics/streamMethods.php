<?php
class streamDataClass {
    private $error, $data;
    
    public function __construct () {
        $this->error = 0;
        $this->data = array();
    }
    public function __destruct () {
        
    }

    public function getDeviceImage () {
        $imageUrl = $this->getImageUrl();
        $imageComments = $this->getImageComments();
        return array('error'=> 0, 'data' => array('url' => $imageUrl, 'comments' => $imageComments, 'timestamp' => microtime(true)));
    }
    
    private function getImageUrl () {
        return './web/images/people/people-'.rand(1,5).'.png';
    }
    private function getImageComments () {
        return 'New Comment @ '.time();
    }
}
?>