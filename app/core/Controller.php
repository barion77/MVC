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
        $this->view = new View();
        $this->model = new Model();
    }
}