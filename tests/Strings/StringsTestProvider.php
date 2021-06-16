<?php

namespace Realodix\Utils\Test\Strings;

trait StringsTestProvider
{
    public function charAtProvider()
    {
        return [
            ['f', 'foo bar', 0],
            ['o', 'foo bar', 1],
            ['r', 'foo bar', 6],
            ['', 'foo bar', 7],
            ['f', 'fòô bàř', 0, 'UTF-8'],
            ['ò', 'fòô bàř', 1, 'UTF-8'],
            ['ř', 'fòô bàř', 6, 'UTF-8'],
            ['', 'fòô bàř', 7, 'UTF-8'],
        ];
    }

    public function removeNonAlphaProvider()
    {
        return [
            ['lowerUPPER', '!@lowerUPPER_?'],
            ['httpsgithubcomrealodixphputility', 'https://github.com/realodix/php-utility'],
            [
                'httpspackagistorgpackagesrealodixphputility',
                'https://packagist.org/packages/realodix/php-utility',
            ],
            [
                'httpstranslategooglecomslidtlentextRealodixAoptranslate',
                'https://translate.google.com/?sl=id&tl=en&text=Realodix%0A&op=translate',
            ],
            ['httpsiwsemojidomainexample', 'https://i❤️.ws/emojidomain/example'],
            ['fB', 'fòôBàř'],
            ['fb', 'fòô bàř'],
            ['', 'òô'],
        ];
    }

    public function removeNonAlphaNumProvider()
    {
        return [
            ['low3rUPP3R', '!@low3rUPP3R_?'],
            [
                'httpstranslategooglecomslidtlentextRealodix0Aoptranslate',
                'https://translate.google.com/?sl=id&tl=en&text=Realodix%0A&op=translate',
            ],
            ['httpsiwsemojidomainexample', 'https://i❤️.ws/emojidomain/example'],
            ['fB', 'fòôBàř'],
            ['fb', 'fòô bàř'],
            ['', 'òô'],
        ];
    }

    public function removeNonNumericProvider()
    {
        return [
            ['33', '!@low3rUPP3R_?'],
            ['6', 'Every 6 Months'],
            ['123099', '$ 123.099'],
            ['', 'fòô bàř'],
            ['', 'òô'],
        ];
    }

    public function sliceProvider()
    {
        return [
            ['r', 'foobar', -1],
            ['', 'foobar', 999],
            ['foobar', 'foobar', 0],
            ['foobar', 'foobar', 0, null],
            ['foobar', 'foobar', 0, 6],
        ];
    }

    public function sliceProvider2()
    {
        return [
            ['fooba', 'foobar', 0, 5],
            ['', 'foobar', 3, 0],
            ['', 'foobar', 3, 2],
            ['ba', 'foobar', 3, 5],
            ['ba', 'foobar', 3, -1],
        ];
    }

    public function stripTagsProvider()
    {
        return [
            ['foo bar', 'foo bar'],
            ['before', 'before[gallery]'],
            ['after', '[gallery]after'],
            ['beforeafter', 'before[gallery]after'],
            ['before[after', 'before[after'],
            ['beforeafter', 'before[gallery id="123" size="medium"]after'],
            ['beforeafter', 'before[footag]after'],
            ['This is bold and This is colored', '[B]This is bold[/B] and This is [color=#FFCCCC]colored[/color]'],
            ['bold', '[b:20m4ill1]bold[/b:20m4ill1]'],
            ['bold', '<r><B><s>[b]</s>bold<e>[/b]</e></B></r>'],
            ['bo &amp; ld', '[b:20m4ill1]bo &amp; ld[/b:20m4ill1]'],
            ['bo &amp; ld', '<r><B><s>[b]</s>bo &amp; ld<e>[/b]</e></B></r>'],

            ['', '[happy direction="left"]<Yay>[/happy]'],
            ['English Wikipedia', '[url=https://en.wikipedia.org]English Wikipedia[/url]'],
        ];
    }
}
