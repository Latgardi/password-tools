<?php
declare(strict_types=1);

namespace Latgardi\PasswordTools;

require_once dirname(path: __DIR__) . '/vendor/autoload.php';

use Latgardi\PasswordTools\Type\Abstract\Factory;
use Latgardi\PasswordTools\Type\ValueObject\Entropy;
use Latgardi\PasswordTools\Type\ValueObject\Meter;

/**
 * Visualizes the entropy of a password as a meter.
 *
 * This class provides methods to generate a visual representation of the password's entropy
 * in the form of a meter, such as `████░░░░░░`. The meter's length and characters can be customized.
 */
class Visualizer extends Factory
{
    /**
     * The maximum possible entropy value used for scaling the meter.
     */
    public const float MAX_ENTROPY = 128;

    /**
     * The default width (length) of the meter.
     */
    public const int DEFAULT_WIDTH = 10;

    /**
     * The default character used to represent filled parts of the meter.
     */
    public const string DEFAULT_FILLED_CHAR = '█';

    /**
     * The default character used to represent empty parts of the meter.
     */
    public const string DEFAULT_EMPTY_CHAR = '░';

    /**
     * @param Entropy $entropy The entropy of the password.
     * @param integer $width The width (length) of the meter. Defaults to `DEFAULT_WIDTH`.
     * @param string $filledChar The character used to represent filled parts of the meter.
     *                           Defaults to `DEFAULT_FILLED_CHAR`.
     * @param string $emptyChar The character used to represent empty parts of the meter.
     *                          Defaults to `DEFAULT_EMPTY_CHAR`.
     * @return Meter The generated meter as a `Meter` object.
     */
    public static function getEntropyMeter(
        Entropy $entropy,
        int $width = self::DEFAULT_WIDTH,
        string $filledChar = self::DEFAULT_FILLED_CHAR,
        string $emptyChar = self::DEFAULT_EMPTY_CHAR
    ): Meter {
        $visualizer = self::make();
        return $visualizer->getMeter(
            entropy: $entropy,
            width: $width,
            filledChar: $filledChar,
            emptyChar: $emptyChar
        );
    }

    /**
     * Generates a visual meter for the given entropy.
     *
     * This method calculates the filled portion of the meter based on the ratio of the password's
     * entropy to the maximum possible entropy (`MAX_ENTROPY`). The meter is represented as a string
     * of filled and empty characters.
     *
     * @param Entropy $entropy The entropy of the password.
     * @param integer $width The width (length) of the meter. Defaults to `DEFAULT_WIDTH`.
     * @param string $filledChar The character used to represent filled parts of the meter.
     *                           Defaults to `DEFAULT_FILLED_CHAR`.
     * @param string $emptyChar The character used to represent empty parts of the meter.
     *                          Defaults to `DEFAULT_EMPTY_CHAR`.
     * @return Meter The generated meter as a `Meter` object.
     */
    public function getMeter(
        Entropy $entropy,
        int $width = self::DEFAULT_WIDTH,
        string $filledChar = self::DEFAULT_FILLED_CHAR,
        string $emptyChar = self::DEFAULT_EMPTY_CHAR
    ): Meter {
        $filled = (int) round(num: ($entropy->bits / self::MAX_ENTROPY) * $width);
        $filled = min($filled, $width);

        return new Meter(
            value: str_repeat(string: $filledChar, times: $filled)
            . str_repeat(string: $emptyChar, times: $width - $filled),
        );
    }
}