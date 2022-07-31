<?php 

namespace app\core;

use app\core\View;

abstract class Controller 
{
    public $route;
    public $model;
    public $view;

    public function __construct($route)
    {
        $this->route = $route;
        $this->view = new View($route);
        $this->model = $this->loadModel($route['controller']);
    }

    private function loadModel($name)
    {
        $path = 'app\models\\' . str_replace('Controller', '', $name);
        if (class_exists($path)) {
            return new $path;
        }
    }
}