<?php

namespace Tests;

use Bavix\Helpers\JSON;
use Bavix\Tests\Unit;

class JsonTest extends Unit
{

    protected $data;

    protected function setUp()
    {
        parent::setUp();

        $this->data = [
            'foo' => 'bar',
            'bar' => 'foo',
            'data' => [
                'foo' => 'bar',
                'bar' => 'foo',
                'data' => [
                    'foo' => 'bar',
                    'bar' => 'foo',
                ]
            ]
        ];
    }

    public function testEncode()
    {
        $this->assertJson(JSON::encode($this->data));
    }

    public function testEncodeTraversable()
    {
        $obj = new \ArrayObject($this->data);
        $this->assertJson(JSON::encode($obj));
    }

    public function testDecode()
    {
        $this->assertArraySubset(
              $this->data,
              JSON::decode(JSON::encode($this->data))
        );
    }

}
