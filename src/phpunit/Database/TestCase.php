<?php

namespace D3R\PHPUnit\Database;

/**
 * Base class for database test cases
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R\PHPUnit\Database
 */
abstract class TestCase extends \PHPUnit_Extensions_Database_TestCase
{
    /**
     * Private static variable to hold the PDO connection object
     *
     * @var \PDO
     */
    private static $pdo = null;

    /**
     * An instance of PHPUnit_Extensions_Database_DB_IDatabaseConnection
     *
     * @var
     */
    private $connection = null;

    /**
     * Get the db connection for this test case
     *
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    final public function getConnection()
    {
        if (!$this->connection instanceof \PHPUnit_Extensions_Database_DB_IDatabaseConnection) {
            if (!self::$pdo instanceof \PHPUnit_Extensions_Database_DB_IDatabaseConnection) {
                self::$pdo = new \PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASS']);
            }
            $this->connection = $this->createDefaultDBConnection(self::$pdo, $GLOBALS['DB_DB']);
        }

        return $this->connection;
    }
}
