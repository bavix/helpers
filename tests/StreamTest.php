<?php

namespace Tests;

use Bavix\Helpers\Stream;
use Bavix\Tests\Unit;
use Bavix\Tests\Tmp;

class StreamTest extends Unit
{

    public function testDownload()
    {
        $tmp = new Tmp();
        Stream::download(__FILE__, $tmp);
        $this->assertFileEquals((string)$tmp, __FILE__);
    }

    /**
     * @expectedException \Bavix\Exceptions\NotFound\Path
     */
    public function testStreamNotFoundPath()
    {
        $tmp = new Tmp();
        Stream::download('failed', $tmp);
    }

    /**
     * @expectedException \Bavix\Exceptions\PermissionDenied
     */
    public function testStreamPermissionDenied()
    {
        Stream::download(__FILE__, '/root/' . __FILE__);
    }

}
