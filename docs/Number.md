Number
===

### Characters To Integers

`charToInt(string $string, int $mode = 0): string`

Convert alphabetic characters to integers.

**Parameters**
- `string`: The string being converted. 
- `mode`
  - 0 - alphabetic characters to integers.
  - 1 - alphabetic characters type uppercase to integers.
  - 2 - alphabetic characters type lowercase to integers.

```php
use Realodix\Utils\Number\Number;

Number::charToInt('A 23 D')    // 10 23 13
Number::charToInt('A 23 d')    // 10 23 45
Number::charToInt('A 23 d', 1) // 10 23 d
Number::charToInt('A 23 d', 2) // A 23 45
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

`Number::toPercentage($value, int $precision = 2, bool $multiply = false, string $locale = 'en_US'): string`

Expresses the number as a percentage and appends the output with a percent sign.

**Parameters**
- `precision` - the precision of the returned number
- `multiply` - boolean to indicate whether the value has to be multiplied by 100. Useful for decimal percentages.

Like `Number::precision()`, this method formats a number according to the supplied precision (where numbers are rounded to meet the given precision).

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

This function only handles numbers in the range 1 through 3999. It will return null for any value outside that range.

```php
use Realodix\Utils\Number\Number;

Number::toRoman(23);   // XXIII
Number::toRoman(324);  // CCCXXIV
Number::toRoman(2534); // MMDXXXIV
```

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
