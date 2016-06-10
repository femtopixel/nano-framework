<?php
namespace Nano;


final class Framework
{
    private $projectNamespace = '\Project';
    private $controllerPackage = '\Controller';
    private $controllerActionSuffix = 'Action';

    public function dispatch()
    {
        $globb = explode('/', preg_replace('~^' . Basepath::get() . '~', '', $_SERVER['REQUEST_URI']));
        $controllerName = isset($globb[0]) && $globb[0] ? $globb[0] : 'index';
        $action = isset($globb[1]) && $globb[1] ? $globb[1] : 'index';
        $controller = $this->projectNamespace . $this->controllerPackage . '\\' . ucfirst($controllerName);
        if (!class_exists($controller)) {
            throw new \Exception('controller ' . $controllerName . ' not found');
        };
        $controller = new $controller;
        $action = $action . $this->controllerActionSuffix;
        if (!is_callable(array($controller, $action))) {
            throw new \Exception('action ' . $action . ' not found in controller ' . $controllerName);
        }
        $controller->$action();
    }

    public function setNamespace($namespace = '\Project')
    {
        $this->projectNamespace = $namespace{0} != '\\' ? '\\' . $namespace : $namespace;
        return $this;
    }

    public function setControllerPackage($controllerPackage = '\Controller')
    {
        $this->controllerPackage = $controllerPackage{0} != '\\' ? '\\' . $controllerPackage : $controllerPackage;
        return $this;
    }

    public function setControllerActionSuffix($suffix = 'Action')
    {
        $this->controllerActionSuffix = (string) $suffix;
        return $this;
    }
}
