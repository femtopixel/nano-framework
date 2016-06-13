<?php
namespace Project\Controller {
    class ControllerOk
    {
        public function testAction()
        {
            echo "Working1";
        }
    }
}
namespace Project\OtherSub {

    class Controller
    {
        public function testAction()
        {
            echo "Working2";
        }
    }
}
namespace OtherNamespace\OtherSub {

    class Routing
    {
        public function testAction()
        {
            echo "Working3";
        }
    }
}
namespace OtherNamespace {
    class Route
    {
        public function actionThatHasOtherSuffix()
        {
            echo "Working4";
        }
    }
}
namespace Tests {

    class FrameworkTest extends \PHPUnit_Framework_TestCase
    {
        public function testDispatchFailDefault()
        {
            $_SERVER['REQUEST_URI'] = '/';
            $_SERVER['SCRIPT_FILENAME'] = '/var/www/controller/index.php';
            $this->setExpectedException('\Exception', 'controller index not found');
            $nano = new \Nano\Framework();
            $nano->dispatch();
        }

        public function testDispatchFailDefaultWithControllerButBasePath()
        {
            $_SERVER['REQUEST_URI'] = '/controller';
            $_SERVER['SCRIPT_FILENAME'] = '/var/www/controller/index.php';
            $this->setExpectedException('\Exception', 'controller index not found');
            $nano = new \Nano\Framework();
            $nano->dispatch();
        }

        public function testDispatchFailDefaultWithController()
        {
            $_SERVER['REQUEST_URI'] = '/controller';
            $_SERVER['SCRIPT_FILENAME'] = '/var/www/index.php';
            $this->setExpectedException('\Exception', 'controller controller not found');
            $nano = new \Nano\Framework();
            $nano->dispatch();
        }

        public function testDispatchFailWhenControllerDefaultOkButNoAction()
        {
            $_SERVER['REQUEST_URI'] = '/controllerOk';
            $_SERVER['SCRIPT_FILENAME'] = '/var/www/index.php';
            $this->setExpectedException('\Exception', 'action indexAction not found in controller controllerOk');
            $nano = new \Nano\Framework();
            $nano->dispatch();
        }

        public function testDispatchSuccessWhenDefault()
        {
            $_SERVER['REQUEST_URI'] = '/controllerOk/test';
            $_SERVER['SCRIPT_FILENAME'] = '/var/www/index.php';
            $this->expectOutputString("Working1");
            $nano = new \Nano\Framework();
            $nano->dispatch();
        }

        public function testDispatchSuccessWhenOtherSubPackage()
        {
            $_SERVER['REQUEST_URI'] = '/controller/test';
            $_SERVER['SCRIPT_FILENAME'] = '/var/www/index.php';
            $this->expectOutputString("Working2");
            $nano = new \Nano\Framework();
            $nano->setControllerPackage('OtherSub')->dispatch();
        }

        public function testDispatchSuccessWhenOtherSubPackageAndOtherNamespace()
        {
            $_SERVER['REQUEST_URI'] = '/routing/test';
            $_SERVER['SCRIPT_FILENAME'] = '/var/www/index.php';
            $this->expectOutputString("Working3");
            $nano = new \Nano\Framework();
            $nano->setNamespace('\OtherNamespace')->setControllerPackage('OtherSub')->dispatch();
        }

        public function testDispatchSuccessWhenOtherSubPackageAndOtherNamespaceWithOtherSuffix()
        {
            $_SERVER['REQUEST_URI'] = '/route/actionthathas';
            $_SERVER['SCRIPT_FILENAME'] = '/var/www/index.php';
            $this->expectOutputString("Working4");
            $nano = new \Nano\Framework();
            $nano->setNamespace('\OtherNamespace')
                ->setControllerPackage('')
                ->setControllerActionSuffix('OtherSuffix')
                ->dispatch();
        }
    }
}
