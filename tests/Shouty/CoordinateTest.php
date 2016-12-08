<?php

namespace Shouty;

use PHPUnit\Framework\TestCase;
use Shouty\Coordinate;

class CoordinateTest extends TestCase
{
    public function testItCalculatesTheDistanceFromAnotherCoordinateAlongXAxis()
    {
        $a = new Coordinate(0, 0);
        $b = new Coordinate(1000, 0);
        $this->assertEquals(1000, $a->distanceFrom($b));
    }

    public function testItCalculatesTheDistanceFromAnotherCoordinateAlongYAxis()
    {
        $a = new Coordinate(0, 200);
        $b = new Coordinate(0, 500);
        $this->assertEquals(300, $a->distanceFrom($b));
    }

}
