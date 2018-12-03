<?php declare(strict_types=1);

namespace WyriHaximus\React\Tests\ChildProcess\Closure;

use PHPUnit\Framework\TestCase;
use React\EventLoop\Factory;
use React\Socket\ConnectionInterface;
use WyriHaximus\React\ChildProcess\Closure\ClosureChild;
use WyriHaximus\React\ChildProcess\Closure\MessageFactory;
use WyriHaximus\React\ChildProcess\Messenger\Messenger;
use function Clue\React\Block\await;

/**
 * @internal
 */
final class ClosureChildTest extends TestCase
{
    public function testExecuteClosure(): void
    {
        $loop = Factory::create();
        $connection = $this->prophesize(ConnectionInterface::class)->reveal();
        $messenger = new Messenger($connection, []);

        ClosureChild::create($messenger, $loop);

        $data = 1337;

        $result = await($messenger->callRpc(
            MessageFactory::CLOSURE_EXECUTE,
            MessageFactory::rpc(function () use ($data) {
                return $data;
            })->getPayload()
        ), $loop);

        self::assertSame(1337, $result);
    }
}
