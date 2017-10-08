<?php

namespace Core;

use Service\Container;

abstract class Controller
{
    private $container;

    /**
     * @return Container
     */
    protected function getContainer()
    {
        if ($this->container == null) {
            $this->container = new Container();
        }
        return $this->container;
    }

    protected function render($template, array $vars = array())
    {
        $root = dirname(__DIR__) . DS . 'app' . DS . 'views';
        $templatePath = $root . $template;

        if (!is_file($templatePath)) {
            throw new \Exception(sprintf('Template "%s" not found in "%s"', $template, $templatePath));
        }

        extract($vars);

        try {
            require $templatePath;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        return true;
    }

    protected function redirectToRoute($route)
    {
        header('Location: ' . $route);
        return true;
    }
}