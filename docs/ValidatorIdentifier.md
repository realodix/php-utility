VALIDATOR - IDENTIFICATION
---

<!-- START doctoc -->
<!-- END doctoc -->

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

#### `isbn()`

Validates whether the input is a valid ISBN or not.

```php
use Realodix\Utils\Validator as Val;

Val::isbn('ISBN-13: 978-0-596-52068-7'); // true
Val::isbn('978 0 596 52068 7');          // true
Val::isbn('ISBN-12: 978-0-596-52068-7'); // false
Val::isbn('978 10 596 52068 7');         // false

$isbn10 = '0545162076';
Val::isbnIs10($isbn10 );   // true

$isbn13 = '9780545162074';
Val::isbnIs13($isbn13);    // true
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

<br>

#### `uuid()`

Determines if the given string is a valid UUID:

```php
use Realodix\Utils\Validator as Val;

$uuid = 'a0a2a2d2-0b87-4a18-83f2-2529882be2de';
$isUuid = Str::uuid($uuid);    // true

$isUuid = Str::uuid('qwerty'); // false
```
