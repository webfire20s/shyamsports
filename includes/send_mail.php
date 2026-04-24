<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

function sendAthleteMail($toEmail, $toName, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        // 🔐 USE YOUR EMAIL HERE
        $mail->Username = 'shyamvir20799@gmail.com';
        $mail->Password = 'kbufiryopixeainu';

        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('shyamvir20799@gmail.com', 'Shyamvir Dadda Sports Development Trust');
        $mail->addAddress($toEmail, $toName);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        return true;

    } catch (Exception $e) {
        return false;
    }
}