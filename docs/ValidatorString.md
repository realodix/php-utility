VALIDATOR - STRING
---

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
<details>
<summary>Table of Contents</summary>

- [`ascii(string $str)`](#asciistring-str)
- [`contains()`](#contains)
- [`containsAll()`](#containsall)
- [`hexRgbColor()`](#hexrgbcolor)
- [`list()`](#list)
- [`range(mixed $value, array $range)`](#rangemixed-value-array-range)
- [`startsWith()`](#startswith)
- [`endsWith()`](#endswith)

</details>
<!-- END doctoc generated TOC please keep comment here to allow auto update -->

#### `ascii(string $str)`

Checks if a string is 7 bit ASCII.

```php
use Realodix\Utils\Validator as Val;

Val::ascii('白'); // false
```

<br>

#### `contains()`

Determines if the given string contains the given value (case sensitive):

```php
use Realodix\Utils\Validator as Val;

Val::contains('This is my name', 'my');
// true
```

You may also pass an array of values to determine if the given string contains any of the values:

```php
use Realodix\Utils\Validator as Val;

Val::contains('This is my name', ['my', 'foo']);
// true
```

<br>

#### `containsAll()`

Determines if the given string contains all array values:

```php
use Realodix\Utils\Validator as Val;

Val::containsAll('This is my name', ['my', 'name']);
// true
```

<br>

#### `hexRgbColor()`

Validates weather the input is a hex RGB color or not.

```php
use Realodix\Utils\Validator as Val;

Val::hexRgbColor('#FFFAAA'); // true
Val::hexRgbColor('123123');  // true
Val::hexRgbColor('#0');      // false
```

<br>

#### `list()`

Checks if the array is indexed in ascending order of numeric keys from zero, a.k.a list.

```php
use Realodix\Utils\Validator as Val;

Val::list(['a', 'b', 'c']));       // true
Val::list([4 => 1, 2, 3]));        // false
Val::list(['a' => 1, 'b' => 2]));  // false
```

<br>

#### `range(mixed $value, array $range)`

Checks if the value is in the given range `[min, max]`, where the upper or lower limit can be omitted (null). Numbers, strings and DateTime objects can be compared.

If both boundaries are missing (`[null, null]`) or the value is null, it returns false.

```php
use Realodix\Utils\Validator as Val;

Val::range(5, [0, 5]);     // true
Val::range(23, [null, 5]); // false
Val::range(23, [5]);       // true
Val::range(1, [5]);        // false
```

<br>

#### `startsWith()`

Determines if the given string begins with the given value:

```php
use Realodix\Utils\Validator as Val;

Val::startsWith('This is my name', 'This');
// true
```

<br>

#### `endsWith()`

Determines if the given string ends with the given value:

```php
use Realodix\Utils\Validator as Val;

Val::endsWith('This is my name', 'name');
// true
```

You may also pass an array of values to determine if the given string ends with any of the given values:

```php
use Realodix\Utils\Validator as Val;

Val::endsWith('This is my name', ['name', 'foo']);
// true

Val::endsWith('This is my name', ['this', 'foo']);
// false
```
