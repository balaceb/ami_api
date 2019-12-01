<?php 
    
    require_once '../config/config.inc.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require '../PHPMailer/src/Exception.php';
    require '../PHPMailer/src/PHPMailer.php';
    require '../PHPMailer/src/SMTP.php';
    
    class PhpGenericEmail
    {
        
        // email config info
        
        private $email_host;
        private $email_from;
        private $email_from_name;
        private $email_pwd;
        
        // constructor with $db as database connection
        public function __construct($email_host, $email_from, $email_from_name, $email_pwd)
        {           
            date_default_timezone_set('Africa/Johannesburg');
            
            $this->email_from       = $email_from;
            $this->email_from_name  = $email_from_name;
            $this->email_host       = $email_host;
            $this->email_pwd        = $email_pwd;
        }
        
        
        // read products
        public function genericSendEmail($receiver, $receiver_name, $subject, $msg_body_html, $msg_body_no_html, array $attachments=null )
        {
            $mail = new PHPMailer(true);
            
            if ( ('' === $receiver) || ('' === $receiver_name) ) {
                return false;
            }
            
            try {
                //Server settings
                $mail->SMTPDebug = 0;                                       // 2 ==> Enable verbose debug output
                $mail->isSMTP();                                            // Set mailer to use SMTP
                $mail->Host       = $this->email_host; //GENERIC_EMAIL_HOST;                         // Specify main and backup SMTP servers
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = $this->email_from; //GENERIC_FROM_EMAIL;                         // SMTP username
                $mail->Password   = $this->email_pwd; //GENERIC_EMAIL_PWD;                          // SMTP password
                $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
                $mail->Port       = '465';                                  // TCP port to connect to
                
                //Recipients
                $mail->setFrom($this->email_from/*GENERIC_FROM_EMAIL*/, $this->email_from_name/*GENERIC_FROM_NAME*/);
                $mail->addAddress($receiver, $receiver_name);               // Add a recipient
                // $mail->addAddress('balacebb@gmail.com');                 // Name is optional
                $mail->addReplyTo(GENERIC_REPLY_EMAIL, 'Do Not Reply');
                //$mail->addCC('cc@example.com');
                
                // Attachments
                //  $mail->addAttachment('/tmp/image.jpg', 'new.jpg');      // Optional name
                
                if (null != $attachments)
                {
                    foreach ($attachments as $attachment)
                    {
                        $mail->addAttachment($attachment);                  // Add attachments
                    }
                }
                
                // Content
                if ("" != $msg_body_html) {
                    $mail->isHTML(true);                    // Set email format to HTML
                    $mail->Subject = $subject;
                    $mail->Body    = $msg_body_html;
                    $mail->AltBody = $msg_body_no_html;     // 'This is the body in plain text for non-HTML mail clients'
                }
                else
                {
                    $mail->isHTML(false);                    // Set email format to HTML
                    $mail->Subject = $subject;
                    $mail->Body    = $msg_body_no_html;
                    $mail->AltBody = $msg_body_html;         //Should have been alternative message but no html content was provided, so its empty.
                }
                
                
                return $mail->send();
                //return true;
                
            } catch (Exception $e) {
                return $mail->ErrorInfo;
            }
        }
        
    }
    
    function genericSendEmail($receiver, $receiver_name, $subject, $msg_body_html, $msg_body_no_html, array $attachments=null )
    {
        $mail = new PHPMailer(true);
        
        if ( ('' === $receiver) || ('' === $receiver_name) ) {
            return false;
        }
        
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                       // 2 ==> Enable verbose debug output
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host       = GENERIC_EMAIL_HOST;                         // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = GENERIC_FROM_EMAIL;                         // SMTP username
            $mail->Password   = GENERIC_EMAIL_PWD;                          // SMTP password
            $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = '465';                                  // TCP port to connect to
            
            //Recipients
            $mail->setFrom(GENERIC_FROM_EMAIL, GENERIC_FROM_NAME);
            $mail->addAddress($receiver, $receiver_name);               // Add a recipient
            // $mail->addAddress('balacebb@gmail.com');                 // Name is optional
            $mail->addReplyTo(GENERIC_REPLY_EMAIL, 'Do Not Reply');
            //$mail->addCC('cc@example.com');
            
            // Attachments
            //  $mail->addAttachment('/tmp/image.jpg', 'new.jpg');      // Optional name
            
            if (null != $attachments) 
            {
                foreach ($attachments as $attachment) 
                {
                    $mail->addAttachment($attachment);                  // Add attachments
                }
            }
            
            // Content
            if ("" != $msg_body_html) {
                $mail->isHTML(true);                    // Set email format to HTML
                $mail->Subject = $subject;
                $mail->Body    = $msg_body_html;
                $mail->AltBody = $msg_body_no_html;     // 'This is the body in plain text for non-HTML mail clients'
            }
            else
            {
                $mail->isHTML(false);                    // Set email format to HTML
                $mail->Subject = $subject;
                $mail->Body    = $msg_body_no_html;
                $mail->AltBody = $msg_body_html;         //Should have been alternative message but no html content was provided, so its empty.
            }
                                 
            
            return $mail->send();
            //return true;
            
        } catch (Exception $e) {
            return $mail->ErrorInfo;
        }
    }
                                                
?>