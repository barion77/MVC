<?php

namespace app\core;

use app\config\Config;
use ErrorException;

class Route
{
    private static $flag = false;

    private const GET = 'GET';
    private const POST = 'POST';

    public static function get($uri, $params)
    {
        $current_uri = trim($_SERVER['REQUEST_URI'], '/');
        $route = '#^' . trim($uri, '/') . '$#';

        if (preg_match($route, $current_uri, $matches)) {
            $controller = 'app\controllers\\' . explode('@', $params)[0];
            $action = explode('@', $params)[1];
            if (class_exists($controller)) {
                if (method_exists($controller, $action)) {
                    $controller = new $controller($params, self::GET);
                    $controller->$action();
                    self::$flag = true;
                } else {
                    throw new ErrorException(`Method $action in class $controller does not exist`);
                }
            } else {
                throw new ErrorException(`Class $controller does not exist`);
            }
        }
    }

    public static function check()
    {
        if (!self::$flag) {
            echo '404 Not Found';
        } else {
            self::$flag = false;
        }
    }
}
