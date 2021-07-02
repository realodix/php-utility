Validator - String
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
