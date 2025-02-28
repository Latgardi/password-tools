<?php
declare(strict_types=1);

namespace Latgardi\PasswordTools\Enum;

/**
 * Represents the strength levels of a password.
 *
 * This enum defines the possible strength levels for a password, ranging from `Undefined` to `VeryStrong`.
 * Each level is associated with an integer value for easy comparison.
 */
enum StrengthLevel: int
{
    /**
     * The password strength is undefined or not calculated.
     */
    case Undefined = 0;

    /**
     * The password is weak and easily guessable.
     */
    case Weak = 1;

    /**
     * The password is medium strength, offering basic security.
     */
    case Medium = 2;

    /**
     * The password has normal strength, suitable for most use cases.
     */
    case Normal = 3;

    /**
     * The password is strong, providing a high level of security.
     */
    case Strong = 4;

    /**
     * The password is very strong, offering the highest level of security.
     */
    case VeryStrong = 5;

    /**
     * @param StrengthLevel $level The strength level to compare against.
     * @return boolean Returns `true` if the current level is greater than the specified level, `false` otherwise.
     */
    public function isMoreThan(self $level): bool
    {
        return $this->value > $level->value;
    }
}