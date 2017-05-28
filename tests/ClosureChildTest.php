<?php declare(strict_types=1);

namespace WyriHaximus\React\Tests\ChildProcess\Closure;

use PHPUnit\Framework\TestCase;
use React\EventLoop\Factory;
use React\Stream\Stream;
use WyriHaximus\React\ChildProcess\Closure\ClosureChild;
use WyriHaximus\React\ChildProcess\Closure\MessageFactory;
use WyriHaximus\React\ChildProcess\Messenger\Messenger;
use function Clue\React\Block\await;

final class ClosureChildTest extends TestCase
{
    public function testExecuteClosure()
    {
        $loop = Factory::create();
        $stream = $this->prophesize(Stream::class)->reveal();
        $messenger = new Messenger($stream, $stream, $stream, []);

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
