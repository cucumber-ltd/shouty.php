<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use PHPUnit_Framework_Assert as PHPUnit;

use Shouty\Shouty;
use Shouty\Coordinate;

class FeatureContext implements Context, SnippetAcceptingContext {
    const ARBITRARY_MESSAGE = 'Hello, world';
    private $shouty;

    public function __construct() {
        $this->shouty = new Shouty();
    }

    /**
     * @Given Lucy is at [:xCoord, :yCoord]
     */
    public function lucyIsAt($xCoord, $yCoord)
    {
      $this->shouty->setLocation("Lucy", new Coordinate($xCoord, $yCoord));
    }

    /**
     * @Given Sean is at [:xCoord, :yCoord]
     */
    public function seanIsAt($xCoord, $yCoord)
    {
      $this->shouty->setLocation("Sean", new Coordinate($xCoord, $yCoord));
    }

    /**
     * @When Sean shouts
     */
    public function seanShouts()
    {
        $this->shouty->shout("Sean", self::ARBITRARY_MESSAGE);
    }

    /**
     * @Then Lucy should hear Sean
     */
    public function lucyShouldHearSean()
    {
        PHPUnit::assertEquals(1, count($this->shouty->getMessagesHeardBy("Lucy")));
    }

    /**
     * @Then Lucy should hear nothing
     */
    public function lucyShouldHearNothing()
    {
        PHPUnit::assertEquals(0, count($this->shouty->getMessagesHeardBy("Lucy")));
    }
}
