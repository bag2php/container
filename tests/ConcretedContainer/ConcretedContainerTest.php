<?php

declare(strict_types=1);

namespace Bag2\Container\PoorContainer;

use Bag2\Container\ConcretedContainer;
use Bag2\Container\TestCase;

final class ConcretedContainerTest extends TestCase
{
    /** @var ConcretedContainer */
    private $subject;

    public function setUp(): void
    {
        $this->subject = new ConcretedContainer(['key' => 'value']);
    }

    public function test_get(): void
    {
        $actual = $this->subject->get('key');

        $this->assertSame('value', $actual);
    }

    /**
     * @dataProvider keysProvider
     */
    public function test_has(string $key, bool $expected): void
    {
        $actual = $this->subject->has($key);

        $this->assertSame($expected, $actual);
    }

    /**
     * @return array<string, array{0:string, 1:bool}>
     */
    public function keysProvider(): array
    {
        return [
            'exists key' => ['key', true],
            'not-exists key' => ['', false],
        ];
    }
}
