<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use PHPUnit_Framework_Assert as PHPUnit;

use Shouty\Shouty;
use Shouty\Coordinate;

class FeatureContext implements Context, SnippetAcceptingContext
{
    const ARBITRARY_MESSAGE = 'Hello, world';
    private $shouty;

    public function __construct($shouty)
    {
        $this->shouty = $shouty;
    }


    /**
     * @When :shouterName shouts
     */
    public function shouterShouts($shouterName)
    {
        $this->shouty->shout($shouterName, self::ARBITRARY_MESSAGE);
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

    /**
     * @Then :listenerName should not hear :shouterName
     */
    public function listenerShouldNotHearShouter($listenerName, $shouterName)
    {
        $messages = $this->shouty->getMessagesHeardBy($listenerName);

        PHPUnit::assertFalse(array_key_exists($shouterName, $messages), "Did not expect to hear: " . $shouterName . ", but did!");
    }

    /**
     * @Then :listenerName should hear :countOfShouts shouts from :shouterName
     */
    public function lucyShouldHearShoutsFromSean($countOfShouts, $listenerName, $shouterName)
    {
        $messages = $this->shouty->getMessagesHeardBy($listenerName);
        $messagesByShouter = $messages[$shouterName];

        PHPUnit::assertEquals(intval($countOfShouts), count($messagesByShouter));
    }
}
