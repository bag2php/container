<?php

declare(strict_types=1);

use Bag2\Container\Container;
use Nyholm\Psr7\Factory\Psr17Factory;

require __DIR__ . '/vendor/autoload.php';

$container = new Container([
    'birthday' => "2112-09-03",
    Psr17Factory::class => new \Nyholm\Psr7\Factory\Psr17Factory(),
]);

assert($container->get('birthday') === '2112-09-03');
assert($container->get(Psr17Factory::class) instanceof Psr17Factory);

echo "ok\n";
