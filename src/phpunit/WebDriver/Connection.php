<?php

namespace D3R\PHPUnit\WebDriver;

use D3R\PHPUnit\WebDriver\Exception\InvalidElementException;
use D3R\PHPUnit\WebDriver\Trap\Element\AttributeTrap;
use D3R\PHPUnit\WebDriver\Trap\Element\TextTrap;
use D3R\PHPUnit\WebDriver\Trap\Exception\UnknownTrapTagException;
use D3R\PHPUnit\WebDriver\Trap\TrapInterface;

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
     * Trapped data
     *
     * @var array
     */
    protected $trapped = array();

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
        $element = $this->getElement($selector);
        $element->click();

        return $this;
    }

    /**
     * Submit a form
     *
     * @param string $selector
     * @return $this
     * @throws \NoSuchElementException
     * @throws D3R\PHPUnit\WebDriver\Exception\InvalidElementException
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function submit($selector)
    {
        $element = $this->getElement($selector);
        if ('form' !== $element->getTagName()) {
            throw new InvalidElementException('Unable to call submit on ' . $element->getTagName() . ' element');
        }
        $element->submit();

        return $this;
    }

    /**
     * Pause for a given number of seconds
     *
     * @param int $timeout_in_second
     * @return $this
     * @throws NoSuchElementException
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function waitForSelector($selector, $timeout_in_second = 30, $interval_in_millisecond = 250)
    {
        $by = $this->getWebDriverBy($selector);
        $this->wait($timeout_in_second, $interval_in_millisecond)
             ->until(\WebDriverExpectedCondition::presenceOfElementLocated($by))
             ;

        return $this;
    }

    /**
     * Trap something from the browser for later use
     *
     * @param TrapInterface $trap
     * @param string $tag
     * @return $this
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function trap(TrapInterface $trap, $tag)
    {
        $trap->evaluate($this);
        $this->trapped[$tag] = $trap;

        return $this;
    }

    /**
     * Trap the text of an element
     *
     * @param string $selector
     * @return $this
     * @throws NoSuchElementException
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function trapText($selector, $tag)
    {
        $element = $this->getElement($selector);
        $trap    = new TextTrap($element);

        return $this->trap($trap, $tag);
    }

    /**
     * Trap the value of an attribute
     *
     * @param string $selector
     * @param string $attribute
     * @param string $tag
     * @return $this
     * @throws NoSuchElementException
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function trapAttribute($selector, $attribute, $tag)
    {
        $element = $this->getElement($selector);
        $trap    = new AttributeTrap($element, $attribute);

        return $this->trap($trap, $tag);
    }

    /**
     * Get the data for a given trap tag
     *
     * @param string $tag
     * @throws UnknownTrapTagException
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function getTrap($tag)
    {
        if (!isset($this->trapped[$tag])) {
            throw new UnknownTrapTagException('Invalid tag ' . (string) $tag);
        }

        return $this->trapped[$tag];
    }

    /**
     * Get an element by selector
     *
     * @param string $selector
     * @return RemoteWebElement
     * @throws NoSuchElementException
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function getElement($selector)
    {
        return $this->findElement($this->getWebDriverBy($selector));
    }

    /**
     * Get an element by selector
     *
     * @param string $selector
     * @return WebDriverBy
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function getWebDriverBy($selector)
    {
        if (
            false &&
            false === strpos($selector, ' ') &&
            false === strpos($selector, '.') &&
            '#' == substr($selector, 0, 1)
        ) {
            $by = \WebDriverBy::id(substr($selector, 1));
        } else {
            $by = \WebDriverBy::cssSelector($selector);
        }

        return $by;
    }
}
