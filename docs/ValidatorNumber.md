VALIDATOR - NUMBER
---

#### `divisibleBy($value1, $value2)`

Validates that a value is divisible by another value.

```php
use Realodix\Utils\Validator as Val;

Val::divisibleBy(10, 5); // true
Val::divisibleBy(10, 0.1); // true
Val::divisibleBy(10, 4); // false
```

<br>

#### `numeric()`

Checks if the value is a number or a number written in a string

```php
use Realodix\Utils\Validator as Val;

Val::numeric(23);       // true
Val::numeric(1.78);     // true
Val::numeric('+42');    // true
Val::numeric('3.14');   // true
Val::numeric('string'); // false
Val::numeric('1e6');    // false
```

<br>

#### `numericInt()`

Checks if the value is an integer or a integer written in a string.

```php
use Realodix\Utils\Validator as Val;

Val::numericInt(23);       // true
Val::numericInt(1.78);     // false
Val::numericInt('+42');    // true
Val::numericInt('3.14');   // false
Val::numericInt('string'); // false
```
