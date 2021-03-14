<?php

declare(strict_types=1);

namespace Bag2\Container;

function get(string $id): Fetcher\Get
{
    return new Fetcher\Get($id);
}
