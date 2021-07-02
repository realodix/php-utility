VALIDATOR - IDENTIFICATION
---

#### `issn()`

Validates that a value is a valid International Standard Serial Number (ISSN).

**Options**
- $caseSensitive, default `false`.

```php
use Realodix\Utils\Validator as Val;

Val::issn('2162-321X');      // true
Val::issn('2162321X');       // true
Val::issn('2162321x', true); // false
```

<br>

#### `luhn()`

Ensure that a credit card number passes the Luhn algorithm. It is useful as a first step to validating a credit card: before communicating with a payment gateway.

See https://en.wikipedia.org/wiki/Luhn_algorithm

```php
use Realodix\Utils\Validator as Val;

Val::luhn('79927398713'); // true
Val::luhn('79927398712'); // false
```
