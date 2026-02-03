<?php

namespace Config;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class mailer
{
    public function send($subject, $html, $email)
    {

        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = getenv('MAIL_Host');
        $mail->SMTPAuth   = getenv('MAIL_SMTPAuth');
        $mail->Username = getenv('MAIL_Username');
        $mail->Password = getenv('MAIL_Password');
        $mail->Port = getenv('MAIL_Port');

        $mail->setFrom(getenv('MAIL_FROM_ADDRESS'), getenv('MAIL_NAME'));
        $mail->isHTML(true);

        $mail->Subject = $subject;
        $mail->Body = $html;
        $mail->addAddress($email);
        $mail->send();
        echo "Mail sent to Mailtrap!";
    }
}
