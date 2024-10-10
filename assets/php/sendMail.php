<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../../vendor/autoload.php';

$response = ['success' => false, 'message' => 'Something went wrong.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'farohanna@gmail.com';                     //SMTP username
        $mail->Password   = 'gggg wtie esge nurw';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('farohanna@gmail.com', 'Mailer');
        $mail->addAddress('farohanna@gmail.com', 'Ru User');     //Add a recipient

        //Content
        $mail->isHTML(true);
        //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = "<p><strong>Name:</strong> $name</p><p><strong>Email:</strong> $email</p><p><strong>Subject:</strong> $subject</p><p><strong>Message:</strong></p><p>$message</p>";
        $mail->AltBody = "Subject: $subject\n\nMessage:\n$message";

        //$mail->send();
        //send the message, check for errors
        if ($mail->send()) {
            $response = ['success' => true, 'message' => 'Message sent!'];
        } else {
            $response = ['success' => false, 'message' => 'Mailer Error: ' . $mail->ErrorInfo];
        }
    } catch (Exception $e) {
        $response = ['success' => false, 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
