<?php 

namespace app\core;

use app\core\View;

abstract class Controller 
{
    public $model;
    public $view;
    public $value;

    public function __construct($value = null)
    {
        $this->view = new View();
        $this->model = new Model();
        $this->value = $value;
    }
}