<?php

declare(strict_types=1);

namespace Bag2\Container;

/**
 * @param class-string $class_name
 */
function autowire(string $class_name): Fetcher\Autowire
{
    return new Fetcher\Autowire($class_name);
}

function get(string $id): Fetcher\Get
{
    return new Fetcher\Get($id);
}
