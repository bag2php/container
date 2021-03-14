<?php

declare(strict_types=1);

namespace Bag2\Container\Fetcher;

use Bag2\Container\Container;

interface FetcherInterface
{
    /**
     * @return mixed
     */
    public function fetch(Container $container);
}
