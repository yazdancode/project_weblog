<?php

namespace App\Http\Services;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use System\Config\Config;

class MailService
{
    public function send($emailAddress, $subject, $body)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->CharSet = 'UTF-8';
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host       = Config::get('mail.SMTP.Host');
            $mail->SMTPAuth   = Config::get('mail.SMTP.SMTPAuth');
            $mail->Username   = Config::get('mail.SMTP.Username');
            $mail->Password   = Config::get('mail.SMTP.Password');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = Config::get('mail.SMTP.Port');
            $mail->setFrom(Config::get('mail.SMTP.setFrom.mail'), Config::get('mail.SMTP.setFrom.name'));
            $mail->addAddress($emailAddress);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body  = $body;
            $result = $mail->send();
            return $result;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}