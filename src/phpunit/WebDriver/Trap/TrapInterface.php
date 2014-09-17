<?php

namespace D3R\PHPUnit\WebDriver\Trap;

use D3R\PHPUnit\WebDriver\Connection;

/**
 * Interface for all driver traps
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R\PHPUnit\WebDriver\Trap
 */
interface TrapInterface
{
    /**
     * Evaluate this trap
     *
     * @param Connection $connection
     * @return void
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function evaluate(Connection $connection);

    /**
     * Get the trapped data
     *
     * @return mixed
     * @throws EvaluationFailedException
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function getData();
}
