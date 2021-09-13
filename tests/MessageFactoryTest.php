<?php

declare(strict_types=1);

namespace WyriHaximus\React\Tests\ChildProcess\Closure;

use WyriHaximus\AsyncTestUtilities\AsyncTestCase;
use WyriHaximus\React\ChildProcess\Closure\MessageFactory;

use function unserialize;

/**
 * @internal
 */
final class MessageFactoryTest extends AsyncTestCase
{
    public function testRpc(): void
    {
        $message = MessageFactory::rpc(static function ($v) {
            return $v;
        });

        self::assertArrayHasKey('closure', $message->getPayload()->getPayload());
        self::assertSame(MessageFactory::CLOSURE_EXECUTE, (unserialize($message->getPayload()['closure'])->getClosure())(MessageFactory::CLOSURE_EXECUTE));
    }
}
