<?php

namespace Tests;

use Bavix\Helpers\Arr;
use Bavix\Tests\Unit;

class ArrTest extends Unit
{

    protected $callback;
    protected $numbers;

    public function setUp()
    {
        parent::setUp();

        $this->callback = function ($a, $key = null) {
            return $key ? $key % $a : $a % 2;
        };

        $this->numbers = range(0, 100);
    }

    protected function clone()
    {
        $numbers = [];

        foreach ($this->numbers as $key => $number)
        {
            $numbers[$key] = $number;
        }

        return $numbers;
    }

    public function testWalkRecursive()
    {
        $data1 = $this->clone();
        $data2 = $this->clone();

        Arr::walkRecursive($data1, $this->callback);
        \array_walk_recursive($data2, $this->callback);

        $this->assertArraySubset($data1, $data2);
    }

    public function testFilter()
    {
        $this->assertArraySubset(
            Arr::filter($this->numbers, $this->callback),
            \array_filter($this->numbers, $this->callback, ARRAY_FILTER_USE_BOTH)
        );
    }

    public function testMap()
    {
        $this->assertArraySubset(
            Arr::map($this->numbers, $this->callback),
            \array_map($this->callback, $this->numbers)
        );
    }

    public function testSlice()
    {
        $randInt = \random_int(0, count($this->numbers) - 1);

        $this->assertArraySubset(
            Arr::slice($this->numbers, 1, $randInt),
            \array_slice($this->numbers, 1, $randInt)
        );
    }

    public function testMerge()
    {
        $this->assertArraySubset(
            Arr::merge($this->numbers, $this->numbers, $this->numbers),
            \array_merge($this->numbers, $this->numbers, $this->numbers)
        );
    }

    public function testFill()
    {
        $this->assertArraySubset(
            Arr::fill('value', 10),
            \array_fill(0, 10, 'value')
        );

        $this->assertArraySubset(
            Arr::fill('value1', 10, 5),
            \array_fill(5, 10, 'value1')
        );
    }

    public function testRange()
    {
        $this->assertArraySubset(
            Arr::range(0, 1000),
            range(0, 1000)
        );

        $this->assertArraySubset(
            Arr::range('a', 'z'),
            range('a', 'z')
        );
    }

    public function testInArray()
    {
        $this->assertTrue(Arr::in($this->numbers, 10));
        $this->assertFalse(Arr::in($this->numbers, count($this->numbers)));
    }

    public function testShuffle()
    {
        $data = $this->clone();
        Arr::shuffle($data);

        $check = true;

        foreach ($data as $key => $item)
        {
            if ($item !== $this->numbers[$key])
            {
                $check = false;
                break;
            }
        }

        $this->assertFalse($check);
    }

    public function testSet()
    {
        $num = $this->numbers[0];
        Arr::set($this->numbers, 0, $num - 1000);
        $this->assertNotSame($num, $this->numbers[0]);

        Arr::set($this->numbers, 'a.b.c.d', true);
        $this->assertTrue($this->numbers['a']['b']['c']['d']);

        $this->assertTrue(Arr::get($this->numbers, 'a.b.c.d'));
        $this->assertTrue(Arr::get($this->numbers, 'a[b][c][d]'));
    }

    public function testRemove()
    {
        $ind = count($this->numbers) - 1;
        Arr::remove($this->numbers, $ind);
        $this->assertFalse(isset($this->numbers[$ind]));
    }

    public function testGetRequired()
    {
        $this->assertEquals(Arr::getRequired($this->numbers, 0), 0);
    }

    /**
     * @expectedException \Bavix\Exceptions\NotFound\Path
     */
    public function testGetRequiredPath()
    {
        Arr::getRequired($this->numbers, __FUNCTION__);
    }

    /**
     * @expectedException \Bavix\Exceptions\Blank
     */
    public function testGetRequiredBlank()
    {
        Arr::getRequired($this->numbers, '.hello');
    }

    public function testPush()
    {
        $data = $this->clone();

        $res1 = Arr::push($data, 'value');
        $res2 = \array_push($this->numbers, 'value');

        $this->assertSame($res1, $res2);

        $this->assertArraySubset($data, $this->numbers);
    }

    public function testPop()
    {
        $data = $this->clone();

        Arr::pop($data);
        Arr::pop($this->numbers);

        $this->assertArraySubset($data, $this->numbers);
    }

    public function testUnShift()
    {
        $data = $this->clone();

        $res1 = Arr::unShift($data, 'value');
        $res2 = \array_unshift($this->numbers, 'value');

        $this->assertSame($res1, $res2);

        $this->assertArraySubset($data, $this->numbers);
    }

    public function testShift()
    {
        $data = $this->clone();

        Arr::shift($data);
        Arr::shift($this->numbers);

        $this->assertArraySubset($data, $this->numbers);
    }

    public function testGet()
    {
        $this->assertSame(Arr::get($this->numbers, 0), Arr::at($this->numbers, 0));

        $this->assertNotNull(Arr::get($this->numbers, 0));
        $this->assertNull(Arr::get($this->numbers, 'a'));
    }

    protected function asGenerator()
    {
        foreach ($this->numbers as $key => $item)
        {
            yield $key => $item;
        }
    }

    public function testIterator()
    {
        $this->assertArraySubset(
            Arr::iterator($this->asGenerator()),
            \iterator_to_array($this->asGenerator())
        );
    }

    public function testKeys()
    {
        $this->assertArraySubset(
            Arr::getKeys($this->numbers),
            \array_keys($this->numbers)
        );
    }

    public function testInitOrPush()
    {
        $data = $this->clone();

        foreach ($data as $datum)
        {
            Arr::initOrPush($this->numbers, 'test', $datum);
        }

        $this->assertArraySubset(
            $data,
            Arr::get($this->numbers, 'test')
        );
    }

}
