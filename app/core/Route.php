<?php

namespace app\core;

use app\core\View;

class Route 
{
    protected $routes = [];
    protected $params = [];


    public function __construct()
    {
        $arr = require '../app/config/routes.php';
        foreach ($arr as $key => $value) {
            $this->add($key, $value);
        }
    }

    public function add($route, $params)
    {
        $route = '#^' . $route . '$#';
        $this->routes[$route] = $params;
    }

    public function match()
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        foreach ($this->routes as $key => $value) {
            if (preg_match($key, $url, $matches)) {
                $this->params = $value;
                return true;
            }
        }

        return false;
    }

    public function run()
    {
        if ($this->match()) {
            $path = 'app\controllers\\' . $this->params['controller'];
            if (class_exists($path)) {
                $action = $this->params['action'];
                if (method_exists($path, $action)) {
                    $controller = new $path($this->params);
                    $controller->$action();
                } else {
                    View::response_code(404, '404 Not Found');
                }
            } else {
                View::response_code(404, '404 Not Found'); 
            }
        } else {
            View::response_code(404, '404 Not Found');
        }
    }

}