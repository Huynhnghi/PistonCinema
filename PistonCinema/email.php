<?php
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate email and message inputs
    if (isset($_POST['email']) && isset($_POST['message']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $email = htmlspecialchars($_POST['email']);
        $message = htmlspecialchars($_POST['message']);

        // Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            // Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                              // Send using SMTP
            $mail->Host       = 'smtp.elasticemail.com';                  // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                     // Enable SMTP authentication
            $mail->Username   = 'huynhnghi6809@gmail.com';                // SMTP username
            $mail->Password   = '89CDB7C5963D8F789694DE6522D64EAD00F9';   // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;           // Enable implicit TLS encryption
            $mail->Port       = 587;                                      // TCP port to connect to

            // Recipients
            $mail->setFrom('huynhnghi6809@gmail.com', 'Khách hàng');
            $mail->addAddress('huynhnghi6809@gmail.com', 'PistonCinema'); // Add a recipient

            // Optional: Set a different reply-to address
            $mail->addReplyTo($email, 'Khách hàng');

            // Attachments (optional)
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'New Contact Form Submission';
            $mail->Body    = 'Email: ' . $email . '<br>Message: ' . nl2br($message);

            $mail->send();
            header("Location: index.php");
            exit;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo 'Invalid email address or message';
    }
} else {
    echo 'Invalid request method';
}
?>
