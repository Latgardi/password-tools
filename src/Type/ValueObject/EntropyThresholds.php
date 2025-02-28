<?php
declare(strict_types=1);

namespace Latgardi\PasswordTools\Type\ValueObject;

/**
 * Represents the entropy thresholds for different password strength levels.
 *
 * This value object stores the minimum entropy values required for a password to be classified
 * as Weak, Medium, Normal, or Strong. These thresholds are used to determine the strength level
 * of a password based on its calculated entropy.
 */
readonly class EntropyThresholds
{
    /**
     * Default entropy threshold for a Weak password.
     */
    public const int DEFAULT_WEAK = 30;

    /**
     * Default entropy threshold for a Medium password.
     */
    public const int DEFAULT_MEDIUM = 60;

    /**
     * Default entropy threshold for a Normal password.
     */
    public const int DEFAULT_NORMAL = 75;

    /**
     * Default entropy threshold for a Strong password.
     */
    public const int DEFAULT_STRONG = 90;

    /**
     * Constructs a new `EntropyThresholds` instance.
     *
     * @param positive-int $weak The entropy threshold for a Weak password. Defaults to `DEFAULT_WEAK`.
     * @param positive-int $medium The entropy threshold for a Medium password. Defaults to `DEFAULT_MEDIUM`.
     * @param positive-int $normal The entropy threshold for a Normal password. Defaults to `DEFAULT_NORMAL`.
     * @param positive-int $strong The entropy threshold for a Strong password. Defaults to `DEFAULT_STRONG`.
     */
    public function __construct(
        public int $weak  = self::DEFAULT_WEAK,
        public int $medium  = self::DEFAULT_MEDIUM,
        public int $normal = self::DEFAULT_NORMAL,
        public int $strong = self::DEFAULT_STRONG,
    ) {}
}