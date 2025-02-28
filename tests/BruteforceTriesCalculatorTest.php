<?php
declare(strict_types=1);

namespace Latgardi\PasswordTools\Tests;

use Latgardi\PasswordTools\BruteforceTriesCalculator;
use Latgardi\PasswordTools\Type\ValueObject\Entropy;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class BruteforceTriesCalculatorTest extends TestCase
{
    #[DataProvider('entropyDataProvider')]
    public function testCalculateTries(float $bits, float $expectedTries): void
    {
        $entropy = new Entropy(bits: $bits);
        $tries = BruteforceTriesCalculator::calculateTries(entropy: $entropy);

        $this->assertSame(expected: $expectedTries, actual: $tries->avgTries);
    }

    public static function entropyDataProvider(): array
    {
        return [
            [50.0, 2 ** 49],
            [64.0, 2 ** 63],
        ];
    }
}