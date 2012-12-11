<?php
class NewsletterTransferTest extends PHPUnit_Framework_TestCase
{
    private $container;

    function setUp()
    {
        $this->container = SystemDIContainerFactory::getContainer();
    }

    function testOldImplementation()
    {
        $transfer = new NewsletterTransferOld($this->container);
        $transfer->send("メリークリスマスだぜイェーイ");
    }

    function testSend()
    {
        ob_start();
        $transfer = new NewsletterTransfer($this->container->testmailer);
        $transfer->send("メリークリスマス注入だぜイェーイ");
        $result = ob_get_clean();

        $this->assertEquals("メリークリスマス注入だぜイェーイ\n", $result);
    }

    function testSendViaDI()
    {
        $transfer = $this->container->transfer;
        $transfer->send("メリークリスマス注入だぜイェーイ");
    }
}
