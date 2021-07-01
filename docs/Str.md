String
===

### `charAt()`

Returns the character at $index, with indexes starting at 0.

```php
use Realodix\Utils\Str;

$str = 'foo bar';

Str::of($str)->charAt(0); // 'f'
Str::of($str)->charAt(6); // 'r'
Str::of($str)->charAt(7); // ''
```

<br>

### `incrementString()`

`incrementString(string $separator = '_', int $first = 1): string`

Increments a string by appending a number to it or increasing the number. Useful for creating “copies” or a file or duplicating database content which has unique titles or slugs.

```php
use Realodix\Utils\Str;

Str::of('file')->incrementString('_');    // file_1
Str::of('file')->incrementString('-', 2); // file-2
Str::of('file_4')->incrementString();     // file_5
```

<br>

### `limit()`

The `limit()` method truncates the given string at the specified length:

```php
use Realodix\Utils\Str;

$str = 'The quick brown fox jumps over the lazy dog';

Str::of($str)->limit(20);
// The quick brown fox...
```

You may also pass a third argument to change the string that will be appended to the end:

```php
use Realodix\Utils\Str;

$str = 'The quick brown fox jumps over the lazy dog';

Str::of($str)->limit(20, '(...)');
// The quick brown fox (...)
```

<br>

### `limitWord()`

The`limitWord()` method limits the number of words in a string. If necessary, you may specify an additional string that will be appended to the truncated string:

```php
use Realodix\Utils\Str;

$str = 'Lorem ipsum dolor sit amet.';

Str::of($str)->limitWord(2);
// Lorem ipsum...

Str::of($str)->limitWord(2, '');
// Lorem ipsum

Str::of($str)->limitWord(3, ' >>>');
// Lorem ipsum dolor >>>
```

<br>

### `slice()`

Returns the substring beginning at $start, and up to, but not including the index specified by $end.

```php
use Realodix\Utils\Str;

$str = 'foobar';

Str::of($str)->slice(-1);   // 'r'
Str::of($str)->slice(0);    // 'foobar'
Str::of($str)->slice(0, 5); // 'fooba'
Str::of($str)->slice(3, 5); // 'ba'
```

<br>

### `stripTags()`

Strip HTML, PHP and shortcode tags from a string.

```php
use Realodix\Utils\Str;

$str = '<r><B><s>[b]</s>bold<e>[/b]</e></B></r>';
Str::of($str)->stripTags(); // 'bold'

$str = '[B]This is bold[/B] and This is [color=#FFCCCC]colored[/color]';
Str::of($str)->stripTags(); // 'This is bold and This is colored'

$str = 'foo[bar';
Str::of($str)->stripTags(); // 'foo[bar'
```
