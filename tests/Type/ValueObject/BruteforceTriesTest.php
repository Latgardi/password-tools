<?php
declare(strict_types=1);

namespace Latgardi\PasswordTools\Tests\Type\ValueObject;

use Latgardi\PasswordTools\Type\ValueObject\BruteforceTries;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class BruteforceTriesTest extends TestCase
{
    #[DataProvider('triesDataProvider')]
    public function testConstructor(float $avgTries): void
    {
        $tries = new BruteforceTries(avgTries: $avgTries);

        $this->assertSame(expected: $avgTries, actual: $tries->avgTries);
    }

    public static function triesDataProvider(): array
    {
        return [
            [100.5],
            [200.0],
            [0.0],
        ];
    }
}