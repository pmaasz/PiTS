<?php
/**
 * Created by PhpStorm.
 * Author: Philip Maaß
 * Date: 07.01.19
 * Time: 20:02
 * License MIT
 */

Namespace App\Service;

/**
 * Class Database
 */
class Database
{
    use Singleton;

    const DB_DRIVER = '';
    const DB_HOST = '';
    const DB_USER = '';
    const DB_PASSWORD = '';
    const DB_NAME = '';

    /**
     * @var \PDO
     */
    private $connection;

    /**
     * connects to Database
     */
    private function connect()
    {
        $this->connection = new \PDO($this->getDSN(), self::DB_USER, self::DB_PASSWORD);
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

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Database constructor.
     */
    protected function __construct()
    {
        $this->connect();
    }

    /**
     * @return string
     */
    private function getDSN()
    {
        return sprintf("%s:host=%s;dbname=%s", self::DB_DRIVER, self::DB_HOST, self::DB_NAME);
    }
}