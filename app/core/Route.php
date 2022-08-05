<?php

namespace app\core;

class Route
{
    private static $routes = [];

    public static function get(string $uri, $callback)
    {
        self::$routes[] = $uri . '-' . 'GET';
        $method = $_SERVER['REQUEST_METHOD'];

        if (self::getUri() == $uri) {
            if ($method == 'GET') {
                if (is_string($callback)) {
                    echo self::stringHandler($callback);
                } else {
                    call_user_func($callback);
                }
            }
        }
    }

    public static function post(string $uri, $callback)
    {
        self::$routes[] = $uri . '-' . 'POST';
        $method = $_SERVER['REQUEST_METHOD'];

        if (self::getUri() == $uri) {
            if ($method == 'POST') {
                if (is_string($callback)) {
                    echo self::stringHandler($callback);
                } else {
                    call_user_func($callback);
                }
            }
        }
    }

    public static function put(string $uri, $callback)
    {
        self::$routes[] = $uri . '-' . 'PUT';
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'POST') {
            if (isset($_POST['_method'])) {
                $method = strtoupper($_POST['_method']);
            }
        }

        if (self::getUri() == $uri) {
            if ($method == 'PUT') {
                if (is_string($callback)) {
                    echo self::stringHandler($callback);
                } else {
                    call_user_func($callback);
                }
            }
        }
    }

    public static function patch(string $uri, $callback)
    {
        self::$routes[] = $uri . '-' . 'PATCH';
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'POST') {
            if (isset($_POST['_method'])) {
                $method = strtoupper($_POST['_method']);
            }
        }

        if (self::getUri() == $uri) {
            if ($method == 'PATCH') {
                if (is_string($callback)) {
                    echo self::stringHandler($callback);
                } else {
                    call_user_func($callback);
                }
            }
        }
    }

    public static function delete(string $uri, $callback)
    {
        self::$routes[] = $uri . '-' . 'DELETE';
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'POST') {
            if (isset($_POST['_method'])) {
                $method = strtoupper($_POST['_method']);
            }
        }

        if (self::getUri() == $uri) {
            if ($method == 'DELETE') {
                if (is_string($callback)) {
                    echo self::stringHandler($callback);
                } else {
                    call_user_func($callback);
                }
            }
        }
    }

    public static function stringHandler($string) 
    {
        if (strpos($string, '@')) {
            return self::classHandler($string);
        } else {
            return $string;
        }
    }

    public static function classHandler($string)
    {
        $params = explode('@', $string);
        $controller = 'app\controllers\\' . $params[0];
        $action = $params[1];

        if (class_exists($controller) && method_exists($controller, $action)) {
            $controller = new $controller();
            return $controller->$action();
        } else {
            abort(404, 'Not Found');
        }
    }

    public static function getUri()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $uri = (strpos($uri, '?')) ? substr($uri, 0, strpos($uri, '?')) : $uri;
        return $uri;
    }

    public static function check()
    {
        $method = isset($_POST['_method']) ? $_POST['_method'] : $_SERVER['REQUEST_METHOD'];

        if (!in_array(self::getUri() . '-' . $method, self::$routes)) {
            abort(404, 'Not Found');
        }
    }
}
