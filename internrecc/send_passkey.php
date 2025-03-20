<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $passkey = rand(100000, 999999); // Generate a 6-digit passkey
    $expiry = time() + 60; // Passkey valid for 60 seconds

    // Store the passkey and expiry in session
    session_start();
    $_SESSION['passkey'] = $passkey;
    $_SESSION['passkey_expiry'] = $expiry;

    // Send the passkey via email using PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'your_email@gmail.com'; // Your Gmail address
        $mail->Password = 'your_email_password'; // Your Gmail password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
        $mail->Port = 587; // TCP port to connect to

        // Recipients
        $mail->setFrom('no-reply@internrec.com', 'INTERNREC');
        $mail->addAddress($email); // Add a recipient

        // Content
        $mail->isHTML(false); // Set email format to plain text
        $mail->Subject = 'Your Passkey for INTERNSHIP RECRUITMENT PLATFORM';
        $mail->Body = "Your passkey is: $passkey\nThis passkey is valid for 60 seconds.";

        $mail->send();
        echo json_encode(['status' => 'success', 'message' => 'Passkey sent to your email.']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to send passkey. Error: ' . $mail->ErrorInfo]);
    }
}
?>