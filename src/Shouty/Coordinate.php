<?php

namespace Shouty;

class Coordinate
{
    private $x;
    private $y;

    public function __construct($xCoord, $yCoord)
    {
        $this->x = $xCoord;
        $this->y = $yCoord;
    }

    public function distanceFrom($other)
    {
        $xSquared = pow($other->x - $this->x, 2);
        $ySquared = pow($other->y - $this->y, 2);

        return sqrt($xSquared + $ySquared);
    }
}
