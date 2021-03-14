<?php

declare(strict_types=1);

namespace Bag2\Container\Fetcher;

use Bag2\Container\Container;

final class Get implements FetcherInterface
{
    /** @var string $id */
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function fetch(Container $container)
    {
        return $container->get($this->id);
    }
}
