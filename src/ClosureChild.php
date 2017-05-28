<?php declare(strict_types=1);

namespace WyriHaximus\React\ChildProcess\Closure;

use React\EventLoop\LoopInterface;
use React\Promise\PromiseInterface;
use SuperClosure\Serializer;
use Throwable;
use WyriHaximus\React\ChildProcess\Messenger\ChildInterface;
use WyriHaximus\React\ChildProcess\Messenger\Messages\Payload;
use WyriHaximus\React\ChildProcess\Messenger\Messenger;
use function React\Promise\reject;
use function React\Promise\resolve;

final class ClosureChild implements ChildInterface
{
    /**
     * @var Messenger
     */
    private $messenger;

    /**
     * @var LoopInterface
     */
    private $loop;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @param Messenger     $messenger
     * @param LoopInterface $loop
     */
    private function __construct(Messenger $messenger, LoopInterface $loop)
    {
        $this->messenger = $messenger;
        $this->loop = $loop;
        $this->serializer = new Serializer();

        $this->messenger->registerRpc(
            MessageFactory::CLOSURE_EXECUTE,
            function (Payload $payload) {
                return $this->executeClosure($payload->getPayload()['closure']);
            }
        );
    }

    /**
     * @param  Messenger     $messenger
     * @param  LoopInterface $loop
     * @return ClosureChild
     */
    public static function create(Messenger $messenger, LoopInterface $loop): ClosureChild
    {
        return new self($messenger, $loop);
    }

    /**
     * @param  string           $closure
     * @return PromiseInterface
     */
    private function executeClosure(string $closure): PromiseInterface
    {
        try {
            $unserialized = $this->serializer->unserialize($closure);

            return resolve($unserialized());
        } catch (Throwable $throwable) {
            return reject($throwable);
        }
    }
}
