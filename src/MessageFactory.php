<?php declare(strict_types=1);

namespace WyriHaximus\React\ChildProcess\Closure;

use Closure;
use Opis\Closure\SerializableClosure;
use WyriHaximus\React\ChildProcess\Messenger\Messages\Factory;
use WyriHaximus\React\ChildProcess\Messenger\Messages\Rpc;

final class MessageFactory
{
    const CLOSURE_EXECUTE = 'wyrihaximus.react.child-process.closure.child.execute';

    /**
     * @param  Closure $closure
     * @return Rpc
     */
    public static function rpc(Closure $closure): Rpc
    {
        return Factory::rpc(
            self::CLOSURE_EXECUTE,
            [
                'closure' => \serialize(new SerializableClosure($closure)),
            ]
        );
    }
}
