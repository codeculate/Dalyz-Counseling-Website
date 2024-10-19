<?php

// Define Host Info || Who is sending emails?
define("HOST_NAME", "Dalyz Counseling");
define("HOST_EMAIL", "info@dalyzcounseling.com");

// Define SMTP Credentials || Gmail Informations
define("SMTP_EMAIL", "info@dalyzcounseling.com");
define("SMTP_PASSWORD", "nltwmmqchcwwskmp"); // read documentations


// Define Recipent Info ||  Who will get this email?
define("RECIPIENT_NAME", "Dalyz Counseling");
define("RECIPIENT_EMAIL", "info@dalyzcounseling.com");


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';





// Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->SMTPDebug = 0;                      // Enable verbose debug output
    $mail->isSMTP();                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';       // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                   // Enable SMTP authentication
    $mail->Username   = SMTP_EMAIL;             // SMTP username
    $mail->Password   = SMTP_PASSWORD;          // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable implicit TLS encryption
    $mail->Port       = 465;                    // TCP port to connect to

    // Recipients
    $mail->setFrom(HOST_EMAIL, HOST_NAME);
    $mail->addAddress(RECIPIENT_EMAIL, RECIPIENT_NAME); // Add a recipient

	// Add Reply-To address based on the form's email
    if ($senderEmail) {
        $mail->addReplyTo($senderEmail, $firstName . ' ' . $lastName);
    }


    // Content
    $firstName = isset($_POST['F-name']) ? preg_replace("/[^\.\-\' a-zA-Z0-9]/", "", $_POST['F-name']) : "";
    $lastName = isset($_POST['L-name']) ? preg_replace("/[^\.\-\' a-zA-Z0-9]/", "", $_POST['L-name']) : "";
    $senderEmail = isset($_POST['email']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['email']) : "";
    $phone = isset($_POST['Phone']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['Phone']) : "";
    $services = isset($_POST['services']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['services']) : "";
    $date = isset($_POST['date']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['date']) : "";
    $message = isset($_POST['message']) ? preg_replace("/(From:|To:|BCC:|CC:|Subject:|Content-Type:)/", "", $_POST['message']) : "";

    // Build the email body
    $mail->isHTML(true);  // Set email format to HTML
    $mail->Subject = 'A contact request sent by ' . $firstName . ' ' . $lastName;
    $mail->Body    = 'Name: ' . $firstName . ' ' . $lastName . "<br>";
    $mail->Body   .= 'Email: ' . $senderEmail . "<br>";
    $mail->Body   .= 'Phone: ' . $phone . "<br>";
    $mail->Body   .= 'Services: ' . $services . "<br>";
    $mail->Body   .= 'Preferred Date: ' . $date . "<br>";
    $mail->Body   .= 'Message: ' . "<br>" . $message;

    // Send the email
    $mail->send();
    echo "<div class='inner success'><p class='success'>Thanks for contacting us. We will contact you ASAP!</p></div><!-- /.inner -->";
} catch (Exception $e) {
    echo "<div class='inner error'><p class='error'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</p></div><!-- /.inner -->";
}
