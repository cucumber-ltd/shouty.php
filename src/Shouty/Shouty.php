<?php

namespace Shouty;

require_once 'src/Shouty/Network.php';
require_once 'src/Shouty/Person.php';

class Shouty {
    private $people = [];
    private $network;

    public function __construct() {
        $this->network = new Network();
    }

    public function personIsIn($personName, $location) {
        $this->person($personName)->isIn($location);
    }

    public function personShouts($personName, $message) {
        $this->person($personName)->shout($message);
    }

    public function heardBy($personName) {
        return $this->person($personName)->messagesHeard();
    }

    private function person($personName) {
        if(array_key_exists($personName, $this->people)) {
            return $this->people[$personName];
        }
        return $this->people[$personName] = new Person($this->network);
    }
}
