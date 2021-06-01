Number
===

### Characters To Integers

Convert alphabetic characters to integers.

```php
use Realodix\Utils\Number\Number;

Number::charToInt('A 23 D')      // 10 23 13
Number::charToInt('A 23 d')      // 10 23 45
Number::charUpperToInt('A 23 d') // 10 23 d
Number::charLowerToInt('A 23 d') // A 23 45
```

<br>

### Number::format()

`Number::format(mixed $value, array $options = [])`

This method gives you much more control over the formatting of numbers for use in your views (and is used as the main method by most of the other NumberHelper methods).

The ``$value`` parameter is the number that you are planning on
formatting for output. With no ``$options`` supplied, the number
1236.334 would output as 1,236. Note that the default precision is
zero decimal places.

The ``$options`` parameter is where the real magic for this method
resides.

-  If you pass an integer then this becomes the amount of precision
   or places for the function.
-  If you pass an associated array, you can use the following keys:


| Option   | Description                                      |
|----------|--------------------------------------------------|
| places   | Number of decimal places to use, ie. 2 |
| precision| Maximum number of decimal places to use, ie. 2 |
| pattern  | An ICU number pattern to use for formatting the number ie. #,###.00 |
| locale   | The locale name to use for formatting number, ie. "fr_FR". |
| before   | Text to display before the rendered number. |
| after    | Text to display after the rendered number. |

```php
use Realodix\Utils\Number\Number;

Number::format('123456.7890', [
    'places' => 2,
    'before' => '¥ ',
    'after'  => ' !'
]);
// Output '¥ 123,456.79 !'

Number::format('123456.7890', [
    'locale' => 'fr_FR'
]);
// Output '123 456,79 !'

Number::format('123456.7890', [
    'places' => 2,
    'before' => '¥ ',
    'after'  => ' !'
]);
// Output '¥ 123,456.79 !'

Number::format('123456.7890', [
    'locale' => 'fr_FR'
]);
// Output '123 456,79 !'
```

<br>

### IBAN

IBAN (International Bank Account Number) is an internationally agreed means of identifying bank accounts across national borders with a reduced risk of propagating transcription errors.

```php
use Realodix\Utils\Number\Iban;

//http://www.ibantest.com/en/how-is-the-iban-check-digit-calculated
$iban = 'DE29100100100987654321';

// Without spaces
Iban::verify($iban); // true

// With multiple spaces
Iban::verify('DE29 1001 0010 0987 6543 21'); // true

Iban::toHumanFormat($iban);
// DE29 1001 0010 0987 6543 21

Iban::toObfuscatedFormat($iban);
// DE** **** **** **** **43 21

Iban::toMachineFormat('DE29 1001 0010 0987 6543 21');
// DE29100100100987654321

Iban::getBban($iban);
// 100100100987654321

$withoutChecksum = 'DE00 1001 0010 0987 6543 21';
Iban::getChecksum($withoutChecksum);
// 29

Iban::setChecksum($withoutChecksum);
// DE29100100100987654321
```

<br>

### Number::precision()

`Number::precision($value, int $precision = 2, string $locale = 'en_US'): string`

This method displays a number with the specified amount of precision (decimal places). It will round in order to maintain the level of precision defined.

```php
use Realodix\Utils\Number\Number;

Number::precision(456.91873645, 2);
// 456.92

Number::precision(1.234, 3, locale: 'id_ID')
// 1,234
```

<br>

### Number::toAmountShort()

`Number::toAmountShort(int $n)`

Convert large positive numbers in to short form like 1K+, 100K+, 199K+, 1M+, 10M+, 1B+ etc.

Examples:

```php
use Realodix\Utils\Number\Number;

Number::toAmountShort(123456);          // 123.45K+
Number::toAmountShort(1234567890123);   // 1.23T+
Number::toAmountShort(123,456,789,012); // 1.23T+
```

<br>

### Number::toPercentage()

`Number::toPercentage($value, int $precision = 2, $multiply = false, string $locale = 'en_US'): string`

**Options:**
- `multiply` - Boolean to indicate whether the value has to be multiplied by 100. Useful for decimal percentages.

Like `Number::precision()`, this method formats a number according to the supplied precision (where numbers are rounded to meet the given precision). This method also expresses the number as a percentage and appends the output with a percent sign.

```php
use Realodix\Utils\Number\Number;

Number::toPercentage(45.691873645);
// 45.69%

Number::toPercentage(0.45691, 1, multiply: true);
// 45.7%
```

<br>

### Number::toRoman()

`toRoman(string $num): ?string`

Converts a number into roman:

```php
use Realodix\Utils\Number\Number;

Number::toRoman(23);   // XXIII
Number::toRoman(324);  // CCCXXIV
Number::toRoman(2534); // MMDXXXIV
```

This function only handles numbers in the range 1 through 3999. It will return null for any value outside that range.

<br>

### Number::toSize()

`Number::toSize($size, int $precision = 2)`

This method formats data sizes in human readable forms. It provides a shortcut way to convert bytes to KB, MB, GB, and TB. The size is displayed with a two-digit precision level, according to the size of data supplied (i.e. higher sizes are expressed in larger terms):

```php
use Realodix\Utils\Number\Number;

Number::toSize(0);          // 0 Byte
Number::toSize(1024);       // 1 KB
Number::toSize(1321205.76); // 1.26 MB
Number::toSize(5368709120); // 5 GB

Number::toSize(1398101.333333, 4) // 1.3333 MB
```
