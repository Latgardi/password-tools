<?php
declare(strict_types=1);

namespace Latgardi\PasswordTools\Tests;

use Latgardi\PasswordTools\Visualizer;
use Latgardi\PasswordTools\Type\ValueObject\Entropy;
use Latgardi\PasswordTools\Type\ValueObject\Meter;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class VisualizerTest extends TestCase
{
    #[DataProvider('entropyDataProvider')]
    public function testGetEntropyMeter(float $bits, string $expectedOutput): void
    {
        $entropy = new Entropy(bits: $bits);
        $meter = Visualizer::getEntropyMeter(entropy: $entropy);

        $this->assertInstanceOf(expected: Meter::class, actual: $meter);
        $this->assertSame(expected: $expectedOutput, actual: $meter->value);
    }

    public static function entropyDataProvider(): array
    {
        return [
            [64.0, '█████░░░░░'],
            [128.0, '██████████'],
        ];
    }
}