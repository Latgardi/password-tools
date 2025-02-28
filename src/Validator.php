<?php
declare(strict_types=1);

namespace Latgardi\PasswordTools;

require_once dirname(path: __DIR__) . '/vendor/autoload.php';

use Latgardi\PasswordTools\Exception\ValidationException;
use Latgardi\PasswordTools\Type\Abstract\Factory;
use Latgardi\PasswordTools\Type\ValueObject\Entropy;
use Latgardi\PasswordTools\Type\ValueObject\PasswordRequirements;
use Override;

/**
 * Validates a password against a set of requirements.
 *
 * This class checks if a password meets the specified requirements, such as minimum length,
 * presence of uppercase letters, numbers, special characters, non-ASCII characters, and
 * minimum strength level. If the password fails to meet any requirement, a `ValidationException`
 * can be thrown, or the method can return `false`.
 */
class Validator extends Factory
{
    /**
     * Constructs a new `Validator` instance
     * @param PasswordRequirements|null $requirements The password requirements to validate against.
     * Defaults to a new instance of `PasswordRequirements`.
     */
    public function __construct(
        public ?PasswordRequirements $requirements = new PasswordRequirements()
    ) {
        if ($this->requirements === null) {
            $this->requirements = new PasswordRequirements();
        }
    }

    /**
     * @param string $password The password to validate.
     * @param boolean $throws Whether to throw an exception if validation fails. Defaults to `true`.
     * @param Entropy|null $entropy Pre-calculated entropy of the password. If not provided,
     *                              it will be calculated internally.
     * @param PasswordRequirements|null $requirements Password requirements for target password or null for using default.
     * @return boolean Returns `true` if the password meets all requirements, `false` otherwise.
     * @throws ValidationException If the password fails to meet any requirement and `$throws` is `true`.
    */

    public static function validatePassword(
        string $password,
        bool $throws = true,
        ?Entropy $entropy = null,
        ?PasswordRequirements $requirements = null
    ): bool
    {
        $validator = self::make($requirements);
        return $validator->validate(
            password: $password,
            throws: $throws,
            entropy: $entropy
        );
    }

    /**
     * Performs the password validation against the requirements.
     *
     * This method checks if the password meets all the specified requirements. If the password
     * fails to meet any requirement and `$throws` is `true`, a `ValidationException` is thrown.
     * Otherwise, the method returns `false`.
     *
     * @param string $password The password to validate.
     * @param boolean $throws Whether to throw an exception if validation fails. Defaults to `true`.
     * @param Entropy|null $entropy Pre-calculated entropy of the password. If not provided,
     *                              it will be calculated internally.
     * @return boolean Returns `true` if the password meets all requirements, `false` otherwise.
     * @throws ValidationException If the password fails to meet any requirement and `$throws` is `true`.
     */
    public function validate(string $password, bool $throws = true, ?Entropy $entropy = null): bool
    {
        foreach ($this->requirements->getRequirements() as $requirement => $value) {
            $passed = match ($requirement) {
                'minLength' => strlen(string: $password) >= $value,
                'requireUpperCase' => $value === false ?: preg_match(pattern: "/[A-Z]/", subject: $password),
                'requireNumbers' => $value === false ?: preg_match(pattern: "/[0-9]/", subject: $password),
                'requireSpecialCharacters' => $value === false
                    ?: preg_match(pattern: '/[^\p{L}\p{N}]/u', subject: $password),
                'requireNonASCIICharacters' => $value === false
                    ?: preg_match(pattern: '/[^\x00-\x7F]/u', subject: $password),
                'minStrength' => ($entropy ?? EntropyCalculator::calculateEntropy(password: $password))
                    ->strengthLevel
                    ->isMoreThan(level: $value),
            };

            if ($passed === false) {
                if ($throws === true) {
                    throw new ValidationException(
                        message: 'Password doesn\'t meet requirement.',
                        requirement: $requirement
                    );
                }
                return false;
            }
        }

        return true;
    }
}