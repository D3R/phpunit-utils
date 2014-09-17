<?php

namespace D3R\PHPUnit\WebDriver\Trap\Element;

use D3R\PHPUnit\WebDriver\Connection;

/**
 * This trap stores the text from a given element
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R\PHPUnit\WebDriver\Trap
 */
class TextTrap extends Trap
{
    /**
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function evaluate(Connection $connection)
    {
        $element = $this->getElement();

        $this->setData($element->getText());
    }

}
