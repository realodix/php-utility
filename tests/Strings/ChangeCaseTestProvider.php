<?php

namespace Realodix\Utils\Test\Strings;

trait ChangeCaseTestProvider
{
    public function noCaseProvider()
    {
        return [
            ['', null],
            ['string', ' string '],
            ['string', 'string'],
            ['camel case', 'camelCase'],
            ['camel case', 'CAMELCase'],
            ['capital case', 'Capital Case'],
            ['constant case', 'CONSTANT_CASE'],
            ['dot case', 'dot.case'],
            ['spinal case', 'spinal-case'],
            ['pascal case', 'PascalCase'],
            ['path case', 'path/case'],
            ['snake case', 'snake_case'],
            ['version 1 2 10', 'version 1.2.10'],
        ];
    }

    public function camelCaseProvider()
    {
        return [
            ['string', 'string'],
            ['camelCase', 'CAMELCase'],
            ['capitalCase', 'Capital Case'],
            ['constantCase', 'CONSTANT_CASE'],
            ['dotCase', 'dot.case'],
            ['spinalCase', 'spinal-case'],
            ['pascalCase', 'PascalCase'],
            ['pathCase', 'path/case'],
            ['snakeCase', 'snake_case'],
            ['version1210', 'version 1.2.10'],
        ];
    }

    public function capitalCaseProvider()
    {
        return [
            ['String', 'string'],
            ['Camel Case', 'camelCase'],
            ['Camel Case', 'CAMELCase'],
            ['Capital Case', 'Capital Case'],
            ['Constant Case', 'CONSTANT_CASE'],
            ['Dot Case', 'dot.case'],
            ['Spinal Case', 'spinal-case'],
            ['Pascal Case', 'PascalCase'],
            ['Path Case', 'path/case'],
            ['Snake Case', 'snake_case'],
            ['Version 1 2 10', 'version 1.2.10'],
        ];
    }

    public function constantCaseProvider()
    {
        return [
            ['STRING', 'string'],
            ['CAMEL_CASE', 'camelCase'],
            ['CAMEL_CASE', 'CAMELCase'],
            ['CAPITAL_CASE', 'Capital Case'],
            ['DOT_CASE', 'dot.case'],
            ['SPINAL_CASE', 'spinal-case'],
            ['PASCAL_CASE', 'PascalCase'],
            ['PATH_CASE', 'path/case'],
            ['SNAKE_CASE', 'snake_case'],
            ['VERSION_1_2_10', 'version 1.2.10'],
        ];
    }

    public function dotCaseProvider()
    {
        return [
            ['string', 'string'],
            ['camel.case', 'camelCase'],
            ['camel.case', 'CAMELCase'],
            ['capital.case', 'Capital Case'],
            ['constant.case', 'CONSTANT_CASE'],
            ['spinal.case', 'spinal-case'],
            ['pascal.case', 'PascalCase'],
            ['path.case', 'path/case'],
            ['snake.case', 'snake_case'],
            ['version.1.2.10', 'version 1.2.10'],
        ];
    }

    public function headerCaseProvider()
    {
        return [
            ['', ''],
            ['Test', 'test'],
            ['Test-String', 'test string'],
            ['Test-String', 'Test String'],
            ['Test-V2', 'TestV2'],
            ['Version-1-2-10', 'version 1.2.10'],
            ['Version-1-21-0', 'version 1.21.0'],
        ];
    }

    public function pascalCaseProvider()
    {
        return [
            ['String', 'string'],
            ['CamelCase', 'camelCase'],
            ['CamelCase', 'CAMELCase'],
            ['CapitalCase', 'Capital Case'],
            ['ConstantCase', 'CONSTANT_CASE'],
            ['DotCase', 'dot.case'],
            ['SpinalCase', 'spinal-case'],
            ['PathCase', 'path/case'],
            ['SnakeCase', 'snake_case'],
            ['Version1210', 'version 1.2.10'],
        ];
    }

    public function pathCaseProvider()
    {
        return [
            ['string', 'string'],
            ['camel/case', 'camelCase'],
            ['camel/case', 'CAMELCase'],
            ['capital/case', 'Capital Case'],
            ['constant/case', 'CONSTANT_CASE'],
            ['dot/case', 'dot.case'],
            ['spinal/case', 'spinal-case'],
            ['pascal/case', 'PascalCase'],
            ['snake/case', 'snake_case'],
            ['version/1/2/10', 'version 1.2.10'],
        ];
    }

    public function sentenceCaseProvider()
    {
        return [
            ['String', 'string'],
            ['Camel case', 'camelCase'],
            ['Camel case', 'CAMELCase'],
            ['Capital case', 'Capital Case'],
            ['Constant case', 'CONSTANT_CASE'],
            ['Dot case', 'dot.case'],
            ['Spinal case', 'spinal-case'],
            ['Pascal case', 'PascalCase'],
            ['Path case', 'path/case'],
            ['Snake case', 'snake_case'],
            ['Version 1 2 10', 'version 1.2.10'],
        ];
    }

    public function snakeCaseProvider()
    {
        return [
            ['string', 'string'],
            ['camel_case', 'camelCase'],
            ['camel_case', 'CAMELCase'],
            ['capital_case', 'Capital Case'],
            ['constant_case', 'CONSTANT_CASE'],
            ['dot_case', 'dot.case'],
            ['path_case', 'path/case'],
            ['spinal_case', 'spinal-case'],
            ['version_1_2_10', 'version 1.2.10'],
        ];
    }

    public function spinalCaseProvider()
    {
        return [
            ['string', 'string'],
            ['camel-case', 'camelCase'],
            ['camel-case', 'CAMELCase'],
            ['capital-case', 'Capital Case'],
            ['constant-case', 'CONSTANT_CASE'],
            ['dot-case', 'dot.case'],
            ['path-case', 'path/case'],
            ['snake-case', 'snake_case'],
            ['version-1-2-10', 'version 1.2.10'],
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

    public function swapCaseProvider()
    {
        return [
            ['', ''],
            ['test', 'TEST'],
            ['test string', 'TEST STRING'],
            ['Test String', 'tEST sTRING'],
            ['TestV2', 'tESTv2'],
            ['sWaP cAsE', 'SwAp CaSe'],
        ];
    }

    public function titleCaseProvider()
    {
        return [
            ['', ''],
            ['2019', '2019'],
            ['test', 'Test'],
            ['two words', 'Two Words'],
            ['one. two.', 'One. Two.'],
            ['a small word starts', 'A Small Word Starts'],
            ['small word ends on', 'Small Word Ends On'],
            ['we keep NASA capitalized', 'We Keep NASA Capitalized'],
            ['pass camelCase through', 'Pass camelCase Through'],
            ['follow step-by-step instructions', 'Follow Step-by-Step Instructions'],
            ['your hair[cut] looks (nice)', 'Your Hair[cut] Looks (Nice)'],
            ['leave Q&A unscathed', 'Leave Q&A Unscathed'],
            [
                'piña colada while you listen to ænima',
                'Piña Colada While You Listen to Ænima',
            ],
            ['start title – end title', 'Start Title – End Title'],
            ['start title–end title', 'Start Title–End Title'],
            ['start title — end title', 'Start Title — End Title'],
            ['start title—end title', 'Start Title—End Title'],
            ['start title - end title', 'Start Title - End Title'],
            ["don't break", "Don't Break"],
            ['"double quotes"', '"Double Quotes"'],
            ['double quotes "inner" word', 'Double Quotes "Inner" Word'],
            ['fancy double quotes “inner” word', 'Fancy Double Quotes “Inner” Word'],
            ['have you read “The Lottery”?', 'Have You Read “The Lottery”?'],
            ['one: two', 'One: Two'],
            ['one two: three four', 'One Two: Three Four'],
            ['one two: "Three Four"', 'One Two: "Three Four"'],
            ['email email@example.com address', 'Email email@example.com Address'],
            [
                'you have an https://example.com/ title',
                'You Have an https://example.com/ Title',
            ],
            ['_underscores around words_', '_Underscores Around Words_'],
            ['*asterisks around words*', '*Asterisks Around Words*'],
            ['this vs. that', 'This vs. That'],
            ['this vs that', 'This vs That'],
            ['this v. that', 'This v. That'],
            ['this v that', 'This v That'],
            [
                'Scott Moritz and TheStreet.com’s million iPhone la-la land',
                'Scott Moritz and TheStreet.com’s Million iPhone La-La Land',
            ],
            [
                'Notes and observations regarding Apple’s announcements from ‘The Beat Goes On’ special event',
                'Notes and Observations Regarding Apple’s Announcements From ‘The Beat Goes On’ Special Event',
            ],
            [
                'the quick brown fox jumps over the lazy dog',
                'The Quick Brown Fox Jumps over the Lazy Dog',
            ],
            ['newcastle upon tyne', 'Newcastle upon Tyne'],
            // ["newcastle *upon* tyne", "Newcastle *upon* Tyne"],
        ];
    }
}
