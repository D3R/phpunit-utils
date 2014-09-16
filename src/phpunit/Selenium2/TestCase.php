<?php

namespace D3R\PHPUnit\Selenium2;

use D3R\PHPUnit\Selenium2\InvalidSetupException;

/**
 * Base TestCase for Selenium2 tests
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R\PHPUnit\Selenium2
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
    private $webDriver = false;

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
                'browserUrl' => false
            );
    }

    /**
     * {@inheritdoc}. Set up the webdriver connection
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function setUp()
    {
        $this->getDriver();
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
     * Set the browser string
     *
     * @param string $browser
     * @return $this
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function setBrowserUrl($url)
    {
        $this->parameters['browserUrl'] = $url;

        return $this;
    }

    /**
     * Get the browser string
     *
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function getBrowserUrl()
    {
        return $this->parameters['browserUrl'];
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
        $capabilities = new \DesiredCapababilities();
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
        if (!$this->webDriver instanceof \RemoteWebDriver) {
            $this->webDriver = \RemoteWebDriver::create(
                $this->getConnectionUrl(),
                $this->getCapabilities()
            );
        }

        return $this->webDriver;
    }

}
