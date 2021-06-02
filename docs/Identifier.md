Identifier
===

### `ISBN`

```php
use Realodix\Utils\Identifier;

// converts the given ISBN-10 to an ISBN-13.
Identifier::isbn10to13(string $isbn): string 
Identifier::isbn10to13('123456789X');
// '9781234567897'

// converts the given ISBN-13 to an ISBN-10.
Identifier::isbn13to10(string $isbn): string 
Identifier::isbn13to10('9781234567897');
// '123456789X'

// formats the given ISBN by adding hyphens at the proper places.
Identifier::isbnFormat(string $isbn): string
Identifier::isbnFormat('123456789X');    // '1-234-56789-X'
Identifier::isbnFormat('9781234567897'); // '978-1-234-56789-7'
```
