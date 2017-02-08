<?php
declare(strict_types = 1);

namespace Nano;

/**
 * Class Framework
 * @package Nano
 */
final class Framework
{
    private $projectNamespace = '\Project';
    private $controllerPackage = '\Controller';
    private $controllerActionSuffix = 'Action';

    /**
     * Dispatch the request
     * @throws \Exception
     * @return mixed
     */
    public function dispatch()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $appendUri = strpos($requestUri, '?');
        $query = substr($requestUri, 0, $appendUri === false ? strlen($requestUri) : $appendUri);
        $parts = explode('/', preg_replace('~^' . Basepath::get() . '~', '', $query));
        $action = count($parts) >= 2 ? array_pop($parts) : 'index';
        if (!$action) {
            $action = 'index';
        }
        $controllerName = isset($parts[0]) && $parts[0] ? implode($parts, '\\') : 'index';
        $controller = $this->projectNamespace . $this->controllerPackage . '\\' . ucfirst($controllerName);
        if (!class_exists($controller)) {
            throw new \Exception('controller ' . $controllerName . ' not found');
        };
        $controller = new $controller;
        $action = $action . $this->controllerActionSuffix;
        if (!is_callable(array($controller, $action))) {
            throw new \Exception('action ' . $action . ' not found in controller ' . $controllerName);
        }
        return $controller->$action();
    }

    /**
     * Redefine personal namespace
     * @param string $namespace
     * @return Framework
     */
    public function setNamespace(string $namespace = '\Project') : Framework
    {
        $this->projectNamespace = strlen($namespace) && $namespace{0} != '\\' ? '\\' . $namespace : $namespace;
        return $this;
    }

    /**
     * Redefine controller subpackage
     * @param string $controllerPackage
     * @return Framework
     */
    public function setControllerPackage(string $controllerPackage = '\Controller') : Framework
    {
        $this->controllerPackage = strlen($controllerPackage) && $controllerPackage{0} != '\\'
            ? '\\' . $controllerPackage
            : $controllerPackage;
        return $this;
    }

    /**
     * Redefine controller action suffix
     * @param string $suffix
     * @return Framework
     */
    public function setControllerActionSuffix(string $suffix = 'Action') : Framework
    {
        $this->controllerActionSuffix = (string)$suffix;
        return $this;
    }
}
