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
abstract class TestCase extends \PHPUnit_Extensions_Selenium2TestCase
{
    /**
     * The browser selection for this testcase
     *
     * @var boolean|string
     */
    protected $browser = false;

    /**
     * The initial browser url before testing
     *
     * @var string
     */
    protected $browserUrl = '';

    /**
     * {@inheritdoc}. For Selenium 2 testing we set the browser
     * and initial url.
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function setUp()
    {
        if (false === $this->browser) {
            throw new InvalidSetupException('Browser selection not set');
        }
        $this->setBrowser($this->browser);
        $this->setBrowserUrl($this->browserUrl);
    }
}
