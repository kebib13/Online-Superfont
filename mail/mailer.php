<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

?>

<?php

function emailVerification($email,$mailTemplate,$subject)
{
$sent=false;

    if(filter_var($email,FILTER_VALIDATE_EMAIL)===false)
    {
        echo "<script>alert('Please enter a valid email address')</script>";
    }
    else
    {
        $mail=new PHPMailer(true); 

        try {
            //Server settings
            $mail->isSMTP();                                  //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';             //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                         //Enable SMTP authentication
            $mail->Username   = 'demoooacc06@gmail.com';      //SMTP username
            $mail->Password   = 'ngcf rlix aeoc snej';        //SMTP password
            $mail->SMTPSecure = 'tls';                        //Enable implicit TLS encryption
            $mail->Port       = 587;                          //TCP port to connect to; use 587 if you have set SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS

            $mail->setFrom('demoooacc06@gmail.com');
            $mail->addAddress($email);
            $mail->addAddress('demoooacc06@gmail.com');
            $mail->Subject =$subject;

            $mail->Body=$mailTemplate;
            $mail->isHTML(true);

            $mail->send();

            $sent=true;
            return $sent;

        }
        catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return $sent;
        }
    }
}

?>
