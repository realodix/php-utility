<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
<details>
<summary>Table of Contents</summary>

- [Identifier](#identifier)
    - [`ISBN`](#isbn)
    - [`UUID`](#uuid)

</details>
<!-- END doctoc generated TOC please keep comment here to allow auto update -->

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

<br>

### `UUID`

```php
use Realodix\Utils\Identifier;

// generates a UUID (version 4)
Identifier::uuid();

// generates a "timestamp first" UUID that may be efficiently stored in an
// indexed database column
Identifier::uuidOrdered();
```
