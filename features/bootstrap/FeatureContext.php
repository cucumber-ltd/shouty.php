<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use PHPUnit_Framework_Assert as PHPUnit;

require_once 'src/Shouty/Shouty.php';
use Shouty\Shouty;

class FeatureContext implements Context, SnippetAcceptingContext {
    private $shouty;
    private $locations = array(
      "St John's College" => [51.756073, -1.25904],
      "Trafalgar Square" => [51.508039, -0.128069]
    );

    public function __construct() {
        $this->shouty = new Shouty();
    }

    /**
     * @Given :personName is at :locationName
     */
    public function personIsAt($personName, $locationName)
    {
        $geoLocation = $this->locations[$locationName];
        $this->shouty->setPersonLocation($personName, $geoLocation);
    }

    /**
     * @When :personName shouts
     */
    public function personShouts($personName)
    {
        $this->shouty->personShouts($personName, 'Anyone around?');
    }

    /**
     * @Then :arg1 doesn't hear anything
     */
    public function personDoesntHearAnything($personName)
    {
        PHPUnit::assertEquals(array(), $this->shouty->heardMessages($personName));
    }
}
