<?php
/**
 * Created by PhpStorm.
 * User: jmoulin
 * Date: 13/06/2016
 * Time: 16:17
 */

namespace Tests\Db;


class InstanceTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $driver = new \ReflectionProperty(\Nano\Db\Instance::class, 'driver');
        $driver->setAccessible(true);
        $host = new \ReflectionProperty(\Nano\Db\Instance::class, 'host');
        $host->setAccessible(true);
        $dbName = new \ReflectionProperty(\Nano\Db\Instance::class, 'dbName');
        $dbName->setAccessible(true);
        $username = new \ReflectionProperty(\Nano\Db\Instance::class, 'username');
        $username->setAccessible(true);
        $password = new \ReflectionProperty(\Nano\Db\Instance::class, 'password');
        $password->setAccessible(true);

        $instance = new \Nano\Db\Instance();
        $this->assertSame('mysql', $driver->getValue($instance));
        $this->assertSame('localhost', $host->getValue($instance));
        $this->assertSame('', $dbName->getValue($instance));
        $this->assertSame('root', $username->getValue($instance));
        $this->assertSame('root', $password->getValue($instance));

        $instance = new \Nano\Db\Instance('driver', 'host', 'dbname', 'username', 'password');
        $this->assertSame('driver', $driver->getValue($instance));
        $this->assertSame('host', $host->getValue($instance));
        $this->assertSame('dbname', $dbName->getValue($instance));
        $this->assertSame('username', $username->getValue($instance));
        $this->assertSame('password', $password->getValue($instance));
    }

    public function testExecute()
    {
        $pdoMock = $this->getMockBuilder(\Pdo::class)
            ->disableOriginalConstructor()
            ->setMethods(array('__construct', 'setAttribute', 'prepare'))
            ->getMock();
        $statementMock = $this->getMockBuilder(\PDOStatement::class)
            ->setMethods(array('execute', 'fetchAll', 'newPdo'))
            ->getMock();
        $statementMock->expects($this->exactly(2))->method('execute')
            ->withConsecutive(array($this->equalTo(null)), array($this->equalTo(array('test' => 'test'))));
        $statementMock->expects($this->exactly(2))->method('fetchAll')->willReturnOnConsecutiveCalls(1, 2);
        $pdoMock->expects($this->exactly(2))->method('prepare')
            ->withConsecutive(array($this->equalTo('sql')), array($this->equalTo('sql')))
            ->willReturn($statementMock);
        $instanceMock = $this->getMockBuilder(\Nano\Db\Instance::class)
            ->setConstructorArgs(array('driver', 'host', 'dbName', 'username', 'password'))
            ->setMethods(array('newPdo'))
            ->getMock();
        $instanceMock->expects($this->once())
            ->method('newPdo')
            ->with($this->equalTo("driver:host=host;dbname=dbName"), $this->equalTo('username'), $this->equalTo('password'))
            ->willReturn($pdoMock);
        /** @var $instanceMock \Nano\Db\Instance */
        $this->assertSame(1, $instanceMock->execute("sql"));
        $this->assertSame(2, $instanceMock->execute("sql", array('test' => 'test')));
    }
}