<?php
declare(strict_types=1);

namespace Latgardi\PasswordTools\Tests;

use Latgardi\PasswordTools\EntropyCalculator;
use Latgardi\PasswordTools\Type\ValueObject\Entropy;
use Latgardi\PasswordTools\Type\ValueObject\EntropyThresholds;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class EntropyCalculatorTest extends TestCase
{
    #[DataProvider('passwordDataProvider')]
    public function testCalculateEntropy(string $password, float $expectedBits): void
    {
        $calculator = new EntropyCalculator();
        $entropy = $calculator->calculate(password: $password);

        $this->assertGreaterThanOrEqual(minimum: $expectedBits, actual: $entropy->bits);
    }

    public static function passwordDataProvider(): array
    {
        return [
            ['password123', 50.0],
            ['strongPassword!', 80.0],
        ];
    }

    #[DataProvider('strengthLevelDataProvider')]
    public function testStrengthLevel(string $password, string $expectedLevel): void
    {
        $calculator = new EntropyCalculator(
            thresholds: new EntropyThresholds(weak: 30, medium: 60, normal: 75, strong: 90)
        );
        $entropy = $calculator->calculate(password: $password);

        $this->assertSame(expected: $expectedLevel, actual: $entropy->strengthLevel->name);
    }

    public static function strengthLevelDataProvider(): array
    {
        return [
            ['weak', 'Weak'],
            ['strongPassword!', 'Strong'],
        ];
    }
}