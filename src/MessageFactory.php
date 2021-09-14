<?php

declare(strict_types=1);

namespace WyriHaximus\React\ChildProcess\Closure;

use Closure;
use Opis\Closure\SerializableClosure;
use WyriHaximus\React\ChildProcess\Messenger\Messages\Factory;
use WyriHaximus\React\ChildProcess\Messenger\Messages\Rpc;

use function serialize;

final class MessageFactory
{
    public const CLOSURE_EXECUTE = 'wyrihaximus.react.child-process.closure.child.execute';

    public static function rpc(Closure $closure): Rpc
    {
        return Factory::rpc(
            self::CLOSURE_EXECUTE,
            [
                'closure' => serialize(new SerializableClosure($closure)),
            ]
        );
    }
}
