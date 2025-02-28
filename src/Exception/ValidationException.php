<?php
declare(strict_types=1);

namespace Latgardi\PasswordTools\Exception;

use Exception;

/**
 * Represents an exception that occurs during password validation.
 *
 * This exception is thrown when a password fails to meet specific validation requirements.
 * It includes a message describing the error and the requirement that was not met.
 */
class ValidationException extends Exception
{
    /**
     * Constructs a new ValidationException.
     *
     * @param string $message The error message describing the validation failure.
     * @param string $requirement The specific requirement that was not met.
     */
    public function __construct(string $message, private readonly string $requirement)
    {
        parent::__construct(message: $message);
    }

    /**
     * Retrieves the requirement that was not met.
     *
     * @return string The requirement that caused the validation to fail.
     */
    public function getRequirement(): string
    {
        return $this->requirement;
    }
}