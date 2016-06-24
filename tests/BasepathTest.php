<?php
namespace Nano\Tests;

class BasepathTest extends \PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $_SERVER['REQUEST_URI'] = '/controller/action';

        $_SERVER['SCRIPT_FILENAME'] = '/var/www/controller/index.php';
        $this->assertSame('/controller/', \Nano\Basepath::get());
        $_SERVER['SCRIPT_FILENAME'] = '/var/www/index.php';
        $this->assertSame('/', \Nano\Basepath::get());
        $_SERVER['SCRIPT_FILENAME'] = '/var/www/controller/action/index.php';
        $this->assertSame('/controller/action/', \Nano\Basepath::get());
    }
}
