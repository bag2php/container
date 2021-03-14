<?php

declare(strict_types=1);

use function Bag2\Container\get;
use Bag2\Container\Container;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message as HttpMessage;

require __DIR__ . '/vendor/autoload.php';

$container = new Container([
    'birthday' => "2112-09-03",
    HttpMessage\RequestFactoryInterface::class => get(Psr17Factory::class),
    HttpMessage\ResponseFactoryInterface::class => get(Psr17Factory::class),
    HttpMessage\ServerRequestFactoryInterface::class => get(Psr17Factory::class),
    HttpMessage\StreamFactoryInterface::class => get(Psr17Factory::class),
    HttpMessage\UploadedFileFactoryInterface::class => get(Psr17Factory::class),
    HttpMessage\UriFactoryInterface::class => get(Psr17Factory::class),
    Psr17Factory::class => new \Nyholm\Psr7\Factory\Psr17Factory(),
]);

assert($container->get('birthday') === '2112-09-03');
assert($container->get(Psr17Factory::class) instanceof Psr17Factory);

assert($container->get(HttpMessage\RequestFactoryInterface::class) instanceof Psr17Factory);
assert($container->get(HttpMessage\ResponseFactoryInterface::class) instanceof Psr17Factory);
assert($container->get(HttpMessage\ServerRequestFactoryInterface::class) instanceof Psr17Factory);
assert($container->get(HttpMessage\StreamFactoryInterface::class) instanceof Psr17Factory);
assert($container->get(HttpMessage\UploadedFileFactoryInterface::class) instanceof Psr17Factory);
assert($container->get(HttpMessage\UriFactoryInterface::class) instanceof Psr17Factory);

echo "ok\n";
