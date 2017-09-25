<?php

namespace Tests;

use Bavix\Helpers\Arr;
use Bavix\Helpers\Str;
use Bavix\Tests\Unit;

class StrTest extends Unit
{

    public function testSplit()
    {
        $this->assertArraySubset(
            Str::split('abc'),
            ['a', 'b', 'c']
        );
    }

    public function testShorten()
    {
        $text = 'web developing group';
        $shorten = Str::shorten($text, 18, '...');

        $this->assertSame(
            $shorten,
            substr($text, 0, -5) . '...'
        );
    }

    public function testUcFirst()
    {
        $this->assertSame('Bavix', Str::ucFirst('bavix'));
    }

    public function testLcFirst()
    {
        $this->assertSame('bavix', Str::lcFirst('Bavix'));
    }

    public function testRandom()
    {
        $this->assertRegExp('~[a-zA-Z]{32}~', Str::random(32, Str::RAND_ALPHA));
        $this->assertNotRegExp('~[^a-zA-Z]{32}~', Str::random(32, Str::RAND_ALPHA));

        $this->assertRegExp('~[a-zA-Z]{32}~', Str::random(32, Str::RAND_ALPHA_LOW | Str::RAND_ALPHA_HIGH));
        $this->assertNotRegExp('~[^a-zA-Z]{32}~', Str::random(32, Str::RAND_ALPHA_LOW | Str::RAND_ALPHA_HIGH));

        $this->assertRegExp('~[A-Z]{32}~', Str::random(32, Str::RAND_ALPHA_HIGH));
        $this->assertNotRegExp('~[^A-Z]{32}~', Str::random(32, Str::RAND_ALPHA_HIGH));

        $this->assertRegExp('~[a-z]{32}~', Str::random(32, Str::RAND_ALPHA_LOW));
        $this->assertNotRegExp('~[^a-z]{32}~', Str::random(32, Str::RAND_ALPHA_LOW));

        $this->assertRegExp('~[0-9]{32}~', Str::random(32, Str::RAND_DIGITS));
        $this->assertNotRegExp('~[^0-9]{32}~', Str::random(32, Str::RAND_DIGITS));

        $this->assertRegExp('~[a-zA-Z0-9]{32}~', Str::random());
        $this->assertNotRegExp('~[^a-zA-Z0-9]{32}~', Str::random());
    }

    /**
     * @expectedException \Bavix\Exceptions\Blank
     */
    public function testRandomBlank()
    {
        Str::random(32, 0);
    }

    public function testUniqid()
    {
        $this->assertRegExp('~\w+\.\w+~', Str::uniqid());
    }

    public function testFileSize()
    {
        $this->assertEquals(Str::fileSize(986), '986.00 B');
        $this->assertEquals(Str::fileSize(1024), '1.00 KB');
        $this->assertEquals(Str::fileSize(1036), '1.01 KB');
        $this->assertEquals(Str::fileSize(1036 * 1024), '1.01 MB');
        $this->assertEquals(Str::fileSize(1036 * 1024 * 1024), '1.01 GB');
    }

    /**
     * @expectedException \Bavix\Exceptions\Invalid
     */
    public function testFileSizeInvalid()
    {
        Str::fileSize(-1);
    }

    public function testTranslit()
    {
        // reflection, get property
        $ref = new \ReflectionClass(Str::class);
        $prop = $ref->getProperty('trans');
        $prop->setAccessible(true);
        // end reflection

        $data = $prop->getValue();

        $keysString = \implode(' ', Arr::getKeys($data));
        $valsString = \implode(' ', Arr::getValues($data));

        $this->assertSame($valsString, Str::translit($keysString));
    }

    public function testCapitalize()
    {
        $this->assertSame('Hello World', Str::capitalize('hello world'));
    }

    public function testCamelCase()
    {
        $this->assertSame('helloWorld', Str::camelCase('hello_world'));
        $this->assertSame('helloWorld', Str::camelCase('Hello_world', '_', true));
    }

    public function testSnakeCase()
    {
        $this->assertSame('hello_world', Str::snakeCase('HelloWorld'));
    }

    public function testFriendlyURL()
    {
        $this->assertSame('privet-mir', Str::friendlyUrl('привет мир'));
        $this->assertSame('privetMir', Str::friendlyUrl('привет мир', true, Str::CAMEL_CASE));

        $this->assertSame('привет-мир', Str::friendlyUrl('привет мир', false));
        $this->assertSame('приветМир', Str::friendlyUrl('привет мир', false, Str::CAMEL_CASE));
    }

    public function testToNumber()
    {
        $this->assertSame('12345', Str::toNumber('hello1a2v3b4b5'));
    }

    public function testPos()
    {
        $this->assertSame(
            Str::pos('hello', 'e'),
            \strpos('hello', 'e')
        );
    }

    public function testRepeat()
    {
        $this->assertSame(
            Str::repeat('abc', 3),
            \str_repeat('abc', 3)
        );
    }

    public function testShuffle()
    {
        $string = 'hello world' . Str::random();
        $shuffle = Str::shuffle($string);

        $this->assertRegExp(
            '~[' . $string . ']{' . Str::len($string) . '}~',
            $shuffle
        );

        $this->assertNotSame(
            $string,
            $shuffle
        );
    }

}
