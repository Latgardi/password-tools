<?php
declare(strict_types=1);

namespace Latgardi\PasswordTools\Tests\Type\ValueObject;

use Latgardi\PasswordTools\Type\ValueObject\EntropyThresholds;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class EntropyThresholdsTest extends TestCase
{
    #[DataProvider('thresholdsDataProvider')]
    public function testConstructor(int $weak, int $medium, int $normal, int $strong): void
    {
        $thresholds = new EntropyThresholds(weak: $weak, medium: $medium, normal: $normal, strong: $strong);

        $this->assertSame(expected: $weak, actual: $thresholds->weak);
        $this->assertSame(expected: $strong, actual: $thresholds->strong);
    }

    public static function thresholdsDataProvider(): array
    {
        return [
            [30, 60, 75, 90],
            [20, 50, 70, 100],
        ];
    }

    #[DataProvider('defaultThresholdsDataProvider')]
    public function testDefaultValues(int $weak, int $medium, int $normal, int $strong): void
    {
        $thresholds = new EntropyThresholds();

        $this->assertSame(expected: $weak, actual: $thresholds->weak);
        $this->assertSame(expected: $strong, actual: $thresholds->strong);
    }

    public static function defaultThresholdsDataProvider(): array
    {
        return [
            [
                EntropyThresholds::DEFAULT_WEAK,
                EntropyThresholds::DEFAULT_MEDIUM,
                EntropyThresholds::DEFAULT_NORMAL,
                EntropyThresholds::DEFAULT_STRONG
            ],
        ];
    }
}