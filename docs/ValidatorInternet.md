VALIDATOR INTERNET
---
#### `url()`

Validates that a value is a valid URL string.

```php
use Realodix\Utils\Validator as Val;

Val::url('http://www.example.com'); // true
Val::url('example.com');            // false
```
