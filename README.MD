# PasswordTools

**PasswordTools** is a lightweight PHP package for calculating password strength, validating passwords, and visualizing their entropy. 

**Package doesn't use any external packages.**

It provides tools to evaluate password complexity and ensure compliance with security requirements.

---

## Features

- **Entropy Calculation**: Calculate the entropy of a password to measure its complexity.
- **Password Validation**: Validate passwords against customizable requirements (e.g., length, uppercase, numbers, special characters).
- **Brute-Force Resistance**: Estimate the average number of brute-force attempts required to guess a password.
- **Visualization**: Generate a visual meter to represent password strength.

---

## Installation

You can install the package via Composer:

```shell
composer require latgardi/password-tools
```

---

## Usage
### Calculating Password Entropy:
```php
use Latgardi\PasswordTools\EntropyCalculator;

$entropy = EntropyCalculator::calculateEntropy(password: 'StrongPassword123!');
echo "Entropy: {$entropy->bits} bits\n";
echo "Strength Level: {$entropy->strengthLevel->name}\n";

// or
$entropyCalculator = new EntropyCalculator();
$entropy = $entropyCalculator->calculate(password: 'StrongPassword123!')
```
### Validating a Password
```php
use Latgardi\PasswordTools\Validator;
use Latgardi\PasswordTools\Type\ValueObject\PasswordRequirements;
use Latgardi\PasswordTools\Enum\StrengthLevel
$validator = new Validator(
    new PasswordRequirements(
        minLength: 10,
        requireNonASCIICharacters: true,
        minStrength: StrengthLevel::Strong
    )
);
$isValid = $validator->validate(password: 'StrongPaśśwŋrð123!');

if ($isValid) {
    echo "The password is valid.\n";
} else {
    echo "The password is invalid.\n";
}

// or
$entropyCalculator = new EntropyCalculator();
$entropy = $entropyCalculator->calculate(password: 'StrongPaśśwŋrð123!')
$isValid = Validator::validatePassword(password: 'StrongPaśśwŋrð123!')
```

### Visualizing Password Strength
```php
use Latgardi\PasswordTools\Visualizer;
use Latgardi\PasswordTools\Type\ValueObject\Entropy;

$entropy = new Entropy(64.0);
$meter = Visualizer::getEntropyMeter(entropy: $entropy);
$meter->render(); // Output: █████░░░░░
```

## Tests
Run ```composer test```

## License
This project is licensed under 3-Clause BSD License. See the LICENSE file for details.