<?php

namespace Tests;

use Bavix\Helpers\PregMatch;
use Bavix\Helpers\Results\PregObject;
use Bavix\Tests\Unit;

class PregMatchTest extends Unit
{

    public function testFirst()
    {
        $pregObject = PregMatch::first('~(?P<d>\w+)~', 'hello world');

        $this->assertTrue(isset($pregObject->result));
        $this->assertEquals($pregObject->result, 1);
        $this->assertArraySubset($pregObject->matches, [
            0   => 'hello',
            'd' => 'hello',
            1   => 'hello',
        ]);
    }

    public function testAll()
    {
        $pregObject = new PregObject(PREG_PATTERN_ORDER);
        PregMatch::all('~(?P<d>\w+)~', 'hello world', $pregObject);

        $this->assertTrue(isset($pregObject->result));
        $this->assertEquals($pregObject->result, 2);
        $this->assertArraySubset($pregObject->matches, [
            0   => ['hello', 'world'],
            'd' => ['hello', 'world'],
            1   => ['hello', 'world'],
        ]);
    }

}
