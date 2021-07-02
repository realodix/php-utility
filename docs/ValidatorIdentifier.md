VALIDATOR - IDENTIFICATION
---

#### `creditCard()`

Ensures that a credit card number is valid for a given credit card company. It can be used to validate the number before trying to initiate a payment through a payment gateway.

**Options:**
- `AMEX` - American Express
- `CHINA_UNIONPAY`
- `DINERS`
- `DISCOVER`
- `INSTAPAYMENT`
- `JCB`
- `LASER`
- `MAESTRO`
- `MASTERCARD`
- `MIR`
- `UATP` - Universal Air Travel Plan
- `VISA`

```php
use Realodix\Utils\Validator as Val;

// http://support.worldpay.com/support/kb/bg/testandgolive/tgl5103.html

// true
Val::creditCard('5555555555554444', 'MASTERCARD');
Val::creditCard('5105105105105100', ['VISA', 'MASTERCARD']);

Val::creditCard('0', 'MASTERCARD'); // false
```

<br>

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
