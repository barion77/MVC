<?php

namespace app\core;

use app\config\Config;
use ErrorException;

class Route
{
    private static $routes = [];

    public static function get($uri, $params)
    {
        self::$routes[] = $uri;
        $method = $_SERVER['REQUEST_METHOD'];
        $current_uri = $_SERVER['REQUEST_URI'];

        if ($method == 'GET' && $current_uri == $uri) {
            $controller = 'app\controllers\\' . explode('@', $params)[0];
            $action = explode('@', $params)[1];
            if (class_exists($controller) && method_exists($controller, $action)) {
                $controller = new $controller($params);
                $controller->$action();
            }
        }
    }

    public static function post($uri, $params)
    {
        self::$routes[] = $uri;
        $method = $_SERVER['REQUEST_METHOD'];
        $current_uri = $_SERVER['REQUEST_URI'];

        if ($method == 'GET' && $current_uri == $uri) {
            $controller = 'app\controllers\\' . explode('@', $params)[0];
            $action = explode('@', $params)[1];
            if (class_exists($controller) && method_exists($controller, $action)) {
                $controller = new $controller($params);
                $controller->$action();
            }
        }
    }

    public static function check()
    {
        if (!in_array($_SERVER['REQUEST_URI'], self::$routes)) {
            echo '<h1>404 Not Found</h1>';
            exit;
        }
    }
}
