<?php

namespace D3R\PHPUnit\WebDriver\Form;

use D3R\PHPUnit\WebDriver\Connection;

/**
 * Form object used for filling in forms
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R\PHPUnit\WebDriver\Form
 */
class Form implements FormInterface
{
    /**
     * The selector for the form element
     *
     * @var string
     */
    protected $formSelector = 'form:first-of-type';

    /**
     * Text field entries
     *
     * @var array
     */
    protected $textEntries = array();

    /**
     * Select option entries
     *
     * @var array
     */
    protected $selectEntries = array();

    /**
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function useFormSelector($selector)
    {
        $this->formSelector = $selector;

        return $this;
    }

    /**
     * Get the form selector for this form object
     *
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function getFormSelector()
    {
        return $this->formSelector;
    }

    /**
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function typeInto($selector, $text)
    {
        $this->textEntries[$selector] = $text;

        return $this;
    }

    /**
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function selectOption($selector, $option)
    {
        $this->selectEntries[$selector] = $option;

        return $this;
    }

    /**
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function apply(Connection $connection)
    {
        $formSelector = $this->formSelector;

        // Apply test entries
        foreach ($this->textEntries as $selector => $text) {
            $selector = "{$formSelector} {$selector}";
            $element  = $connection->getElement($selector);
            $element->clear();
            $element->sendKeys($text);
        }

        foreach ($this->selectEntries as $selector => $option) {
            $selector = "{$selector} option[value='{$option}']";
            $element = $connection->getElement($selector);
            $element->click();
        }
    }
}
