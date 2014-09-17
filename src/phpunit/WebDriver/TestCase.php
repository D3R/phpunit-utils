<?php

namespace D3R\PHPUnit\WebDriver;

use D3R\PHPUnit\WebDriver\Connection;

/**
 * Base TestCase for WebDriver tests
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R\PHPUnit\WebDriver
 */
abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Parameters for the selenium webdriver connection
     *
     * @var array
     */
    private $parameters = array();

    /**
     * The webdriver connection
     *
     * @var RemoteWebDriver
     */
    private $driver = false;

    /**
     * Class constructor
     *
     * @param string $name
     * @param array $data
     * @param string $dataName
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->parameters = array(
                'host'       => 'http://localhost',
                'port'       => '4444',
                'path'       => '/wd/hub',
                'browser'    => false,
                'defaultHost'=> false
            );
    }

    /**
     * {@inheritdoc}. Close the webdriver connection.
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function tearDown()
    {
        $this->getDriver()->close();
    }

    /**
     * Set the selenium host
     *
     * @param string $host
     * @return $this
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function setHost($host)
    {
        if ('http://' != substr($host, 0, 7) && 'https://' != substr($host, 0, 8)) {
            $host = 'http://' . $host;
        }
        $this->parameters['host'] = $host;

        return $this;
    }

    /**
     * Get the selenium host
     *
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function getHost()
    {
        return $this->parameters['host'];
    }

    /**
     * Set the selenium port
     *
     * @param int $port
     * @return $this
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function setPort($port)
    {
        $this->parameters['port'] = $port;

        return $this;
    }

    /**
     * Get the selenium port
     *
     * @return int
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function getPort()
    {
        return $this->parameters['port'];
    }

    /**
     * Set the path to the selenium web driver api
     *
     * @param string $path
     * @return $this
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function setPath($path)
    {
        $this->parameters['path'] = $path;

        return $this;
    }

    /**
     * Get the path to the selenium web driver api
     *
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function getPath()
    {
        return $this->parameters['path'];
    }

    /**
     * Set the browser string
     *
     * @param string $browser
     * @return $this
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function setBrowser($browser)
    {
        $this->parameters['browser'] = $browser;

        return $this;
    }

    /**
     * Get the browser string
     *
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function getBrowser()
    {
        return $this->parameters['browser'];
    }

    /**
     * Set the default host to use for this test case
     *
     * @param string $host
     * @return $this
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function setDefaultHost($defaultHost)
    {
        $this->parameters['defaultHost'] = $defaultHost;

        return $this;
    }

    /**
     * Get the default host to use for this test case
     *
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function getDefaultHost()
    {
        return $this->parameters['defaultHost'];
    }

    /**
     * Get the connection url for this test case
     *
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function getConnectionUrl()
    {
        return $this->getHost() . ':' . $this->getPort() . $this->getPath();
    }

    /**
     * Get the browser capabilities array
     *
     * @return array
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function getCapabilities()
    {
        $capabilities = new \DesiredCapabilities();
        $capabilities->setBrowserName($this->getBrowser());

        return $capabilities;
    }

    /**
     * Get the web driver connection
     *
     * @return RemoteWebDriver
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function getDriver()
    {
        if (!$this->driver instanceof Connection) {
            $this->driver = Connection::create(
                $this->getConnectionUrl(),
                $this->getCapabilities()
            );
            if ($host = $this->getDefaultHost()) {
                $this->driver->setDefaultHost($host);
            }
        }

        return $this->driver;
    }

    /**
     * Assertions
     *
     * A small comment about these assertions. The PHPUnit assertions are defined as static methods
     * on the test case class (even though they are called non-statically all the time!!). However in
     * this case, the assertions internally need the WebDriver connection object which is only available
     * to test case instances. Therefore I've deliberately made these methods non-static. If anyone
     * has a better idea (maybe I need to factor out the connection object - a
     * singleton maybe?) please shout!
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */

    /**
     * Assert a match for the current url
     *
     * @param string $url
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function assertCurrentUrl($url)
    {
        $host = $this->getDefaultHost();
        if (false != $host && 'http' != substr($url, 0, 4)) {
            $url = $host . '/' . ltrim($url, '/');
        }

        $driver     = $this->getDriver();
        self::assertEquals($driver->getCurrentUrl(), $url);
    }

    /**
     * Assert that a specific string occurs in the page source
     *
     * @param string $string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function assertPageContains($string, $message = '', $ignoreCase = true)
    {
        $driver = $this->getDriver();

        self::assertContains($string, $driver->getPagesource(), $message, $ignoreCase);
    }

    /**
     * Assert that a given element has an attribute, optionally with a given value
     *
     * @param string $selector
     * @param string $attribute
     * @param string $value
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function assertElementHasAttribute($selector, $attribute, $value = null)
    {
        $driver    = $this->getDriver();
        $element   = $driver->getElement($selector);
        $attr      = $element->getAttribute($attribute);

        if (!is_null($value) && !is_null($attr)) {
            self::assertEquals($attr, $value);
        } else {
            self::assertNotNull($attr);
        }
    }

    /** End Assertions **/
}
