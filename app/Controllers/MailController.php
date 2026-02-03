<?php

namespace App\Controllers;

use Config\Container;
use App\Models\Mail;
use App\Mail\verificationMail;


class MailController
{
    protected $container;
    protected $mail;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->mail = new Mail($this->container);
    }
    public function verify()
    {
        $token = $this->mail->makeurl();
        $mailo = new verificationMail();
        $mailo->build($token);
    }
}
