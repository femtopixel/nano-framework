<?php
namespace Nano\Tests;

class DbTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInstance()
    {
        $index = array();
        $index[0] = \Nano\Db::getInstance(
            'default',
            array(
                'driver' => 'driver',
                'host' => 'host',
                'dbname' => 'dbname',
                'username' => 'username',
                'password' => 'password'
            )
        );
        $driver = new \ReflectionProperty('\Nano\Db\Instance', 'driver');
        $driver->setAccessible(true);
        $host = new \ReflectionProperty('\Nano\Db\Instance', 'host');
        $host->setAccessible(true);
        $dbName = new \ReflectionProperty('\Nano\Db\Instance', 'dbName');
        $dbName->setAccessible(true);
        $username = new \ReflectionProperty('\Nano\Db\Instance', 'username');
        $username->setAccessible(true);
        $password = new \ReflectionProperty('\Nano\Db\Instance', 'password');
        $password->setAccessible(true);
        $this->assertSame('driver', $driver->getValue($index[0]));
        $this->assertSame('host', $host->getValue($index[0]));
        $this->assertSame('dbname', $dbName->getValue($index[0]));
        $this->assertSame('username', $username->getValue($index[0]));
        $this->assertSame('password', $password->getValue($index[0]));
        $index[1] = \Nano\Db::getInstance(
            'default',
            array(
                'driver' => 'driver2',
                'host' => 'host2',
                'dbname' => 'dbname2',
                'username' => 'username2',
                'password' => 'password2'
            )
        );
        $this->assertSame('driver', $driver->getValue($index[1]));
        $this->assertSame('host', $host->getValue($index[1]));
        $this->assertSame('dbname', $dbName->getValue($index[1]));
        $this->assertSame('username', $username->getValue($index[1]));
        $this->assertSame('password', $password->getValue($index[1]));
        $index[2] = \Nano\Db::getInstance('test');
        $this->assertSame('mysql', $driver->getValue($index[2]));
        $this->assertSame('localhost', $host->getValue($index[2]));
        $this->assertSame('', $dbName->getValue($index[2]));
        $this->assertSame('root', $username->getValue($index[2]));
        $this->assertSame('root', $password->getValue($index[2]));
        $index[3] = \Nano\Db::getInstance('test');
        $this->assertSame($index[0], $index[1]);
        $this->assertNotSame($index[1], $index[2]);
    }
}
