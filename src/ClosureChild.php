<?php

declare(strict_types=1);

namespace WyriHaximus\React\ChildProcess\Closure;

use React\EventLoop\LoopInterface;
use React\Promise\PromiseInterface;
use Throwable;
use WyriHaximus\React\ChildProcess\Messenger\ChildInterface;
use WyriHaximus\React\ChildProcess\Messenger\Messages\Payload;
use WyriHaximus\React\ChildProcess\Messenger\Messenger;

use function React\Promise\reject;
use function React\Promise\resolve;
use function unserialize;

final class ClosureChild implements ChildInterface
{
    private Messenger $messenger;

    private function __construct(Messenger $messenger)
    {
        $this->messenger = $messenger;

        $this->messenger->registerRpc(
            MessageFactory::CLOSURE_EXECUTE,
            function (Payload $payload): PromiseInterface {
                return $this->executeClosure($payload->getPayload()['closure']);
            }
        );
    }

    public static function create(Messenger $messenger, LoopInterface $loop): ClosureChild
    {
        return new self($messenger);
    }

    private function executeClosure(string $closure): PromiseInterface
    {
        try {
            $unserialized = unserialize($closure)->getClosure();

            return resolve($unserialized());
        } catch (Throwable $throwable) { // @phpstan-ignore-line
            return reject($throwable);
        }
    }
}
