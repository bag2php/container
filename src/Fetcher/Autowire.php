<?php

declare(strict_types=1);

namespace Bag2\Container\Fetcher;

use Bag2\Container\Container;
use ReflectionClass;

final class Autowire implements FetcherInterface
{
    /** @var class-string $class_name */
    private string $class_name;

    /**
     * @param class-string $class_name
     */
    public function __construct(string $class_name)
    {
        $this->class_name = $class_name;
    }

    /**
     * @return object
     */
    public function fetch(Container $container)
    {
        $arguments = [];

        foreach ($this->getConstructorParameters() as $parameter) {
            $ref_type = $parameter->getType();
            if ($ref_type instanceof \ReflectionUnionType) {
                throw new \InvalidArgumentException(
                    "Fail to autowire {$this->class_name}, because do not support union type yet."
                );
            }
            if ($ref_type === null || $ref_type->isBuiltin()) {
                $name = $parameter->getName();
                if (!$container->has($name)) {
                    throw new \InvalidArgumentException(
                        "Fail to autowire {$this->class_name}, because not found argument '{$name}' in the container."
                    );
                }

                $arguments[] = $container->get($name);
            } elseif ($ref_type instanceof \ReflectionNamedType) {
                $name = $ref_type->getName();
                $arg = $container->has($name) ? $container->get($name) : null;

                if ($arg === null && !$ref_type->allowsNull()) {
                    throw new \InvalidArgumentException(
                        "Fail to autowire {$this->class_name}, because not found argument '{$name}' and not nullable."
                    );
                }

                $arguments[] = $arg;
            }
        }

        return new $this->class_name(...$arguments);
    }

    /**
     * @return array<int,\ReflectionParameter>
     */
    public function getConstructorParameters(): array
    {
        $params = [];
        $ref = new ReflectionClass($this->class_name);
        $ref_constructor = $ref->getConstructor();

        if ($ref_constructor === null) {
            throw new \InvalidArgumentException(
                "Fail to autowire, because {$this->class_name} do not has __construct() method."
            );
        }

        return $ref_constructor->getParameters();
    }
}
