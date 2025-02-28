<?php
declare(strict_types=1);

namespace Latgardi\PasswordTools\Tests\Type\Abstract;

use Latgardi\PasswordTools\Type\Abstract\Factory;
use Override;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{
    public function testMakeReturnsInstanceOfChildClass(): void
    {
        $class = new class() extends Factory {
            public function __construct(
                public string $name = 'Test class'
            )
            {}
        };
        $instance = $class::make();

        $this->assertInstanceOf(expected: $class::class, actual: $instance);
    }
}