<?php 

namespace app\core;

use app\core\View;

abstract class Controller 
{
    public $model;
    public $view;
    public $values;

    public function __construct($values = null)
    {
        $this->view = new View();
        $this->model = new Model();
        $this->values = $values;
    }
}