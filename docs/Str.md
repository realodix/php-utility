String
===

### `Str::camelCase()`

Transform into a string with the separator denoted by the next word capitalized.

```php
use Realodix\Utils\Str;

Str::camelCase("Capital Case");  // capitalCase
Str::camelCase("CONSTANT_CASE"); // constantCase
Str::camelCase("dot.case");      // dotCase
```

<br>

### `Str::capitalCase()`

Transform into a space separated string with each word capitalized.

```php
use Realodix\Utils\Str;

Str::capitalCase("CONSTANT_CASE"); // Constant Case
Str::capitalCase("dot.case");      // Dot Case
```

<br>

### `Str::constantCase()`

Transform into upper case string with an underscore between words.

```php
use Realodix\Utils\Str;

Str::constantCase("Capital Case");  // CAPITAL_CASE
Str::constantCase("dot.case");      // DOT_CASE
```

<br>

### `Str::dotCase()`

Transform into a lower case string with a period between words.

```php
use Realodix\Utils\Str;

Str::dotCase("Capital Case");  // capital.case
Str::dotCase("CONSTANT_CASE"); // constant.case
```

<br>

### `Str::headerCase()`

Transform into a dash separated string of capitalized words.

```php
use Realodix\Utils\Str;

Str::headerCase("CONSTANT_CASE"); // Constant-Case
Str::headerCase("dot.case");      // Dot-Case
```

<br>

### `Str::noCase()`

Transform into a lower cased string with spaces between words.

```php
use Realodix\Utils\Str;

Str::noCase("string");         // string
Str::noCase("dot.case");       // dot case
Str::noCase("PascalCase");     // pascal case
Str::noCase("version 1.2.10"); // version 1 2 10
```

<br>

### `Str::pascalCase()`

Transform into a string of capitalized words without separators.

```php
use Realodix\Utils\Str;

Str::pascalCase("string");        // String
Str::pascalCase("dot.case");      // DotCase
Str::pascalCase("camelCase");     // CamelCase
Str::pascalCase("CONSTANT_CASE"); // ConstantCase
```

<br>

### `Str::pathCase()`

Transform into a lower case string with slashes between words.

```php
use Realodix\Utils\Str;

Str::pathCase("camelCase"); // camel/case
Str::pathCase("dot.case");  // dot/case
```

<br>

### `Str::sentenceCase()`

Transform into a lower case with spaces between words, then capitalize the string.

```php
use Realodix\Utils\Str;

Str::sentenceCase("camelCase"); // Camel case
Str::sentenceCase("dot.case");  // Dot case
```

<br>

### `Str::snakeCase()`

Transform into a lower case string with underscores between words.

```php
use Realodix\Utils\Str;

Str::snakeCase("string");        // string
Str::snakeCase("camelCase");     // camel_case
Str::snakeCase("CONSTANT_CASE"); // constant_case
Str::snakeCase("dot.case");      // dot_case
Str::snakeCase("path/case");     // path_case
```

<br>

### `Str::spinalCase()`

Transform into a lower cased string with dashes between words.

```php
use Realodix\Utils\Str;

Str::spinalCase("string");        // string
Str::spinalCase("dot.case");      // dot-case
Str::spinalCase("camelCase");     // camel-case
Str::spinalCase("CONSTANT_CASE"); // constant-case
Str::spinalCase("path/case");     // path-case
```

<br>

### `Str::swapCase()`

Transform a string by swapping every character from upper to lower case, or lower to upper case.

```php
use Realodix\Utils\Str;

Str::swapCase("camelCase"); // CAMELcASE
Str::swapCase("dot.case");  // DOT.CASE
```

<br>

### `Str::titleCase()`

Transform a string into title case following English rules.

```php
use Realodix\Utils\Str;

$str = 'Laravel is a web application framework with expressive, elegant syntax.';

Str::titleCase($str);
// Laravel Is a Web Application Framework with Expressive, Elegant Syntax.

$str = 'The iPhone is a line of touchscreen-based smartphones designed and marketed by Apple Inc.';

Str::titleCase($str);
// The iPhone Is a Line of Touchscreen-Based Smartphones Designed and Marketed by Apple Inc.
```

<br>

Other Functions
---

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

Calculate the estimated reading time in seconds for a given piece of content.

- **Average Read Time** — 265 Words per min
- **Image Read Time** — Images add an additional 12 seconds for the first image, 11 seconds for the second image, and minus an additional second for each subsequent image, through the tenth image. Any images after the tenth image are counted at three seconds.

```php
use Realodix\Utils\Str;

$sentences = $faker->sentence(300);

Str::of($sentences)->readTime();    // '1 min read'
Str::of($sentences)->readTime(100); // '3 min read'
```

**References**
- https://help.medium.com/hc/en-us/articles/214991667-Read-time

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
