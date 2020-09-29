VALIDATOR INTERNET
---
#### `email(string $email)`

Validates an email address.

```php
use Realodix\Utils\Validator as Val;

Val::email('example@example.co.uk']);
// true
```

<br>

#### `url()`

Validates that a value is a valid URL string.

```php
use Realodix\Utils\Validator as Val;

Val::url('http://www.example.com'); // true
Val::url('example.com');            // false
```
