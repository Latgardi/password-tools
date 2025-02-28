<?php
declare(strict_types=1);

namespace Latgardi\PasswordTools\Type\ValueObject;

/**
 * Represents a visual meter for displaying password strength or other metrics.
 *
 * This value object stores a string value that can be used to visually represent
 * a metric, such as password strength. It provides a method to render the value.
 */
readonly class Meter
{
    /**
     * Constructs a new `Meter` instance.
     *
     * @param string $value The string value to be displayed by the meter.
     */
    public function __construct(public string $value) {}

    /**
     * Renders the meter's value by outputting it directly.
     *
     * This method outputs the stored value to the standard output (e.g., the console).
     */
    public function render(): void
    {
        echo $this->value;
    }
}