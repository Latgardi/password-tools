<?php
declare(strict_types=1);

namespace Latgardi\PasswordTools\Type\ValueObject;

use Latgardi\PasswordTools\Enum\StrengthLevel;

/**
 * Represents the requirements for a password.
 *
 * This value object stores the rules and constraints that a password must meet,
 * such as minimum length, character requirements, and minimum strength level.
 */
readonly class PasswordRequirements
{
    /**
     * Default minimum length for a password.
     */
    public const int DEFAULT_LENGTH = 8;

    /**
     * Constructs a new `PasswordRequirements` instance.
     *
     * @param int $minLength The minimum length required for the password. Defaults to `DEFAULT_LENGTH`.
     * @param bool $requireUpperCase Whether the password must contain uppercase letters. Defaults to `true`.
     * @param bool $requireNumbers Whether the password must contain numbers. Defaults to `true`.
     * @param bool $requireSpecialCharacters Whether the password must contain special characters. Defaults to `false`.
     * @param bool $requireNonASCIICharacters Whether the password must contain non-ASCII characters. Defaults to `false`.
     * @param StrengthLevel $minStrength The minimum strength level required for the password. Defaults to `StrengthLevel::Normal`.
     */
    public function __construct(
        public int $minLength = self::DEFAULT_LENGTH,
        public bool $requireUpperCase = true,
        public bool $requireNumbers = true,
        public bool $requireSpecialCharacters = false,
        public bool $requireNonASCIICharacters = false,
        public StrengthLevel $minStrength = StrengthLevel::Normal,
    ) {}

    /**
     * Retrieves the password requirements as an associative array.
     *
     * @return array<string, int|bool|StrengthLevel> An array containing all the password requirements,
     * with keys representing the requirement names and values representing their respective values.
     */
    public function getRequirements(): array
    {
        return [
            'minLength' => $this->minLength,
            'requireUpperCase' => $this->requireUpperCase,
            'requireNumbers' => $this->requireNumbers,
            'requireSpecialCharacters' => $this->requireSpecialCharacters,
            'requireNonASCIICharacters' => $this->requireNonASCIICharacters,
            'minStrength' => $this->minStrength,
        ];
    }
}