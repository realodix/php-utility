VALIDATOR - NUMBER
---

#### `fibonacci($value)`

Validates whether the input follows the Fibonacci integer sequence.

```php
use Realodix\Utils\Validator as Val;

Val::fibonacci(1);  // true
Val::fibonacci(34); // true

Val::fibonacci('is_not_numeric'); // false
```
