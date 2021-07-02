VALIDATOR
---

#### `fibonacci($value)`

Validates whether the input follows the Fibonacci integer sequence.

```php
use Realodix\Utils\Validator as Val;

Val::fibonacci(1);  // true
Val::fibonacci(34); // true

Val::fibonacci('is_not_numeric'); // false
```

#### `luhn()`

Ensure that a credit card number passes the Luhn algorithm. It is useful as a first step to validating a credit card: before communicating with a payment gateway.

See https://en.wikipedia.org/wiki/Luhn_algorithm

```php
use Realodix\Utils\Validator as Val;

Val::luhn('79927398713'); // true
Val::luhn('79927398712'); // false
```
