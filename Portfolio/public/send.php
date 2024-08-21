<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


if(isset($_POST['submitContact']))
{
    $fullname = $_POST['full_name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];


    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->Username   = 'sakshisinghal2703@gmail.com';                     //SMTP username
        $mail->Password   = 'xedgzlidolktdabdi';                               //SMTP password

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //ENCRYPTION_SMTPS 465 - Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('sakshisinghal2703@gmail.com');
        $mail->addAddress('sakshisinghal2703@gmail.com');     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'New enquiry found';

        $bodyContent = '<div>Hello, you got a new enquiry</div>
            <div>Fullname: ' . htmlspecialchars($fullname) . '</div>
            <div>Email: ' . htmlspecialchars($email) . '</div>
            <div>Subject: ' . htmlspecialchars($subject) . '</div>
            <div>Message: ' . htmlspecialchars($message) . '</div>
        ';

        $mail->Body = $bodyContent; 
        
        if($mail->send())
        {
            $_SESSION['status'] = "Thank you contact us";
            exit(0);
        }
        else
        {
            $_SESSION['status'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            exit(0);
        }    
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
else
{
    header('Location: index.html');
    exit(0);
}


// Handle displaying the status message
if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
    $messageText = $_SESSION['status'];
    $encodedMessage = json_encode($messageText);
    echo "
    <script>
        Swal.fire({
            title: 'Status',
            text: $encodedMessage,
            icon: 'success'
        });
    </script>
    ";
    unset($_SESSION['status']);
}
?>