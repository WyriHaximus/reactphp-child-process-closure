<?php declare(strict_types=1);

namespace WyriHaximus\React\ChildProcess\Closure;

use Closure;
use SuperClosure\Serializer;
use WyriHaximus\React\ChildProcess\Messenger\Messages\Factory;

class MessageFactory
{
    const CLOSURE_EXECUTE = 'wyrihaximus.react.child-process.closure.child.execute';

    public static function rpc(Closure $closure, string $secret = null)
    {
        return Factory::rpc(
            self::CLOSURE_EXECUTE,
            [
                'closure' => (new Serializer(null, $secret))->serialize($closure),
            ]
        );
    }
}
