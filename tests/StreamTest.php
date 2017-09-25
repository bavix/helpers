<?php

namespace Tests;

use Bavix\Helpers\Stream;
use Bavix\Tests\Unit;

class StreamTest extends Unit
{

    public function testDownload()
    {
        Stream::download(__FILE__, $this->tmp);
        $this->assertFileEquals((string)$this->tmp, __FILE__);
    }

    /**
     * @expectedException \Bavix\Exceptions\NotFound\Path
     */
    public function testStreamNotFoundPath()
    {
        Stream::download('failed', $this->tmp);
    }

    /**
     * @expectedException \Bavix\Exceptions\PermissionDenied
     */
    public function testStreamPermissionDenied()
    {
        Stream::download(__FILE__, '/root/' . __FILE__);
    }

}
