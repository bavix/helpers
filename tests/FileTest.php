<?php

namespace Tests;

use Bavix\Helpers\File;
use Bavix\Tests\Unit;

class FileTest extends Unit
{

    protected $directory;

    public function testPut()
    {
        File::put($this->tmp, __FUNCTION__);
        $this->assertStringEqualsFile((string)$this->tmp, __FUNCTION__);
    }

    public function testIsReadable()
    {
        $this->assertTrue(File::isReadable($this->tmp));
    }

    public function testIsWritable()
    {
        $this->assertTrue(File::isWritable($this->tmp));
    }

    public function testOpen()
    {
        $this->assertTrue(is_resource(File::open($this->tmp)));
    }

    public function testClose()
    {
        $handle = File::open($this->tmp);
        $this->assertTrue(File::close($handle));
    }

    public function testTouch()
    {
        $time = \time();

        $this->assertTrue(File::touch($this->tmp, $time - 3600, $time - 60));
        $this->assertSame(filemtime($this->tmp), $time - 3600);
        $this->assertSame(fileatime($this->tmp), $time - 60);
    }

    public function testReal()
    {
        $this->assertSame(
            File::real($this->tmp),
            \realpath($this->tmp)
        );
    }

    public function testRemove()
    {
        $this->assertTrue(File::remove($this->tmp));
    }

    public function testSize()
    {
        \file_put_contents($this->tmp, __METHOD__);

        $this->assertSame(
            File::size($this->tmp),
            \filesize($this->tmp)
        );
    }

    public function testExists()
    {
        $this->assertTrue(File::exists($this->tmp));
    }

    public function testIsFile()
    {
        $this->assertTrue(File::isFile($this->tmp));
    }

    public function testSymlink()
    {
        $link = $this->tmp . '.link';
        File::symlink($this->tmp, $link);
        $this->assertTrue(File::isLink($link));
    }

}
