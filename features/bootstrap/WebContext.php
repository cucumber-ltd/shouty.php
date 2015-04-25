<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use \Behat\Mink\Driver\GoutteDriver;
use \Behat\Mink\Session;

use PHPUnit_Framework_Assert as PHPUnit;

// https://github.com/jakzal/RestExtension/blob/master/features/bootstrap/PhpServerContext.php
// https://github.com/ciaranmcnulty/behat-localwebserverextension

/**
 * Defines application features from the specific context.
 */
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

    /**
     * @Given /^(\w+) is in (.+)$/
     */
    public function personIsInLocation($personName, $locationName) {
        $location = $this->locations[$locationName];
        $this->session->visit('http://localhost:8000/people/' . $personName . '?lat=' . $location[0] . '&lon=' . $location[1]);
    }

    /**
     * @When /^(\w+) shouts$/
     */
    public function personShouts($personName) {
        $this->session->visit('http://localhost:8000/people/' . $personName);
        $this->session->getPage()->find('css', '#message')->setValue('Can you hear me?');
        $this->session->getPage()->find('css', '#shout')->press();
    }

    /**
     * @When /^(\w+) shouts "(.*)"$/
     */
    public function personShoutsMessage($personName, $message) {
        $this->session->visit('http://localhost:8000/people/' . $personName);
        $this->session->getPage()->find('css', '#message')->setValue($message);
        $this->session->getPage()->find('css', '#shout')->press();
    }

    /**
     * @Then /^(\w+) should not hear anything$/
     */
    public function personShouldNotHearAnything($personName) {
        $this->session->visit('http://localhost:8000/people/' . $personName);
        $lis = $this->session->getPage()->findAll('css', '#messages li');
        $heardMessages = array_map(function($li) { return $li->getText(); }, $lis);
        PHPUnit::assertEquals([], $heardMessages);
    }

    /**
     * @Then /^(\w+) should hear "(.*)"$/
     */
    public function personShouldHearMessage($personName, $expectedMessage) {
        $this->session->visit('http://localhost:8000/people/' . $personName);
        $lis = $this->session->getPage()->findAll('css', '#messages li');
        $heardMessages = array_map(function($li) { return $li->getText(); }, $lis);
        PHPUnit::assertEquals([$expectedMessage], $heardMessages);
    }
}
