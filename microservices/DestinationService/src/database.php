<?php

class Database
{
    private $connection;

    public function __construct($config)
    {
        $this->connection = new PDO(
            'mysql:host=' . $config['host'] . ';dbname=' . $config['name'],
            $config['user'],
            $config['pass']
        );
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
