<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use \Behat\Mink\Driver\GoutteDriver;
use \Behat\Mink\Session;

use PHPUnit_Framework_Assert as PHPUnit;

class WebContext implements Context, SnippetAcceptingContext {
    private $locations = [];
    private $session;

    public function __construct() {
        $driver = new GoutteDriver();
        $this->session = new Session($driver);
        $this->session->start();
    }

    /**
     * @BeforeScenario
     */
    public function before() {
        if(file_exists('store')) { unlink('store'); }
    }

    /**
     * @Given the following locations:
     */
    public function theFollowingLocations(TableNode $locations) {
        foreach ($locations->getHash() as $location) {
            $this->locations[$location['name']] = [doubleval($location['lat']), doubleval($location['lon'])];
        }
    }
}
