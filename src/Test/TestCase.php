<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @see      https://www.github.com/janhuang
 * @see      http://www.fast-d.cn/
 */

namespace FastD\Test;

use FastD\Application;
use FastD\Http\Response;
use FastD\Testing\WebTestCase;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use PHPUnit_Extensions_Database_DB_IDatabaseConnection;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class TestCase.
 */
class TestCase extends WebTestCase
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * Set up unit.
     */
    public function setUp()
    {
        $this->app = $this->createApplication();
        parent::setUp();
    }

    /**
     * @return Application
     */
    public function createApplication()
    {
        return new Application(getcwd());
    }

    /**
     * @param ServerRequestInterface $request
     * @param array                  $params
     * @param array                  $headers
     *
     * @return Response
     */
    public function handleRequest(ServerRequestInterface $request, array $params = [], array $headers = [])
    {
        if ('GET' === $request->getMethod()) {
            $request->withQueryParams($params);
        } else {
            $request->withParsedBody($params);
        }
        foreach ($headers as $name => $header) {
            $request->withAddedHeader($name, $header);
        }

        return $this->app->handleRequest($request);
    }

    /**
     * Returns the test database connection.
     *
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    protected function getConnection()
    {
        $connection = env('connection');
        if (!$connection) {
            $connection = 'default';
        }

        return $this->createDefaultDBConnection(database($connection)->pdo);
    }

    /**
     * Returns the test dataset.
     *
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        $path = app()->getPath().'/database/dataset/*';

        $composite = new \PHPUnit_Extensions_Database_DataSet_CompositeDataSet();

        foreach (glob($path) as $file) {
            $dataSet = load($file);
            $tableName = pathinfo($file, PATHINFO_FILENAME);
            $composite->addDataSet(
                new \PHPUnit_Extensions_Database_DataSet_ArrayDataSet(
                    [
                        $tableName => $dataSet,
                    ]
                )
            );
        }

        return $composite;
    }
}
