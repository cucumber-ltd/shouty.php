<?php

namespace Shouty;

class Person {
    private $location;
    private $network;
    private $messagesHeard = [];

    public function __construct($network) {
        $this->network = $network;
        $network->subscribe($this);
    }

    public function isIn($location) {
        $this->location = $location;
    }

    public function getLocation() {
        return $this->location;
    }

    public function shout($message) {
        $this->network->broadcast($message, $this->location);
    }

    public function hear($message) {
        array_push($this->messagesHeard, $message);
    }

    public function messagesHeard() {
        return $this->messagesHeard;
    }
}
