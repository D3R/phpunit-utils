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
class AttributeTrap extends Trap
{
    /**
     * The attribute we want to trap
     *
     * @var string
     */
    protected $attribute;

    /**
     * Class constructor
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function __construct(\RemoteWebElement $element, $attribute)
    {
        parent::__construct($element);

        $this->attribute = $attribute;
    }

    /**
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function evaluate(Connection $connection)
    {
        $element = $this->getElement();

        $attribute = $element->getAttribute($this->attribute);
        if (is_null($attribute)) {
            throw new EvaluationFailedException('Attribute was not found');
        }

        $this->setData($attribute);
    }

}
