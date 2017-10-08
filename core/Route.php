<?php

namespace Core;

class Route
{
    private $routes = array();

    private $parameters = array();

    public function add($route, $parameters = array())
    {
        $this->routes[$route] = $parameters;
    }

    public function match($uri)
    {
        foreach ($this->routes as $route => $parameters) {
            if ($uri == $route) {
                $this->parameters = $parameters;
                return true;
            }
        }
        $this->parameters = ['controller' => 'Error404', 'action' => 'error404Action'];
        return false;
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function dispatch($uri)
    {
        if ($this->match($uri)) {
            $controller = $this->parameters['controller'];
            $controller = "Controller\\" . $controller . "Controller";
            if (class_exists($controller)) {
                $controllerObject = new $controller();
                $action = $this->parameters['action'];
                if (method_exists($controllerObject, $action)) {
                    $controllerObject->$action();
                } else {
                    throw new \Exception("Action $action does not exist in $controller");
                }
            } else {
                throw new \Exception("Controller $controller not found");
            }
        } else {
            $controller = $this->parameters['controller'];
            $controller = "Controller\\" . $controller . "Controller";
            if (class_exists($controller)) {
            $controllerObject = new $controller();
            $action = $this->parameters['action'];
            if (method_exists($controllerObject, $action)) {
                $controllerObject->$action();
            } else {
                throw new \Exception("Action $action does not exist in $controller");
            }
        } else {
                throw new \Exception("Controller $controller not found");
            }
        }
    }
}