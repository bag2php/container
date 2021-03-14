<?php

declare(strict_types=1);

use Bag2\Container\Container;

require __DIR__ . '/vendor/autoload.php';

$container = new Container([
    'birthday' => "2112-09-03",
]);

assert($container->get('birthday') === '2112-09-03');

echo "ok\n";
