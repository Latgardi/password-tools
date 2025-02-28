<?php
declare(strict_types=1);

namespace Latgardi\PasswordTools\Tests\Exception;

use Latgardi\PasswordTools\Exception\ValidationException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ValidationExceptionTest extends TestCase
{
    #[DataProvider('exceptionDataProvider')]
    public function testException(string $message, string $requirement): void
    {
        $exception = new ValidationException(message: $message, requirement: $requirement);

        $this->assertSame(expected: $message, actual: $exception->getMessage());
        $this->assertSame(expected: $requirement, actual: $exception->getRequirement());
    }

    public static function exceptionDataProvider(): array
    {
        return [
            ['Test message', 'requirement'],
            ['Another message', 'anotherRequirement'],
        ];
    }
}