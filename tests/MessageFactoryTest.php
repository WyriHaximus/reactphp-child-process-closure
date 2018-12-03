<?php declare(strict_types=1);

namespace WyriHaximus\React\Tests\ChildProcess\Closure;

use PHPUnit\Framework\TestCase;
use SuperClosure\Serializer;
use WyriHaximus\React\ChildProcess\Closure\MessageFactory;

/**
 * @internal
 */
final class MessageFactoryTest extends TestCase
{
    public function testRpc(): void
    {
        $message = MessageFactory::rpc(function ($v) {
            return $v;
        });

        self::assertTrue(isset($message->getPayload()['closure']));
        self::assertSame(MessageFactory::CLOSURE_EXECUTE, ((new Serializer())->unserialize($message->getPayload()['closure']))(MessageFactory::CLOSURE_EXECUTE));
    }
}
