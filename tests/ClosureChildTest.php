<?php

declare(strict_types=1);

namespace WyriHaximus\React\Tests\ChildProcess\Closure;

use React\EventLoop\Loop;
use React\Socket\ConnectionInterface;
use WyriHaximus\AsyncTestUtilities\AsyncTestCase;
use WyriHaximus\React\ChildProcess\Closure\ClosureChild;
use WyriHaximus\React\ChildProcess\Closure\MessageFactory;
use WyriHaximus\React\ChildProcess\Messenger\ChildProcess\Options;
use WyriHaximus\React\ChildProcess\Messenger\Messenger;

/**
 * @internal
 */
final class ClosureChildTest extends AsyncTestCase
{
    public function testExecuteClosure(): void
    {
        $connection = $this->prophesize(ConnectionInterface::class)->reveal();
        $messenger  = new Messenger($connection, new Options('', '', 13));

        ClosureChild::create($messenger, Loop::get());

        $data = 1337;

        $result = $this->await($messenger->callRpc(
            MessageFactory::CLOSURE_EXECUTE,
            /** @phpstan-ignore-next-line */
            MessageFactory::rpc(static function () use ($data) {
                return $data;
            })->getPayload()
        ));

        self::assertSame(1337, $result);
    }
}
