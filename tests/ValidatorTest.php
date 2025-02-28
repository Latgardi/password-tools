<?php
declare(strict_types=1);

namespace Latgardi\PasswordTools\Tests;

use Latgardi\PasswordTools\Validator;
use Latgardi\PasswordTools\Exception\ValidationException;
use Latgardi\PasswordTools\Type\ValueObject\PasswordRequirements;
use Latgardi\PasswordTools\Enum\StrengthLevel;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    #[DataProvider('validPasswordDataProvider')]
    public function testValidatePassword(string $password): void
    {
        $validator = new Validator();
        $this->assertTrue(condition: $validator->validate(password: $password));
    }

    #[DataProvider('validPasswordDataProvider')]
    public function testStaticValidatePassword(string $password): void
    {
        $this->assertTrue(condition: Validator::validatePassword(password: $password));
    }

    public static function validPasswordDataProvider(): array
    {
        return [
            ['StrongPassword123!'],
            ['пароль123'],
        ];
    }

    #[DataProvider('invalidPasswordDataProvider')]
    public function testValidatePasswordThrowsException(string $password): void
    {
        $this->expectException(exception: ValidationException::class);

        $validator = new Validator();
        $validator->validate(password: $password);
    }

    public static function invalidPasswordDataProvider(): array
    {
        return [
            ['weak'],
            ['nouppercase123'],
        ];
    }

    #[DataProvider('nonAsciiPasswordDataProvider')]
    public function testRequireNonAsciiCharacters(string $password, bool $expected): void
    {
        $requirements = new PasswordRequirements(requireNonASCIICharacters: true);
        $validator = new Validator(requirements: $requirements);

        $this->assertSame(expected: $expected, actual: $validator->validate(password: $password, throws: false));
    }

    public static function nonAsciiPasswordDataProvider(): array
    {
        return [
            ['пароль123', true],
            ['password123', false],
        ];
    }

    #[DataProvider('minStrengthDataProvider')]
    public function testMinStrength(string $password, bool $expected): void
    {
        $requirements = new PasswordRequirements(minStrength: StrengthLevel::Strong);
        $validator = new Validator(requirements: $requirements);

        $this->assertSame(expected: $expected, actual: $validator->validate($password, false));
    }

    public static function minStrengthDataProvider(): array
    {
        return [
            ['VeryStrongPassword123!', true],
            ['weak', false],
        ];
    }
}