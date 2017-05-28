<?php declare(strict_types=1);
require dirname(__DIR__) . '/vendor/autoload.php';

use React\EventLoop\Factory as EventLoopFactory;
use React\EventLoop\Timer\Timer;
use WyriHaximus\React\ChildProcess\Closure\ClosureChild;
use WyriHaximus\React\ChildProcess\Closure\MessageFactory;
use WyriHaximus\React\ChildProcess\Messenger\Factory as MessengerFactory;
use WyriHaximus\React\ChildProcess\Messenger\Messages\Payload;
use WyriHaximus\React\ChildProcess\Messenger\Messenger;

$loop = EventLoopFactory::create();

MessengerFactory::parentFromClass(ClosureChild::class, $loop)->then(function (Messenger $messenger) use ($loop) {
    $messenger->on('error', function ($e) {
        echo 'Error: ', var_export($e, true), PHP_EOL;
    });

    $i = 0;
    $loop->addPeriodicTimer(1, function (Timer $timer) use (&$i, $messenger) {
        if ($i >= 13) {
            $timer->cancel();
            $messenger->softTerminate();

            return;
        }

        $messenger->rpc(MessageFactory::rpc(function () {
            return ['time' => time()]; // Note that you ALWAYS MUST return an array
        }))->done(function (Payload $payload) {
            echo $payload['time'], PHP_EOL;
        });

        $i++;
    });
});

$loop->run();
