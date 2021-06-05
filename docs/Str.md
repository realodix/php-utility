String
===

### Change Case

Transform a string between camelCase, PascalCase, Capital Case, snake_case, param-case, CONSTANT_CASE and others.

See [realodix/change-case](https://github.com/realodix/change-case)

<br>

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

### `readTime()`

`readTime(int $wpm = 265): string`

Calculates the time some text takes the average human to read, based on Medium's read time formula.

- **Read Time** — Based on the average reading speed of an adult (roughly 265 WPM).
- **Image Read Time** — Images add an additional 12 seconds for the first image, 11 seconds for the second image, and minus an additional second for each subsequent image, through the tenth image. Any images after the tenth image are counted at three seconds.

```php
use Realodix\Utils\Str;

$sentences = str_repeat('word ', 300);

Str::of($sentences)->readTime();    // '1 min read'
Str::of($sentences)->readTime(100); // '3 min read'
```

**References**
- https://help.medium.com/hc/en-us/articles/214991667-Read-time
- https://blog.medium.com/read-time-and-you-bc2048ab620c
- https://medium.com/blogging-guide/how-is-medium-article-read-time-calculated-924420338a85

<br>

### `removeNonAlpha()`

```php
use Realodix\Utils\Str;

$str = 'fooB4r';
Str::of($str)->removeNonAlpha(); // 'fooBr'

$str = 'fooBar';
Str::of($str)->removeNonAlpha(); // ''
```

<br>

### `removeNonAlphaNum()`

```php
use Realodix\Utils\Str;

$str = 'f@@B4r';
Str::of($str)->removeNonAlphaNum(); // 'fB4r'

$str = 'fooBar';
Str::of($str)->removeNonAlphaNum(); // ''
```

<br>

### `removeNonNumeric()`

```php
use Realodix\Utils\Str;

$str = 'fooB4r';
Str::of($str)->removeNonNumeric(); // '4'

$str = '1234';
Str::of($str)->removeNonNumeric(); // ''
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

<br>

### `toAscii()`

The `toAscii()` method will attempt to transliterate the string into an ASCII value:

`toAscii(string $value, string $language = 'en', bool $removeUnsupported = true)`

- `$language`          Language of the source string.
- `$removeUnsupported` Whether or not to remove the unsupported characters.

```php
use Realodix\Utils\Str;

Str::of('û')->toAscii();
// 'u'
```
