<?php

namespace Realodix\Utils\Test\Strings;

use Realodix\Utils\String\ReadTime;
use Realodix\Utils\Test\TestCase;

class ReadTimeTest extends TestCase
{
    /** @test */
    public function readTime()
    {
        $wpm = 265;
        $this->assertSame('less than a minute', str(str_repeat('word', 3))->readTime($wpm));
        $this->assertSame('1 min read', str(str_repeat('word ', $wpm))->readTime($wpm));
        $this->assertSame('3 min read', str(str_repeat('word ', $wpm * 3))->readTime($wpm));
    }

    /** @test */
    public function readTimeWithImage()
    {
        $wpm = 265;

        $content = '<img />'.str_repeat('word ', $wpm * 2);
        $this->assertSame('3 min read', str($content)->readTime($wpm));

        // https://medium.com/@dahul/inside-medium-94931f66eebd
        $content = str_repeat('<img />', 140).
        'Last month I spent the day at Medium’s San Francisco office. This was part of a personal project
        called 140 Portraits. The project is a behind the scene look at a person or business documented
        throughout one day in 140 images.
        April 29th | 8:30am I arrived @Medium 760 Market St, San Francisco. 9th floor of the historic Phelan
        Building.
        A big thank you to all the fine folks at Medium. It was an honor to spend the day with you. To have a
        look at other 140 projects: Inside NerdWallet or Gary Vaynerchuk Connect up with me on Instagram:
        @dahul';
        $this->assertSame('9 min read', str($content)->readTime($wpm));
    }

    /** @test */
    public function imageReadTime()
    {
        $className = new ReadTime;
        $methodName = 'imageReadTime';

        $content = str_repeat('<img />', 5);
        $actual = $this->invokeMethod($className, $methodName, [$content]) * 60;
        // 12+11+10+9+8
        $this->assertSame(50.0, $actual);

        $content = str_repeat('<img />', 10);
        $actual = $this->invokeMethod($className, $methodName, [$content]) * 60;
        // 12+11+10+9+8+7+6+5+4+3
        $this->assertSame(75.0, $actual);

        $content = str_repeat('<img />', 12);
        $actual = $this->invokeMethod($className, $methodName, [$content]) * 60;
        // 75 + (3+3)
        $this->assertSame(81.0, $actual);
    }

    /** @test */
    public function imageCount()
    {
        $content =
        '
            <img src="url" alt="alternatetext">
            <img src="dinosaur.jpg">
            <img />
            <img>
        ';

        $this->assertSame(3, $this->invokeMethod(new ReadTime, 'imageCount', [$content]));
    }
}
