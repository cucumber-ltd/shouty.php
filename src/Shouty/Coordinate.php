<?php

namespace Shouty;

class Coordinate {
  private $x;
  private $y;

  public function __construct($xCoord, $yCoord) {
    $this->x = $xCoord;
    $this->y = $yCoord;
  }

  public function distanceFrom($other) {
    return 0;
  }
}
