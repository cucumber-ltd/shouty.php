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

    /**
     * @Given /^(\w+) is in (.+)$/
     */
    public function personIsInLocation($personName, $locationName) {
        $location = $this->locations[$locationName];
        $this->session->visit(
          'http://localhost:8000/people/' .
          $personName .
          '?lat=' . $location[0] .
          '&lon=' . $location[1]
        );
    }

    /**
     * @When /^(\w+) shouts "(.*)"$/
     */
    public function personShoutsMessage($personName, $message) {
        $this->session->visit('http://localhost:8000/people/' . $personName);
        $page = $this->session->getPage();
        $page->findById('message')->setValue($message);
        $page->findById('shout')->press();
    }

    /**
     * @When /^(\w+) shouts$/
     */
    public function personShouts($personName) {
      $this->personShoutsMessage($personName, 'some message');
    }

    /**
     * @Then /^(\w+) should hear "(.*)"$/
     */
    public function personShouldHearMessage($personName, $expectedMessage) {
        PHPUnit::assertEquals(
          [$expectedMessage],
          $this->getMessagesForPerson($personName)
        );
    }

    /**
     * @Then /^(\w+) should not hear anything$/
     */
    public function personShouldNotHearAnything($personName) {
        PHPUnit::assertEquals(
          [],
          $this->getMessagesForPerson($personName)
        );
    }

    private function getMessagesForPerson($personName) {
        $this->session->visit('http://localhost:8000/people/' . $personName);
        $page = $this->session->getPage();
        $lis = $page->findAll('css', "#messages li");
        $heardMessages = array_map(function($li) { return $li->getText(); }, $lis);
        return $heardMessages;
    }
}
