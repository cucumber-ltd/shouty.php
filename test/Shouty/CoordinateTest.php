<?php

namespace Shouty;

require_once 'src/Shouty/Shouty.php';
require_once 'src/Shouty/Coordinate.php';

use PHPUnit\Framework\TestCase;
use Shouty\Coordinate;

class CoordinateTest extends TestCase
{
  public function testItCalculatesTheDistanceFromAnotherCoordinateAlongXAxis() {
        $a = new Coordinate(0, 0);
        $b = new Coordinate(1000, 0);
        $this->assertEquals(1000, $a->distanceFrom($b));
    }
}
