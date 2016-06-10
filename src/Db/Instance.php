<?php
namespace Nano\Db;


class Instance
{
    private $driver = 'mysql';
    private $host = 'localhost';
    private $dbName = '';
    private $username = 'root';
    private $password = 'root';
    private $pdo;

    public function __construct($driver = 'mysql', $host = 'localhost', $dbName = '', $user = 'root', $password = 'root')
    {
        $this->driver = (string) $driver;
        $this->host = (string) $host;
        $this->dbName = (string) $dbName;
        $this->user = (string) $user;
        $this->password = (string) $password;
    }

    public function execute($sql, array $params = null)
    {
        $statement = $this->getPdo()->prepare($sql);
        $statement->execute($params);
        return $statement->fetchAll();
    }

    private function getPdo()
    {
        if (!$this->pdo) {
            $dsn = "$this->driver:host=$this->host" . ($this->dbName ? ';dname=' . $this->dbName : '');
            $this->pdo = new \Pdo($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \Pdo::FETCH_ASSOC);
        }
        return $this->pdo;
    }
}
