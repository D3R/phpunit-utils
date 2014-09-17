<?php

namespace D3R\PHPUnit\WebDriver\Exception;

use D3R\PHPUnit\WebDriver\Exception\Exception;

/**
 * Thrown when an element is invalid form some reason, eg: asking to call submit() on an anchor
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R\PHPUnit\WebDriver\Exception
 */
class InvalidElementException extends Exception
{
}
