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

    public function __construct(
        $driver = 'mysql',
        $host = 'localhost',
        $dbName = '',
        $user = 'root',
        $password = 'root'
    ) {
        $this->driver = (string)$driver;
        $this->host = (string)$host;
        $this->dbName = (string)$dbName;
        $this->username = (string)$user;
        $this->password = (string)$password;
    }

    /**
     * @param string $sql
     * @param array|null $params
     * @return array
     */
    public function execute($sql, array $params = null)
    {
        $statement = $this->getPdo()->prepare($sql);
        $statement->execute($params);
        return $statement->fetchAll();
    }

    /**
     * @return \Pdo
     */
    private function getPdo()
    {
        if (!$this->pdo) {
            $dsn = "$this->driver:host=$this->host" . ($this->dbName ? ';dbname=' . $this->dbName : '');
            $this->pdo = $this->newPdo($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        }
        return $this->pdo;
    }

    /**
     * @param $dsn
     * @param $username
     * @param $password
     * @return \Pdo
     * @codeCoverageIgnore
     */
    protected function newPdo($dsn, $username, $password)
    {
        return new \Pdo($dsn, $username, $password);
    }
}
