<?php

namespace App\Mail;

use Config\mailer;

class verificationMail
{
    public function build($url)
    {
        ob_start();
        $name = "heet";
        include __DIR__ . "/../../Resources/Views/verificationemail.php";
        $html = ob_get_clean();
        $subject = "heet patel";
        $email = $_SESSION['email'];

        $mail = new mailer();
        $mail->send($subject, $html, $email);
    }
}
