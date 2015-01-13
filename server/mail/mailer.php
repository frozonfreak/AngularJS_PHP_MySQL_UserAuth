<?php
  
class Mailer {
  
    // constructor
    function __construct() {
        require_once 'config.php';
        require_once 'PHPMailer/PHPMailerAutoload.php';
    }
  
    // destructor
    function __destruct() {
        
    }
  
    public function sendUserRegistrationEmail($userName, $firstName, $lastName, $email) {
        
        $mail = new PHPMailer;

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = DEFAULT_SMTP_HOST;  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = DEFAULT_SMTP_USER;                 // SMTP username
        $mail->Password = DEFAULT_SMTP_PASSWORD;                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to


        $mail->From = 'test@test.com';
        $mail->FromName = 'App Support';
        $mail->addAddress($email);  // Name is optional
        
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        $mail->WordWrap = 150;                                 // Set word wrap to 50 characters
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'Welcome Message';
        $mail->Body    = $this->generateWelcomeEmailMessage();
        $mail->AltBody = $this->generateWelcomeEmailMessage();

        if($mail->send()) {
            $response = array("status" => 0,
                              "message"=> "Success");
        } 
        else {
            $response = array("status" => 1,
                              "message"=> "Failed");
        }
        return $response;
    }
    
    public function sendPasswordResetEmail($email, $resetURL) {
        
        $mail = new PHPMailer;

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = DEFAULT_SMTP_HOST;  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = DEFAULT_SMTP_USER;                 // SMTP username
        $mail->Password = DEFAULT_SMTP_PASSWORD;                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        $mail->From = 'test@test.com';
        $mail->FromName = 'App Support';
        $mail->addAddress($email);  // Name is optional
        
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        $mail->WordWrap = 150;                                 // Set word wrap to 50 characters
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'Password reset';
        $mail->Body    = $this->generateResetEmailMessage($resetURL);
        $mail->AltBody = $this->generateResetEmailMessage($resetURL);

        if($mail->send()) {
            $response = array("status" => 0,
                              "message"=> "Success");
        } 
        else {
            $response = array("status" => 1,
                              "message"=> "Failed");
        }
        return $response;
    }

    public function generateWelcomeEmailMessage(){
        //HTML Template Goes here
        return 'Hello';
    }

    public function generateResetEmailMessage($resetURL){
        //HTML Template goes here
        return $resetURL;
    }
} 
?>
