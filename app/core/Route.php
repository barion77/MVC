<?php

namespace app\core;

use app\config\Config;
use ErrorException;
use Exception;

class Route
{
    private static $routes = [];

    public static function get($uri, $params)
    {
        self::$routes[] = $uri;
        $method = $_SERVER['REQUEST_METHOD'];
        $current_uri = $_SERVER['REQUEST_URI'];
        $route = ['uri', 'params', 'method'];

        if ($method == 'GET' && $current_uri == $uri) {
            $route = array_combine($route, array($current_uri, $params, $method));
            $controller = 'app\controllers\\' . explode('@', $params)[0];
            $action = explode('@', $params)[1];
            if (class_exists($controller)) {
                if (method_exists($controller, $action)) {
                    $controller = new $controller($route);
                    $controller->$action();
                } else {
                    if (Config::debug) {
                        throw new Exception(`Action: $action does not exist in $controller`);
                    } else {
                        echo '404 Not Found';
                        exit;
                    }
                }
            } else {
                if (Config::debug) {
                    throw new Exception(`Class: $controller does not exist`);
                } else {
                    echo '404 Not Found';
                    exit;
                }
            }
        }
    }

    public static function post($uri, $params)
    {
        self::$routes[] = $uri;
        $method = $_SERVER['REQUEST_METHOD'];
        $current_uri = $_SERVER['REQUEST_URI'];
        $route = ['uri', 'params', 'method'];

        if ($method == 'POST' && $current_uri == $uri) {
            $route = array_combine($route, array($current_uri, $params, $method));
            $controller = 'app\controllers\\' . explode('@', $params)[0];
            $action = explode('@', $params)[1];
            if (class_exists($controller)) {
                if (method_exists($controller, $action)) {
                    $controller = new $controller($route);
                    $controller->$action();
                } else {
                    if (Config::debug) {
                        throw new Exception(`Action: $action does not exist in $controller`);
                    } else {
                        echo '404 Not Found';
                        exit;
                    }
                }
            } else {
                if (Config::debug) {
                    throw new Exception(`Class: $controller does not exist`);
                } else {
                    echo '404 Not Found';
                    exit;
                }
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
