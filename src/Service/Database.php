<?php
/**
 * Created by PhpStorm.
 * Author: Philip Maaß
 * Date: 07.01.19
 * Time: 20:02
 * License MIT
 */

Namespace App\Service;

use PDO;

/**
 * Class Database
 */
class Database
{
    use Singleton;

    /**
     * @var PDO
     */
    private $connection;

    /**
     * connects to Database
     */
    private function connect()
    {
        $config = ConfigService::getInstance()->get('database');
        $this->connection = new PDO($this->getDSN($config), $config['user'], $config['password']);
    }

    /**
     * @return bool
     */
    public function isConnected()
    {
        if(($this->connection !== null || $this->connection !== '') && $this->connection)
        {
            return true;
        }

        return false;
    }

    /**
     * @param $query
     * @param array $parameters
     *
     * @return bool
     */
    public function insert($query, array $parameters = array())
    {
        $statement = $this->connection->prepare($query);

        foreach($parameters as $key => $value)
        {
            $statement->bindValue(':'.$key, $value);
        }

        return $statement->execute();
    }

    /**
     * @param $query
     * @param array $parameters
     *
     * @return array
     */
    public function query($query, array $parameters = array())
    {
        $statement = $this->connection->prepare($query);

        foreach($parameters as $key => $value)
        {
            $statement->bindValue(':'.$key, $value);
        }

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Database constructor.
     */
    protected function __construct()
    {
        $this->connect();
    }

    /**
     * Create an DSN for the PDO object.
     *
     * @param array $config
     *
     * @return string
     */
    private function getDSN($config)
    {
        return sprintf("%s:host=%s;dbname=%s", $config['driver'], $config['host'], $config['dbname']);
    }
}