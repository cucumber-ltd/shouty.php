<?php

namespace Shouty;

class Person {
    private $network;
    private $heardMessages = array();
    private $geoLocation;

    function __construct($network) {
        $this->network = $network;
        $network->subscribe($this);
    }

    function setGeoLocation($geoLocation) {
        $this->geoLocation = $geoLocation;
    }

    function shout($message) {
        $this->network->broadcast($message, $this->geoLocation);
    }

    function hear($message) {
        array_push($this->heardMessages, $message);
    }

    function getHeardMessages() {
        return $this->heardMessages;
    }

    function getLocation() {
        return $this->geoLocation;
    }
}

class Network {
    private $people = array();

    function broadcast($message, $shouterLocation) {
        foreach($this->people as $listener) {
            $isSamePerson = $listener->getLocation() == $shouterLocation;
            $withinRange = $this->isWithinRange($shouterLocation, $listener->getLocation());
            if($withinRange && !$isSamePerson) {
                $listener->hear($message);
            }
        }
    }

    function subscribe($person) {
        array_push($this->people, $person);
    }

    private function isWithinRange($loc1, $loc2) {
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
    }}

class Shouty {
    private $people = array();
    private $network;

    function __construct() {
        $this->network = new Network();
    }

    function setPersonLocation($personName, $geoLocation) {
        $this->findOrCreate($personName)->setGeoLocation($geoLocation);
    }

    function personShouts($personName, $messageText) {
        $this->findOrCreate($personName)->shout($messageText);
    }

    function heardMessages($personName) {
        return $this->findOrCreate($personName)->getHeardMessages();
    }

    private function findOrCreate($personName) {
        if(array_key_exists($personName, $this->people)) {
            return $this->people[$personName];
        }
        return $this->people[$personName] = new Person($this->network);
    }
}
