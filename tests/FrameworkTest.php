<?php
namespace Project\Controller;

class ControllerOk
{
    public function testAction()
    {
        echo "Working1";
    }
}

namespace Project\OtherSub;

class Controller
{
    public function testAction()
    {
        echo "Working2";
    }
}

namespace OtherNamespace\OtherSub;

class Routing
{
    public function testAction()
    {
        echo "Working3";
    }
}

namespace OtherNamespace;

class Route
{
    public function actionThatHasOtherSuffix()
    {
        echo "Working4";
    }
}

class FrameworkTest extends \PHPUnit_Framework_TestCase
{
    public function testDispatchFailDefault()
    {
        $_SERVER['REQUEST_URI'] = '/';
        $_SERVER['SCRIPT_FILENAME'] = '/var/www/controller/index.php';
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('controller index not found');
        (new \Nano\Framework())->dispatch();
    }

    public function testDispatchFailDefaultWithControllerButBasePath()
    {
        $_SERVER['REQUEST_URI'] = '/controller';
        $_SERVER['SCRIPT_FILENAME'] = '/var/www/controller/index.php';
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('controller index not found');
        (new \Nano\Framework())->dispatch();
    }

    public function testDispatchFailDefaultWithController()
    {
        $_SERVER['REQUEST_URI'] = '/controller';
        $_SERVER['SCRIPT_FILENAME'] = '/var/www/index.php';
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('controller controller not found');
        (new \Nano\Framework())->dispatch();
    }

    public function testDispatchFailWhenControllerDefaultOkButNoAction()
    {
        $_SERVER['REQUEST_URI'] = '/controllerOk';
        $_SERVER['SCRIPT_FILENAME'] = '/var/www/index.php';
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('action indexAction not found in controller controllerOk');
        (new \Nano\Framework())->dispatch();
    }

    public function testDispatchSuccessWhenDefault()
    {
        $_SERVER['REQUEST_URI'] = '/controllerOk/test';
        $_SERVER['SCRIPT_FILENAME'] = '/var/www/index.php';
        $this->expectOutputString("Working1");
        (new \Nano\Framework())->dispatch();
    }

    public function testDispatchSuccessWhenOtherSubPackage()
    {
        $_SERVER['REQUEST_URI'] = '/controller/test';
        $_SERVER['SCRIPT_FILENAME'] = '/var/www/index.php';
        $this->expectOutputString("Working2");
        (new \Nano\Framework())->setControllerPackage('OtherSub')->dispatch();
    }

    public function testDispatchSuccessWhenOtherSubPackageAndOtherNamespace()
    {
        $_SERVER['REQUEST_URI'] = '/routing/test';
        $_SERVER['SCRIPT_FILENAME'] = '/var/www/index.php';
        $this->expectOutputString("Working3");
        (new \Nano\Framework())->setNamespace('\OtherNamespace')->setControllerPackage('OtherSub')->dispatch();
    }

    public function testDispatchSuccessWhenOtherSubPackageAndOtherNamespaceWithOtherSuffix()
    {
        $_SERVER['REQUEST_URI'] = '/route/actionthathas';
        $_SERVER['SCRIPT_FILENAME'] = '/var/www/index.php';
        $this->expectOutputString("Working4");
        (new \Nano\Framework())->setNamespace('\OtherNamespace')
            ->setControllerPackage('')
            ->setControllerActionSuffix('OtherSuffix')
            ->dispatch();
    }
}