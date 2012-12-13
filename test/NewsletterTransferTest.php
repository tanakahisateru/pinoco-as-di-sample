<?php
class NewsletterTransferTest extends PHPUnit_Framework_TestCase
{
    private $container;

    function setUp()
    {
        // 単体テストは本来ならこれが要らないはず
        $this->container = SystemDIContainerFactory::getContainer();
    }

    function testOldImplementation()
    {
        $transfer = new NewsletterTransferOld($this->container);
        $transfer->send("メリークリスマスだぜイェーイ");
    }

    function testSendFromDIContainer()
    {
        $transfer = $this->container->transfer;
        $transfer->send("メリークリスマス注入だぜイェーイ");
    }

    function testSendDependingDIContainer()
    {
        ob_start();
        $transfer = new NewsletterTransfer($this->container->testmailer);
        $transfer->send("メリークリスマス注入だぜイェーイ");
        $result = ob_get_clean();

        $this->assertEquals("メリークリスマス注入だぜイェーイ\n", $result);
    }

    function testSend()
    {
        // 本来のクリーンな単体テストはこう
        ob_start();
        $mailer = new EchoMailer; // テスト用のほう
        $transfer = new NewsletterTransfer($mailer);
        $transfer->send("メリークリスマス注入だぜイェーイ");
        $result = ob_get_clean();

        $this->assertEquals("メリークリスマス注入だぜイェーイ\n", $result);
    }
}
