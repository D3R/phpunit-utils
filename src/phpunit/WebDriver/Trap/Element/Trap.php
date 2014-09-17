<?php

namespace D3R\PHPUnit\WebDriver\Trap\Element;

use D3R\PHPUnit\WebDriver\Trap\Trap as BaseTrap;

/**
 * This trap stores the text from a given element
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R\PHPUnit\WebDriver\Trap\Element
 */
abstract class Trap extends BaseTrap
{
    /**
     * The element we're working on
     *
     * @var RemoteWebElement
     */
    private $element;

    /**
     * Class constructor
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function __construct(\RemoteWebElement $element)
    {
        $this->element = $element;
    }

    /**
     * Get the element for this trap
     *
     * @return RemoteWebElement
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function getElement()
    {
        return $this->element;
    }
}
