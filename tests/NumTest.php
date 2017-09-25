<?php

namespace Tests;

use Bavix\Helpers\Num;
use Bavix\Tests\Unit;

class NumTest extends Unit
{

    protected $number;

    protected function setUp()
    {
        parent::setUp();

        $this->number = 123456789;
    }

    public function testFormat()
    {
        $this->assertSame(
            Num::format($this->number),
            \number_format($this->number)
        );
    }

    public function testRandomInt()
    {
        $this->assertSame(Num::randomInt(1, 1), 1);
        $this->assertTrue(is_int(Num::randomInt()));
    }

}
