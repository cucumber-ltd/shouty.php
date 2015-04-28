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

    public function __construct() {
        $this->shouty = new Shouty();
    }

    /**
     * @Given :arg1 is at :arg2
     */
    public function isAt($arg1, $arg2)
    {
        throw new PendingException();
    }

    /**
     * @When :arg1 shouts
     */
    public function shouts($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then :arg1 doesn't hear the message
     */
    public function doesnTHearTheMessage($arg1)
    {
        throw new PendingException();
    }
}
