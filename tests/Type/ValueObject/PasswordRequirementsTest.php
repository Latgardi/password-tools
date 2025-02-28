<?php
declare(strict_types=1);

namespace Latgardi\PasswordTools\Tests\Type\ValueObject;

use Latgardi\PasswordTools\Enum\StrengthLevel;
use Latgardi\PasswordTools\Type\ValueObject\PasswordRequirements;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PasswordRequirementsTest extends TestCase
{
    #[DataProvider('requirementsDataProvider')]
    public function testConstructor(
        int $minLength,
        bool $requireUpperCase,
        bool $requireNumbers,
        bool $requireSpecialCharacters,
        bool $requireNonASCIICharacters,
        StrengthLevel $minStrength
    ): void {
        $requirements = new PasswordRequirements(
            minLength: $minLength,
            requireUpperCase: $requireUpperCase,
            requireNumbers: $requireNumbers,
            requireSpecialCharacters: $requireSpecialCharacters,
            requireNonASCIICharacters: $requireNonASCIICharacters,
            minStrength: $minStrength
        );

        $this->assertSame(expected: $minLength, actual: $requirements->minLength);
        $this->assertSame(expected: $requireUpperCase, actual: $requirements->requireUpperCase);
        $this->assertSame(expected: $minStrength, actual: $requirements->minStrength);
    }

    public static function requirementsDataProvider(): array
    {
        return [
            [10, false, true, true, true, StrengthLevel::Strong],
            [8, true, true, false, false, StrengthLevel::Normal],
        ];
    }

    #[DataProvider('defaultRequirementsDataProvider')]
    public function testGetRequirements(array $expected): void
    {
        $requirements = new PasswordRequirements();
        $this->assertSame(expected: $expected, actual: $requirements->getRequirements());
    }

    public static function defaultRequirementsDataProvider(): array
    {
        return [
            [
                [
                    'minLength' => 8,
                    'requireUpperCase' => true,
                    'requireNumbers' => true,
                    'requireSpecialCharacters' => false,
                    'requireNonASCIICharacters' => false,
                    'minStrength' => StrengthLevel::Normal,
                ],
            ],
        ];
    }
}