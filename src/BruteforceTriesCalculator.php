<?php
declare(strict_types=1);

namespace Latgardi\PasswordTools;

require_once dirname(path: __DIR__) . '/vendor/autoload.php';

use Latgardi\PasswordTools\Type\Abstract\Factory;
use Latgardi\PasswordTools\Type\ValueObject\BruteforceTries;
use Latgardi\PasswordTools\Type\ValueObject\Entropy;
use Override;

/**
 * Calculates the average number of brute-force attempts required to guess a password.
 *
 * This class provides methods to calculate the average number of attempts needed to
 * brute-force a password based on its entropy. It extends the `Factory` class to
 * utilize its static factory method.
 */
class BruteforceTriesCalculator extends Factory
{
    /**
     * @param Entropy $entropy The entropy of the password.
     * @return BruteforceTries The average number of brute-force attempts.
     */
    public static function calculateTries(Entropy $entropy): BruteforceTries
    {
        $calculator = self::make();
        return $calculator->calculate(entropy: $entropy);
    }

    /**
     * This method calculates the average number of attempts using the formula:
     * `2^(entropy.bits - 1)`.
     *
     * @param Entropy $entropy The entropy of the password.
     * @return BruteforceTries The average number of brute-force attempts.
     */
    public function calculate(Entropy $entropy): BruteforceTries
    {
        return new BruteforceTries(
            avgTries: (float) (2 ** ($entropy->bits - 1))
        );
    }
}