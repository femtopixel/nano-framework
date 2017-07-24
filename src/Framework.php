<?php
declare(strict_types=1);

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
    private $withParameterMatching = false;

    /**
     * Dispatch the request
     * @throws \Exception
     * @return mixed
     */
    public function dispatch()
    {
        list($controllerName, $action) = $this->getControllerAndAction();
        $controller = $this->getControllerFromName($controllerName);
        $finalAction = $this->getVerbFromRequest() . ucfirst($action) . $this->controllerActionSuffix;
        if (is_callable(array($controller, $finalAction))) {
            return call_user_func_array(
                [$controller, $finalAction],
                $this->getParametersForMatching($controller, $finalAction)
            );
        }
        $finalAction = $action . $this->controllerActionSuffix;
        if (!is_callable(array($controller, $finalAction))) {
            throw new \Exception('action ' . $finalAction . ' not found in controller ' . $controllerName);
        }
        return call_user_func_array(
            [$controller, $finalAction],
            $this->getParametersForMatching($controller, $finalAction)
        );
    }

    /**
     * Returns parameters from request matching specified controller and action
     * @param object $controller
     * @param string $action
     * @return array
     */
    private function getParametersForMatching($controller, string $action): array
    {
        $parameters = [];
        $reflection = new \ReflectionMethod($controller, $action);
        foreach ($reflection->getParameters() as $param) {
            if (isset($_REQUEST[$param->name])) {
                $parameters[$param->name] = $_REQUEST[$param->name];
            }
        }
        return $parameters;
    }

    /**
     * Return Controller instance from a controller name
     * @param string $controllerName
     * @return object
     * @throws \Exception
     */
    private function getControllerFromName(string $controllerName)
    {
        $controller = $this->projectNamespace . $this->controllerPackage . '\\' . ucfirst($controllerName);
        if (!class_exists($controller)) {
            throw new \Exception('controller ' . $controllerName . ' not found');
        }
        return new $controller;
    }

    /**
     * Return HTTP Method for request
     * @return string
     */
    private function getVerbFromRequest(): string
    {
        return isset($_SERVER['REQUEST_METHOD']) ? strtolower($_SERVER['REQUEST_METHOD']) : 'get';
    }

    /**
     * Returns Request uri without query string
     * @return string
     */
    private function getQuery(): string
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $appendUri = strpos($requestUri, '?');
        return substr($requestUri, 0, $appendUri === false ? strlen($requestUri) : $appendUri);
    }

    /**
     * Determine controller and action from Request Uri
     * @return array
     */
    private function getControllerAndAction(): array
    {
        $parts = explode('/', preg_replace('~^' . Basepath::get() . '~', '', $this->getQuery()));
        $action = count($parts) >= 2 ? array_pop($parts) : 'index';
        $controllerName = isset($parts[0]) && $parts[0] ? implode($parts, '\\') : 'index';
        return [$controllerName, $action ?: 'index'];
    }

    /**
     * Redefine personal namespace
     * @param string $namespace
     * @return Framework
     */
    public function setNamespace(string $namespace = '\Project'): Framework
    {
        $this->projectNamespace = strlen($namespace) && $namespace{0} != '\\' ? '\\' . $namespace : $namespace;
        return $this;
    }

    /**
     * Redefine controller subpackage
     * @param string $controllerPackage
     * @return Framework
     */
    public function setControllerPackage(string $controllerPackage = '\Controller'): Framework
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
    public function setControllerActionSuffix(string $suffix = 'Action'): Framework
    {
        $this->controllerActionSuffix = (string)$suffix;
        return $this;
    }

    /**
     * Tells if we should use parameter matching for controllers
     * @param bool $active
     * @return Framework
     */
    public function setParameterMatching($active = true): Framework
    {
        $this->withParameterMatching = (bool)$active;
        return $this;
    }
}
