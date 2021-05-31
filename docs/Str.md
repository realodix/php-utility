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
Str::of($str)->charAt(1); // 'o'
Str::of($str)->charAt(6); // 'r'
Str::of($str)->charAt(7); // ''
```

<br>

### `ellipsize()`

`ellipsize(int $max_length, $position = 1, string $ellipsis = '&hellip;'): string`

This function will strip tags from a string, split it at a defined maximum length, and insert an ellipsis.

The first parameter is the string to ellipsize, the second is the number of characters in the final string. The third parameter is where in the string the ellipsis should appear from 0 - 1, left to right. For example. a value of 1 will place the ellipsis at the right of the string, .5 in the middle, and 0 at the left.

An optional fourth parameter is the kind of ellipsis. By default, `&hellip;` will be inserted.

Example:

```php
use Realodix\Utils\Str;

$str = 'this_string_is_entirely_too_long_and_might_break_my_design.jpg';
Str::of($str)->ellipsize(32, .5);

// this_string_is_e&hellip;ak_my_design.jpg
```

<br>

### `excerpt()`

`excerpt(string $phrase = null, int $radius = 100, string $ellipsis = '...'): string`

This function will extract $radius number of characters before and after the central $phrase with an elipsis before and after.

The first paramenter is the text to extract an excerpt from, the second is the central word or phrase to count before and after. The third parameter is the number of characters to count before and after the central phrase. If no phrase passed, the excerpt will include the first $radius characters with the elipsis at the end.

Example:

```php
use Realodix\Utils\Str;


$text = 'Ut vel faucibus odio. Quisque quis congue libero. Etiam gravida
eros lorem, eget porttitor augue dignissim tincidunt. In eget risus eget
mauris faucibus molestie vitae ultricies odio. Vestibulum id ultricies diam.
Curabitur non mauris lectus. Phasellus eu sodales sem. Integer dictum purus
ac enim hendrerit gravida. Donec ac magna vel nunc tincidunt molestie sed
vitae nisl. Cras sed auctor mauris, non dictum tortor. Nulla vel scelerisque
arcu. Cras ac ipsum sit amet augue laoreet laoreet. Aenean a risus lacus.
Sed ut tortor diam.';

Str::of($text)->excerpt('Donec');

// ... non mauris lectus. Phasellus eu sodales sem. Integer dictum purus ac
// enim hendrerit gravida. Donec ac magna vel nunc tincidunt molestie sed
// vitae nisl. Cras sed auctor mauris, non dictum ...
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

### `readingTime()`

`readingTime(int $wpm = 240, $nicely = false)`

Calculate the estimated reading time in seconds for a given piece of content.

```php
use Realodix\Utils\Str;

$sentences = $faker->sentence(24);
Str::of($sentences)->readingTime(); // (24/(240/60)) = 6.0
Str::of($sentences)->readingTime(100); // (24/(100/60)) = 15.0

$sentences = $faker->sentence(500);
Str::of($sentences)->readingTime(nicely: true);
// 'a little over two minutes.'
```

| Screen | Paper | Reader Profile |
| --- | --- | --- |
| 100 wpm | 110 wpm | Insufficient |
| 200 wpm | 240 wpm | Average reader |
| 300 wpm | 400 wpm | Good reader |
| 700 wpm | 1000 wpm | Excellent, accomplished reader |

Source: http://www.readingsoft.com/

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

<br>

### `wordWrap()`

`wordWrap(int $charlim = 76): string`

Wraps text at the specified character count while maintaining complete words.

```php
use Realodix\Utils\Str;

$string = "Here is a simple string of text that will help us demonstrate this function.";
Str::of($string)->wordWrap(25);

// Would produce:
// Here is a simple string
// of text that will help us
// demonstrate this
// function.
```
