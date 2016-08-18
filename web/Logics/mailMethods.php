<?php
    class mailAccess {
        private $mailConfig, $error, $data, $verifyUrl;
        public function __construct () {
            $this->mailConfig = array(
                'smtpAuth' => 'true',
                'smtpHostName'	=>	'mail.veneratech.com',		
                'smtpPort'		=>	'25',
                'smtpUsername'	=>	'ankit.agrawal@veneratech.com',
                'smtpPassword'	=>	'ankit@24',
                'sender'		=>	'Administrator'
            );
            $this->verifyUrl = "http://localhost/web_stuff/trunk/assembla/ankit/secpro";
            $this->error = 0;
            $this->data = array();
        }
        public function __destruct () {
            
        }
        public function sendVerificationLink ($recipient, $encryptLink) {
            $mailSubject = 'Account Verification Link from Secpro';
            $MailBody = '<html><body><p>Click&nbsp;<a href="'.$this->verifyUrl.'/accounts/verify/'.$encryptLink.'">here</a></p></body></html>';
            $config = $this->mailConfig;
            $mailResponse = send_Email( $recipient, $mailSubject, $MailBody, '', '', $config);
            if(!$mailResponse) {
                $this->error = 1;
            }
            return array('data'=>$this->data, 'error'=> $this->error);
        }
        public function sendWelcomeMail ($recipient) {
            $mailSubject = 'Welcome to Secpro';
            $MailBody = '<html><body><p>Welcome to &nbsp;<a href="'.$this->verifyUrl.'">Secpro</a></p></body></html>';
            $config = $this->mailConfig;
            $mailResponse = send_Email( $recipient, $mailSubject, $MailBody, '', '', $config);
            if(!$mailResponse) {
                $this->error = 1;
            }
            return array('data'=>$this->data, 'error'=> $this->error);
        }
    }
?>