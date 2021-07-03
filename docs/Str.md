String
===

### `charAt()`

Returns the character at $index, with indexes starting at 0.

```php
use Realodix\Utils\Str;

$str = 'foo bar';

Str::charAt($str, 0); // 'f'
Str::charAt($str, 6); // 'r'
Str::charAt($str, 7); // ''
```

<br>

### `limit()`

The `limit()` method truncates the given string at the specified length:

```php
use Realodix\Utils\Str;

$str = 'The quick brown fox jumps over the lazy dog';

Str::limit($str, 20);
// The quick brown fox...
```

You may also pass a third argument to change the string that will be appended to the end:

```php
use Realodix\Utils\Str;

$str = 'The quick brown fox jumps over the lazy dog';

Str::limit($str, 20, '(...)');
// The quick brown fox (...)
```

<br>

### `limitWord()`

The`limitWord()` method limits the number of words in a string. If necessary, you may specify an additional string that will be appended to the truncated string:

```php
use Realodix\Utils\Str;

$str = 'Lorem ipsum dolor sit amet.';

Str::limitWord($str, 2);
// Lorem ipsum...

Str::limitWord($str, 2, '');
// Lorem ipsum

Str::limitWord($str, 3, ' >>>');
// Lorem ipsum dolor >>>
```

<br>

### `slice()`

Returns the substring beginning at $start, and up to, but not including the index specified by $end.

```php
use Realodix\Utils\Str;

$str = 'foobar';

Str::slice($str, -1);   // 'r'
Str::slice($str, 0);    // 'foobar'
Str::slice($str, 0, 5); // 'fooba'
Str::slice($str, 3, 5); // 'ba'
```

<br>

### `stripTags()`

Strip HTML, PHP and shortcode tags from a string.

```php
use Realodix\Utils\Str;

$str = '<r><B><s>[b]</s>bold<e>[/b]</e></B></r>';
Str::stripTags($str); // 'bold'

$str = '[B]This is bold[/B] and This is [color=#FFCCCC]colored[/color]';
Str::stripTags($str); // 'This is bold and This is colored'

$str = 'foo[bar';
Str::stripTags($str); // 'foo[bar'
```
