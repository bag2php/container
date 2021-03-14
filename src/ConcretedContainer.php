<?php

declare(strict_types=1);

namespace Bag2\Container;

use function array_key_exists;
use Bag2\Container\Exception\NotFoundException;
use Psr\Container\ContainerInterface;

final class ConcretedContainer implements ContainerInterface
{
    /** @var array<string, mixed> */
    private $data = [];

    /**
     * @param array<string, mixed> $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function get($id)
    {
        if (array_key_exists($id, $this->data)) {
            return $this->data[$id];
        }

        throw new NotFoundException("Entry '{$id}' not found.");
    }

    /**
     * @param string $id
     * @return bool
     */
    public function has($id): bool
    {
        return array_key_exists($id, $this->data);
    }
}
