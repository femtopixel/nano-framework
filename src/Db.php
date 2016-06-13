<?php
namespace Nano;

class Db
{
    private static $instances = array();

    /**
     * @param string $name
     * @param array|null $params
     * @return Db\Instance
     */
    public static function getInstance($name, array $params = null)
    {
        if (!isset(self::$instances[$name])) {
            self::$instances[$name] = new Db\Instance(
                isset($params['driver']) ? $params['driver'] : 'mysql',
                isset($params['host']) ? $params['host'] : 'localhost',
                isset($params['dbname']) ? $params['dbname'] : '',
                isset($params['username']) ? $params['username'] : 'root',
                isset($params['password']) ? $params['password'] : 'root'
            );
        }
        return self::$instances[$name];
    }
}
