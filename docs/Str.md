String
===

### Change Case

```php
use Realodix\Utils\Str;

$str = 'foo bar';

Str::of('fooBar')->noCase()    // 'foo bar'
Str::of($str)->camelCase();    // 'fooBar'
Str::of($str)->capitalCase();  // 'Foo Bar'
Str::of($str)->constantCase(); // 'FOO_BAR'
Str::of($str)->dotCase();      // 'foo.bar'
Str::of($str)->headerCase()    // 'Foo-Bar'
Str::of($str)->pascalCase()    // 'FooBar'
Str::of($str)->pathCase()      // 'foo/bar'
Str::of($str)->sentenceCase()  // 'Foo bar'
Str::of($str)->snakeCase()     // 'foo_bar'
Str::of($str)->spinalCase()    // 'foo-bar'
Str::of('fOO bAR')->swapCase() // 'Foo Bar'
```

<br>

### `readTime()`

`readTime(int $wordSpeed = 265, int $imageTime = 12, int $cjkSpeed = 500)`

Calculates the time some text takes the average human to read, based on Medium's read time formula.

- Calculates read time of images in decreasing progression (Example - 12 seconds for the first image, 11 for the second, until images counted at 3 seconds).
- Calculates read time of the Chinese / Japanese / Korean characters separately.
- Removes unwanted html tags to calculate read time more efficiently.


```php
use Realodix\Utils\Str;

$sentences = str_repeat('word ', 300);

Str::of($sentences)->readTime()->get();    // '1 min read'
Str::of($sentences)->readTime(100)->get(); // '3 min read'
```

##### `get()`
Retrieve the read time.

##### `setTranslation(array $translations)`
Manually set the translation text for the class to use. If no key is passed it will default to the English counterpart. A complete translation array will contain the following:

```php
[
    'less_than' => 'less than a minute',
    'one_min'   => '1 min read',
    'more_than' => 'min read',
];
```

##### `toArray()`
Get the contents and settings of the class as an array.

##### `toJson()`
Get the contents and settings of the class as a JSON string.

This method uses [realodix/readtime](https://github.com/realodix/readtime) for more info.

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
