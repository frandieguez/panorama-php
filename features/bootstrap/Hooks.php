<?php

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\Pending;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Symfony\Component\ClassLoader\UniversalClassLoader;

class Hooks extends BehatContext
{
    /**
     * @BeforeSuite
     */
    public static function doSomethingBeforeSuite()
    {
        set_include_path(
            realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." )
            .PATH_SEPARATOR
            .get_include_path()
        );
    }

    /**
     * @BeforeScenario
     */
    public function beforeScen()
    {
        // do something before each scenario
    }

    /**
     * @BeforeScenario @rest-fixtures
     */
    public function loadFixtures()
    {
        // do something before each scenario with @rest-fixtures tag
    }
}
