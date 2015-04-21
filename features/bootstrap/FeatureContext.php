<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use PHPUnit_Framework_Assert as PHPUnit;

class Shouty {
    public function personIsIn($personName, $location) {

    }

    public function personShouts($personName, $message) {

    }

    public function heardBy($personName) {
        return [];
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
     * @Given /(\w+) is in (.+)/
     */
    public function personIsInLocation($personName, $locationName)
    {
        $location = $this->locations[$locationName];
        $this->shouty->personIsIn($personName, $location);
    }

    /**
     * @When /(\w+) shouts/
     */
    public function personShouts($personName)
    {
        $this->shouty->personShouts($personName, 'Can you hear me?');
    }

    /**
     * @Then /(\w+) should not hear anything/
     */
    public function personShouldNotHearAnything($personName)
    {
        PHPUnit::assertEquals([], $this->shouty->heardBy($personName));
    }

}
