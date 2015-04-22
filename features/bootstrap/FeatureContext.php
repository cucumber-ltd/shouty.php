<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use PHPUnit_Framework_Assert as PHPUnit;

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

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    private $locations = [];
    private $shouty;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->shouty = new Shouty();
    }

    /**
     * @Given the following locations:
     */
    public function theFollowingLocations(TableNode $locations)
    {
        foreach ($locations->getHash() as $location) {
            $this->locations[$location['name']] = [doubleval($location['lat']), doubleval($location['lon'])];
        }
    }

    /**
     * @Given /^(\w+) is in (.+)$/
     */
    public function personIsInLocation($personName, $locationName)
    {
        $location = $this->locations[$locationName];
        $this->shouty->personIsIn($personName, $location);
    }

    /**
     * @When /^(\w+) shouts$/
     */
    public function personShouts($personName)
    {
        $this->shouty->personShouts($personName, 'Can you hear me?');
    }

    /**
     * @When /^(\w+) shouts "(.*)"$/
     */
    public function personShoutsMessage($personName, $message)
    {
        $this->shouty->personShouts($personName, $message);
    }

    /**
     * @Then /^(\w+) should not hear anything$/
     */
    public function personShouldNotHearAnything($personName)
    {
        PHPUnit::assertEquals([], $this->shouty->heardBy($personName));
    }

    /**
     * @Then /^(\w+) should hear "(.*)"$/
     */
    public function personShouldHearMessage($personName, $expectedMessage)
    {
        PHPUnit::assertEquals([$expectedMessage], $this->shouty->heardBy($personName));
    }
}
