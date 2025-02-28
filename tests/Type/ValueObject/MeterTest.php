<?php
declare(strict_types=1);

namespace Latgardi\PasswordTools\Tests\Type\ValueObject;

use Latgardi\PasswordTools\Type\ValueObject\Meter;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class MeterTest extends TestCase
{
    #[DataProvider('meterDataProvider')]
    public function testConstructorAndRender(string $value, string $expectedOutput): void
    {
        $meter = new Meter(value: $value);

        $this->assertSame(expected: $value, actual: $meter->value);
        $this->expectOutputString(expectedString: $expectedOutput);
        $meter->render();
    }

    public static function meterDataProvider(): array
    {
        return [
            ['████░░░░░░', '████░░░░░░'],
            ['██████████', '██████████'],
        ];
    }
}