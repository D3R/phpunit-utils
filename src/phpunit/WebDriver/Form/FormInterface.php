<?php

namespace D3R\PHPUnit\WebDriver\Form;

use D3R\PHPUnit\WebDriver\Connection;

/**
 * Interface for Form objects used for filling in forms
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R\PHPUnit\WebDriver\Form
 */
interface FormInterface
{
    /**
     * Use a given form selector
     *
     * @param string $selector
     * @return $this
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function useFormSelector($selector);

    /**
     * Get the form selector for this form object
     *
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function getFormSelector();

    /**
     * Type some text into a text box
     *
     * @param string $selector
     * @param string $text
     * @return $this
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function typeInto($selector, $text);

    /**
     * Choose an option from a select box
     *
     * @param string $selector
     * @param string $option
     * @return $this
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function selectOption($selector, $option);

    /**
     * Apply the form changes to a webdriver connection
     *
     * @param Connection $connection
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function apply(Connection $connection);
}
