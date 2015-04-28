<?php

namespace Shouty;

class Person {
    private $network;
    private $heardMessages = array();

    function __construct($network) {
        $this->network = $network;
        $network->subscribe($this);
    }

    function setGeoLocation($geoLocation) {
        $this->geoLocation = $geoLocation;
    }

    function shout($message) {
        $this->network->broadcast($message);
    }

    function hear($message) {
        array_push($this->heardMessages, $message);
    }

    function getHeardMessages() {
        return $this->heardMessages;
    }
}

class Network {
    private $people = array();

    function broadcast($message) {
        foreach($this->people as $listener) {
            $listener->hear($message);
        }
    }

    function subscribe($person) {
        array_push($this->people, $person);
    }
}

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
