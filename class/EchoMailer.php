<?php
class EchoMailer implements MailerInterface
{
    public function send($body)
    {
        echo substr($body, 0, 80) . "\n";
    }
}

