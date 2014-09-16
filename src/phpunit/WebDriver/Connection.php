<?php

namespace D3R\PHPUnit\WebDriver;

/**
 * Class to represent an instanceof of a WebDriver connection
 *
 * This class extends RemoteWebDriver and provides some utility methods
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R\PHPUnit\WebDriver
 */
class Connection extends \RemoteWebDriver
{
    /**
     * The default host for this connection
     *
     * @var string
     */
    protected $defaultHost = false;

    /**
     * Set the base url for this connection
     *
     * The base url is prepended to all get() requests that don't start
     * with "http". This allows the user to do
     *
     * <code>
     * $connection->setDefaultHost('http://mysite.com')->get('/foo/bar');
     * </code>
     *
     * hopefully easing the burden of having to hardcode the host every time.
     *
     * @param string $url
     * @return $this
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function setDefaultHost($defaultHost)
    {
        $this->defaultHost = rtrim($defaultHost, '/');

        return $this;
    }

    /**
     * {@inheritdoc}. Override to allow prepending the default host
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function get($url)
    {
        if ($this->defaultHost && 'http' != substr($url, 0, 4)) {
            $url = $this->defaultHost . '/' . ltrim($url, '/');
        }

        return parent::get($url);
    }

    /**
     * Click on an element by selector
     *
     * @param string $selector
     * @return $this
     * @throws NoSuchElementException
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function click($selector)
    {
        $element = $this->findElement($this->getElementBy($selector));
        $element->click();

        return $this;
    }

    /**
     * Pause for a given number of seconds
     *
     * @param int $timeout_in_second
     * @return $this
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function waitForSelector($selector, $timeout_in_second = 30)
    {
        $by = $this->getElementBy($selector);
        $this->wait($timeout_in_second)
             ->until(\WebDriverExpectedCondition::presenceOfElementLocated($by))
             ;

        return $this;
    }

    /**
     * Get an element by selector
     *
     * @param string $selector
     * @return WebDriverBy
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function getElementBy($selector)
    {
        if ('#' == substr($selector, 0, 1)) {
            $by = \WebDriverBy::id(substr($selector, 1));
        } else {
            $by = \WebDriverBy::cssSelector($selector);
        }

        return $by;
    }
}
