<?php
declare(strict_types=1);

namespace Latgardi\PasswordTools\Tests\Type\ValueObject;

use Latgardi\PasswordTools\Enum\StrengthLevel;
use Latgardi\PasswordTools\Type\ValueObject\Entropy;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class EntropyTest extends TestCase
{
    #[DataProvider('entropyDataProvider')]
    public function testConstructor(float $bits, StrengthLevel $strengthLevel): void
    {
        $entropy = new Entropy(bits: $bits, strengthLevel: $strengthLevel);

        $this->assertSame(expected: $bits, actual: $entropy->bits);
        $this->assertSame(expected: $strengthLevel, actual: $entropy->strengthLevel);
    }

    public static function entropyDataProvider(): array
    {
        return [
            [50.0, StrengthLevel::Normal],
            [64.0, StrengthLevel::Strong],
            [128.0, StrengthLevel::VeryStrong],
        ];
    }
}