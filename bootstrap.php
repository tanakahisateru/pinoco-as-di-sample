<?php
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}
else {
    // 適当にPinocoを置いてください。
    require_once __DIR__ . '/vendor/pinoco/pinoco/src/Pinoco.php';
    // ただのサンプルです。良い子のみんなはこんなローダー作っちゃダメだよ。
    spl_autoload_register(function($class) {
        require_once __DIR__ . '/class/' . $class . '.php';
    });
}

/**
 * システムグローバルなDIコンテナを提供するファクトリ
 */
class SystemDIContainerFactory
{
    protected static $container;

    public static function getContainer()
    {
        if (isset(static::$container)) {
            return static::$container;
        }

        $container = new Pinoco_Vars;

        $container->setDefault(new MissingDependency());

        $container->registerAsLazy('mailer', function($container) {
            return new SendmailMailer;
        });
        $container->registerAsLazy('testmailer', function($container) {
            return new EchoMailer;
        });
        $container->registerAsLazy('newsletter', function($container) {
            // return new NewsletterTransferOld($container);
            return new NewsletterTransfer($container->mailer);
        });

        static::$container = $container;

        return static::$container;
    }
}

class MissingDependency
{
    public function __get($name)
    {
        new Exception("Some dependency missing for property: " . $name);
    }

    public function __call($name, $args)
    {
        new Exception("Some dependency missing for method: " . $name);
    }
}

