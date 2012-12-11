<?php
class NewsletterTransferOld
{
    protected $container;

    public function __construct(Pinoco_Vars $container)
    {
        $this->container = $container;
    }

    public function send($newsletter)
    {
        $mailer = $this->container->mailer;
        //$mailer = $this->container->testmailer;
        assert($mailer instanceof MailerInterface);
        $mailer->send($newsletter);
    }
}

