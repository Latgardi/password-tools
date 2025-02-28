<?php
declare(strict_types=1);

namespace Latgardi\PasswordTools\Type\Abstract;

/**
 * Abstract factory class for creating instances of the current class.
 *
 * This class provides a static method `make()` that returns an instance of the class
 * that called the method. It is useful for implementing the "Static Factory" pattern.
 */
abstract class Factory
{
    //abstract function __construct();
    /**
     * Creates and returns an instance of the current class.
     *
     * This method uses late static binding to create an instance of the class
     * that called the method, rather than the class in which the method is defined.
     *
     * @return static An instance of the class that called this method.
     */
    public static function make(...$parameters): static
    {
        return new static(...$parameters);
    }
}