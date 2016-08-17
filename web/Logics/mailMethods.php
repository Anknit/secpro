<?php
    class mailAccess {
        private $mailConfig, $error, $data;
        public function __construct () {
            $this->mailConfig = array(
                'smtpAuth' => 'true',
                'smtpHostName'	=>	'mail.veneratech.com',		
                'smtpPort'		=>	'25',
                'smtpUsername'	=>	'ankit.agrawal@veneratech.com',
                'smtpPassword'	=>	'ankit@24',
                'sender'		=>	'Administrator'
            );
            $this->error = 0;
            $this->data = array();
        }
        public function __destruct () {
            
        }
        public function sendVerificationLink ($recipient, $encryptLink) {
            $mailSubject = 'Account Verification Link from Secpro';
            $MailBody = '<html><body><p>Click&nbsp;</p><a href="http://localhost/secpro/accounts/verify/'.$encryptLink.'">here</a></body></html>';
            $config = $this->mailConfig;
            $mailResponse = send_Email( $recipient, $mailSubject, $MailBody, '', '', $config);
            if(!$mailResponse) {
                $this->error = 1;
            }
            return array('data'=>$this->data, 'error'=> $this->error);
        }
    }
?>