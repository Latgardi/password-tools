<?php
declare(strict_types=1);

namespace Latgardi\PasswordTools;

require_once dirname(path: __DIR__) . '/vendor/autoload.php';

use Latgardi\PasswordTools\Enum\StrengthLevel;
use Latgardi\PasswordTools\Type\Abstract\Factory;
use Latgardi\PasswordTools\Type\ValueObject\Entropy;
use Latgardi\PasswordTools\Type\ValueObject\EntropyThresholds;
use Override;

/**
 * Calculates the entropy of a password and determines its strength level.
 *
 * This class provides methods to calculate the entropy of a password based on its
 * character composition and length. It also determines the password's strength level
 * using predefined entropy thresholds.
 *
 * The entropy calculation is based on the formula:
 *   entropy = length * log2(points)
 * where:
 *   - `length` is the length of the password.
 *   - `points` is the total number of possible characters in the password's character set.
 *
 * The `points` are calculated based on the types of characters present in the password:
 *   - Lowercase letters (a-z): 26 points.
 *   - Uppercase letters (A-Z): 26 points.
 *   - Numbers (0-9): 10 points.
 *   - Special and Unicode characters: 43 points.
 *
 * This formula is derived from information theory and measures the uncertainty or randomness
 * of the password. Higher entropy values indicate stronger passwords.
 */
class EntropyCalculator extends Factory
{
    /**
     * Points assigned for lowercase and uppercase letters in the password.
     */
    public const int ALPHA_POINTS = 26;

    /**
     * Points assigned for numeric characters in the password.
     */
    public const int NUMBER_POINTS = 10;

    /**
     * Points assigned for special and Unicode characters in the password.
     */
    public const int SYMBOL_AND_UNICODE_POINTS = 43;

    /**
     * Total points calculated based on the password's character composition.
     * @var positive-int $points
     */
    private int $points = 0;

    /**
     * Constructs a new `EntropyCalculator` instance.
     * @param EntropyThresholds $thresholds The entropy thresholds used to determine password strength levels.
     *                                      Defaults to a new instance of `EntropyThresholds`.
     */
    public function __construct(
        private readonly EntropyThresholds $thresholds = new EntropyThresholds()
    ) {}

    /**
     * @param string $password The password to calculate entropy for.
     * @return Entropy The calculated entropy and strength level of the password.
     */
    public static function calculateEntropy(string $password): Entropy
    {
        $calculator = self::make();
        return $calculator->calculate(password: $password);
    }

    /**
     * Performs the entropy calculation for a password.
     *
     * @param string $password The password to calculate entropy for.
     * @return Entropy The calculated entropy and strength level of the password.
     */
    public function calculate(string $password): Entropy
    {
        $this->points = 0;
        $this->addAlphaPoints(password: $password);
        $this->addNumericPoints(password: $password);
        $this->addSymbolAndUnicodePoints(password: $password);

        $entropyValue = round(num: $this->getResultEntropyValue(password: $password), precision: 2);

        return new Entropy(
            bits: $entropyValue,
            password: $password,
            strengthLevel: $this->getStrengthLevel(entropyValue: $entropyValue)
        );
    }

    /**
     * Calculates the entropy value based on the password's length and character composition.
     *
     * The formula used is:
     *   entropy = length * log2(points)
     * where:
     *   - `length` is the length of the password.
     *   - `points` is the total number of possible characters in the password's character set.
     *
     * @param string $password The password to calculate entropy for.
     * @return float The calculated entropy value in bits.
     */
    private function getResultEntropyValue(string $password): float
    {
        $length = strlen($password);
        return $length * log(num: (float) $this->points, base: 2);
    }

    private function addNumericPoints(string $password): void
    {
        if (preg_match(pattern: '/[0-9]/', subject: $password)) {
            $this->points += self::NUMBER_POINTS;
        }
    }

    private function addAlphaPoints(string $password): void
    {
        if (preg_match(pattern: '/[a-z]/', subject: $password)) {
            $this->points += self::ALPHA_POINTS;
        }
        if (preg_match(pattern: '/[A-Z]/', subject: $password)) {
            $this->points += self::ALPHA_POINTS;
        }
    }

    /**
     * Adds points for special and Unicode characters in the password.
     *
     * If the password contains at least one special or Unicode character (after removing
     * all letters a-z and A-Z), the `SYMBOL_AND_UNICODE_POINTS` value is added to the total points.
     *
     * @param string $password The password to analyze.
     */
    private function addSymbolAndUnicodePoints(string $password): void
    {
        $password = preg_replace(pattern: '/[a-zA-Z]/', replacement: '', subject: $password);
        if (preg_match(pattern: '/\p{L}/', subject: $password)) {
            $this->points += self::SYMBOL_AND_UNICODE_POINTS;
        }
    }

    /**
     * Determines the strength level of the password based on its entropy value.
     *
     * The strength level is determined by comparing the entropy value against predefined thresholds:
     *   - Weak: entropy < weak threshold.
     *   - Medium: entropy < medium threshold.
     *   - Normal: entropy < normal threshold.
     *   - Strong: entropy < strong threshold.
     *   - VeryStrong: entropy >= strong threshold.
     *
     * @param float $entropyValue The entropy value of the password.
     * @return StrengthLevel The strength level of the password.
     */
    private function getStrengthLevel(float $entropyValue): StrengthLevel
    {
        return match (true) {
            $entropyValue < $this->thresholds->weak => StrengthLevel::Weak,
            $entropyValue < $this->thresholds->medium => StrengthLevel::Medium,
            $entropyValue < $this->thresholds->normal => StrengthLevel::Normal,
            $entropyValue < $this->thresholds->strong => StrengthLevel::Strong,
            default => StrengthLevel::VeryStrong
        };
    }
}