<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\Pending;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

   require_once 'PHPUnit/Autoload.php';
   require_once 'PHPUnit/Framework/Assert/Functions.php';


/**
 * Panorama-PHP test suite context.
 *
 * @author     Fran Dieguez <fran@openhost.es>
 */
class FeatureContext extends BehatContext
{

    /**
    * Last runned command name.
    *
    * @var string
    */
    private $command;
    /**
    * Last runned command output.
    *
    * @var string
    */
    private $output;
    /**
    * Last runned command return code.
    *
    * @var integer
    */
    private $return;

    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param   array   $parameters     context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {

    }

    /**
     * @Given /^The url (.+)$/
     */
    public function theUrl($url)
    {
        throw new Pending();
        $this->video = new \Panorama\Video($url);
    }

    /**
     * @When /^I get the (.+)$/
     */
    public function getProperty($arg="")
    {
        switch ($method) {
            case 'title':
                $this->result = $this->video->getTitle();
                break;

            case 'thumbnail':
                $this->result = $this->video->getThumbnail();
                break;

            case 'duration':
                $this->result = $this->video->getDuration();
                break;

            case 'download url':
                $this->result = $this->video->getDownloadUrl();
                break;

            case 'embed':
                $this->result = $this->video->getEmbedUrl();
                break;

            case 'embedHTML':
                $this->result = $this->video->getEmbedHTML(array());
                break;

            case 'service name':
                $this->result = $this->video->getService();
                break;

            case 'FLV url':
                $this->result = $this->video->getFLV();
            break;

            default:
                throw new Behat\Behat\Exception\Pending("not implemented");

        }
    }

    /**
     * @Then /^The result should be "([^"]*)"$/
     */
    public function theResultShouldBe($argument1)
    {
        throw new Pending();
    }

    /**
     * @Then /^The result should be:$/
     *
     * @param   Behat\Gherkin\Node\PyStringNode $text   PyString text instance
     */
    public function theResultShouldBeStringBlock(PyStringNode $text)
    {
        throw new Pending();
    }

}
