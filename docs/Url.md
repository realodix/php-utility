URL
---

A simple static class to deal with URL's in your applications.


<br>

### `Url::display()`

`Url::display(string $url, bool $scheme = true, int $limit = null)`

Display the link according to what You need.

```php
use Realodix\Utils\Url;

Url::display('https://example.com/abcde/');
// https://example.com/abcde/

Url::display('https://example.com/abcde/', false);
// example.com/abcde

Url::display('https://example.com/abcdefghij', true, 28);
// https://example.com/abcde...

Url::display('https://example.com/abcdefghij', true, 29);
// https://example.com/abc...hij

Url::display('https://example.com/abcdefghij', false, 21);
// example.com/abc...hij
```

<br>

### `Url::sanitize`

`Url::sanitize($url)`

Remove http, https, www and slash from URL.

```php
use Realodix\Utils\Url;

Url::sanitize('https://example.com/abcde/');
// example.com/abcde
```
