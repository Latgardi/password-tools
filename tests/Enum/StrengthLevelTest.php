<?php
declare(strict_types=1);

namespace Latgardi\PasswordTools\Tests\Enum;

use Latgardi\PasswordTools\Enum\StrengthLevel;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class StrengthLevelTest extends TestCase
{
    #[DataProvider('strengthLevelProvider')]
    public function testIsLessThan(StrengthLevel $level1, StrengthLevel $level2, bool $expected): void
    {
        $this->assertSame(expected: $expected, actual: $level1->isMoreThan($level2));
    }

    public static function strengthLevelProvider(): array
    {
        return [
            [StrengthLevel::Medium, StrengthLevel::Weak, true],
            [StrengthLevel::Normal, StrengthLevel::Strong, false],
            [StrengthLevel::Weak, StrengthLevel::VeryStrong, false],
        ];
    }

    #[DataProvider('strengthLevelValueProvider')]
    public function testValues(StrengthLevel $level, int $expectedValue): void
    {
        $this->assertSame(expected: $expectedValue, actual: $level->value);
    }

    public static function strengthLevelValueProvider(): array
    {
        return [
            [StrengthLevel::Undefined, 0],
            [StrengthLevel::Weak, 1],
            [StrengthLevel::VeryStrong, 5],
        ];
    }
}