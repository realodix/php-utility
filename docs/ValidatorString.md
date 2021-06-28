VALIDATOR - STRING
---

#### `containsAll()`

Determines if the given string contains all array values:

```php
use Realodix\Utils\Validator as Val;

Val::containsAll('This is my name', ['my', 'name']);
// true

Val::containsAll('This is my name', ['my', 'foo']);
// false
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
