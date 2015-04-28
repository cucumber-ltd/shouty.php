<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
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
}
