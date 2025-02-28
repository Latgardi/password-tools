<?php
declare(strict_types=1);

namespace Latgardi\PasswordTools\Type\ValueObject;

use Latgardi\PasswordTools\Enum\StrengthLevel;

/**
 * Represents the entropy of a password.
 *
 * This value object stores the calculated entropy of a password in bits and its corresponding
 * strength level. Entropy is a measure of password complexity, and the strength level provides
 * a human-readable representation of the password's security.
 */
readonly class Entropy
{
    /**
     * Constructs a new `Entropy` instance.
     *
     * @param float $bits The entropy value of the password in bits.
     * @param string|null $password Given password. Default to null.
     * @param StrengthLevel $strengthLevel The strength level of the password. Defaults to `StrengthLevel::Undefined`.
     */
    public function __construct(
        public float $bits,
        public ?string $password = null,
        public StrengthLevel $strengthLevel = StrengthLevel::Undefined,
    ) {}
}