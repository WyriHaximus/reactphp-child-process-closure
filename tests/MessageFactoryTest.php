<?php declare(strict_types=1);

namespace WyriHaximus\React\Tests\ChildProcess\Closure;

use PHPUnit\Framework\TestCase;
use SuperClosure\Serializer;
use WyriHaximus\React\ChildProcess\Closure\MessageFactory;

final class MessageFactoryTest extends TestCase
{
    public function testRpc()
    {
        $secret = uniqid('', true);

        $message = MessageFactory::rpc(function ($v) {
            return $v;
        }, $secret);

        self::assertTrue(isset($message->getPayload()['closure']));
        self::assertSame(MessageFactory::CLOSURE_EXECUTE, ((new Serializer(null, $secret))->unserialize($message->getPayload()['closure']))(MessageFactory::CLOSURE_EXECUTE));
    }
}
