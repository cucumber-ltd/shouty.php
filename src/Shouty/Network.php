<?php

namespace Shouty;

class Network {
    private $people = [];

    public function subscribe($person) {
        array_push($this->people, $person);
    }

    public function broadcast($message, $shoutLocation) {
        foreach($this->people as $listener) {
          if($this->withinRange($shoutLocation, $listener->getLocation())) {
              $listener->hear($message);
          }
        }
    }

    private function withinRange($loc1, $loc2) {
        $dist = $this->haversine($loc1[0], $loc1[1], $loc2[0], $loc2[1], 6371000);
        return $dist <= 1000;
    }

    // http://www.movable-type.co.uk/scripts/latlong.html
    private function haversine($lat1, $lon1, $lat2, $lon2, $r) {
      $theta1  = deg2rad($lat1);
      $theta2  = deg2rad($lat2);
      $dTheta  = deg2rad($lat2 - $lat1);
      $dLambda = deg2rad($lon2 - $lon1);

      $a = sin($dTheta / 2) * sin($dTheta / 2) +
           cos($theta1) * cos($theta2) *
           sin($dLambda / 2) * sin($dLambda / 2);
      $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
      $dist = $r * $c;
      return $dist;
    }
}
