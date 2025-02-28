<?php
declare(strict_types=1);

namespace Latgardi\PasswordTools\Type\ValueObject;

/**
 * Represents the average number of attempts required to brute-force a password.
 *
 * This value object stores the calculated average number of attempts needed to guess a password
 * using a brute-force attack. It is used to quantify the strength of a password.
 */
readonly class BruteforceTries
{
    /**
     * Constructs a new `BruteforceTries` instance.
     *
     * @param float $avgTries The average number of attempts required to brute-force the password.
     */
    public function __construct(public float $avgTries) {}
}