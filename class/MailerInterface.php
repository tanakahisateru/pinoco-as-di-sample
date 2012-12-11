<?php
/**
 * メールを送信するインターフェース
 */
interface MailerInterface
{
    public function send($body);
}

