<?php

namespace Tests;

use Bavix\Helpers\Dir;
use Bavix\Tests\Unit;

class DirTest extends Unit
{

    public function testIsDirectory()
    {
        $this->assertTrue(Dir::isDir('/tmp'));
    }

    public function testMakeAndRemove()
    {
        $directory = '/tmp/bavix' . __FUNCTION__;
        $this->assertTrue(Dir::make($directory . '/data'));

        file_put_contents($directory . '/file', __FILE__);
        $this->assertTrue(Dir::remove($directory, true));
    }

}
