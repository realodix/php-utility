<?php

namespace Realodix\Utils\Test\Identifier;

use Realodix\Utils\Identifier;
use Realodix\Utils\Test\TestCase;

class IdentifierTest extends TestCase
{
    /** @test */
    public function isbn()
    {
        $isbn10 = '1338218395';
        $isbn13 = '9781338218398';

        $this->assertSame($isbn13, Identifier::isbn10to13($isbn10));
        $this->assertSame($isbn10, Identifier::isbn13to10($isbn13));
        $this->assertSame('1-338-21666-X', Identifier::isbnFormat('133821666X'));
        $this->assertSame('978-1-338-21839-8', Identifier::isbnFormat($isbn13));
    }
}
