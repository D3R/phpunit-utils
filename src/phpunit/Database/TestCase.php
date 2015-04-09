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
     * The base path for fixture data files
     *
     * @var array
     */
    protected $fixturePath = false;

    /**
     * The names of the fixtures to load for this test
     *
     * @var array
     */
    protected $fixtures = array();

    /**
     * Class constructor
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->setUpFixtures();
    }

    /**
     * Setup fixture information
     *
     * @return void
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function setUpFixtures()
    {
    }

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

    /**
     * Override to create the test dataset
     *
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function getDataSet()
    {
        if (false === $this->fixturePath) {
            throw new \RuntimeException(
                'Fixture path not provided in TestCase class'
            );
        }

        $composite = new \PHPUnit_Extensions_Database_DataSet_CompositeDataSet(
            array()
        );

        $fixturePath = rtrim($this->fixturePath, DIRECTORY_SEPARATOR);
        foreach ($this->fixtures as $fixture) {
            $path = implode(DIRECTORY_SEPARATOR, array($fixturePath, $fixture));

            $extension = substr($path, -3);
            switch (strtolower($extension)) {

                case 'yml':
                    $dataset = $this->createYamlDataSet($path);
                    break;

                case 'php':
                    $dataset = $this->createArrayDataSet(include $path);
                    break;

                default:
                    throw new \RuntimeException(
                        'Unknown data set type ' . $fixture
                    );

            }
            $composite->addDataSet($dataset);
        }

        return $composite;
    }

    /**
     * Get a dataset from a YAML fixture file
     *
     * @return PHPUnit_Extensions_Database_DataSet_YamlDataSet
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function createYamlDataSet($filename)
    {
        return new \PHPUnit_Extensions_Database_DataSet_YamlDataSet($filename);
    }
}
