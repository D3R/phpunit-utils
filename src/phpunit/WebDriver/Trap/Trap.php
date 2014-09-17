<?php

namespace D3R\PHPUnit\WebDriver\Trap;

use D3R\PHPUnit\WebDriver\Connection;

/**
 * Base class for all traps
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R\PHPUnit\WebDriver\Trap
 */
class Trap implements TrapInterface
{
    /**
     * The data for this trap
     *
     * @var mixed
     */
    protected $data;

    /**
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Evaluate this trap
     *
     * @param Connection $connection
     * @throws EvaluationFailedException
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function evaluate(Connection $connection)
    {
        throw new EvaluationFailedException('Base class does not implement an evaluation');
    }

    /**
     * Set the data for this trap
     *
     * @param mixed $data
     * @return void
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function setData($data)
    {
        $this->data = $data;
    }
}
