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
  
    // Connecting to database
    public function sendUserRegistrationEmail($userName, $firstName, $lastName, $email) {
        
        $mail = new PHPMailer;

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com;';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'test@test.sg';                 // SMTP username
        $mail->Password = 'test1234';                           // SMTP password
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

        $mail->Subject = 'Welcome to LMS';
        $mail->Body    = generateWelcomeEmailMessage();
        $mail->AltBody = generateWelcomeEmailMessage();

        if(!$mail->send()) {
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
        return 'Hello';
    }
} 
?>