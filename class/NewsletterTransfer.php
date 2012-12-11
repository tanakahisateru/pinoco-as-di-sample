<?php
class NewsletterTransfer
{
    protected $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send($newsletter)
    {
        $this->mailer->send($newsletter);
    }
}

