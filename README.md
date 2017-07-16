# ReactPHP Child Process Messenger/Pool Closure child class

[![Linux Build Status](https://travis-ci.org/WyriHaximus/reactphp-child-process-closure.png)](https://travis-ci.org/WyriHaximus/reactphp-child-process-closure)
[![Latest Stable Version](https://poser.pugx.org/WyriHaximus/react-child-process-closure/v/stable.png)](https://packagist.org/packages/WyriHaximus/react-child-process-closure)
[![Total Downloads](https://poser.pugx.org/WyriHaximus/react-child-process-closure/downloads.png)](https://packagist.org/packages/WyriHaximus/react-child-process-closure)
[![Code Coverage](https://scrutinizer-ci.com/g/WyriHaximus/reactphp-child-process-closure/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/WyriHaximus/reactphp-child-process-closure/?branch=master)
[![License](https://poser.pugx.org/WyriHaximus/react-child-process-closure/license.png)](https://packagist.org/packages/wyrihaximus/react-child-process-closure)
[![PHP 7 ready](http://php7ready.timesplinter.ch/WyriHaximus/reactphp-child-process-closure/badge.svg)](https://travis-ci.org/WyriHaximus/reactphp-child-process-closure)

Run closures in a child process messenger or pool

### Installation ###

To install via [Composer](http://getcomposer.org/), use the command below, it will automatically detect the latest version and bind it with `~`.

```
composer require wyrihaximus/react-child-process-closure 
```

## Usage ##

Run a closure on the child process and get the results. (Note that results have to be a JSON serializable array.) 

```php
use React\EventLoop\Factory as EventLoopFactory;
use WyriHaximus\React\ChildProcess\Closure\ClosureChild;
use WyriHaximus\React\ChildProcess\Closure\MessageFactory;
use WyriHaximus\React\ChildProcess\Messenger\Factory as MessengerFactory;
use WyriHaximus\React\ChildProcess\Messenger\Messages\Payload;
use WyriHaximus\React\ChildProcess\Messenger\Messenger;

$loop = EventLoopFactory::create();

MessengerFactory::parentFromClass(ClosureChild::class, $loop)->then(function (Messenger $messenger) use ($loop) {
    $messenger->rpc(MessageFactory::rpc(function () {
        return resolve(['time' => time()]);
    })->done(function (Payload $payload) {
        echo 'Time in the child process: ', $payload['time'], PHP_EOL;
    });
});

$loop->run();
```

The usage example above also works with [`wyrihaximus/react-child-process-pool`](https://github.com/wyrihaximus/reactphp-child-process-pool/tree/readme-upgrades#flexible), just be sure to use `WyriHaximus\React\ChildProcess\Closure\MessageFactory` to create the RPC messages as shown in the example.

## Examples ##

For more examples see the [examples](https://github.com/WyriHaximus/reactphp-child-process-closure/tree/master/examples) directory

## Contributing ##

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License ##

Copyright 2017 [Cees-Jan Kiewiet](http://wyrihaximus.net/)

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.
