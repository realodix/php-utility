VALIDATOR INTERNET
---

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
<details>
<summary>Table of Contents</summary>

- [`url()`](#url)

</details>
<!-- END doctoc generated TOC please keep comment here to allow auto update -->

#### `url()`

Validates that a value is a valid URL string.

```php
use Realodix\Utils\Validator as Val;

Val::url('http://www.example.com'); // true
Val::url('example.com');            // false
```
