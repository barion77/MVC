<?php

namespace app\core;

class Route
{  
    private static $routes = [];

    public static function get(string $uri, $callback)
    {
        self::$routes['GET' . count(self::$routes)] = self::prepareUri($uri);
        $method = $_SERVER['REQUEST_METHOD'];

        if (preg_match(self::prepareUri($uri), self::getUri(), $matches)) {
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
        self::$routes['GET' . count(self::$routes)] = self::prepareUri($uri);
        $method = $_SERVER['REQUEST_METHOD'];

        if (preg_match(self::prepareUri($uri), self::getUri(), $matches)) {
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
        self::$routes['PUT' . count(self::$routes)] = self::prepareUri($uri);
        $method = isset($_POST['_method']) ? $_POST['_method'] : $_SERVER['REQUEST_METHOD'];

        if (preg_match(self::prepareUri($uri), self::getUri(), $matches)) {
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
        self::$routes['PATCH' . count(self::$routes)] = self::prepareUri($uri);
        $method = isset($_POST['_method']) ? $_POST['_method'] : $_SERVER['REQUEST_METHOD'];

        if (preg_match(self::prepareUri($uri), self::getUri(), $matches)) {
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
        self::$routes['DELETE' . count(self::$routes)] = self::prepareUri($uri);
        $method = isset($_POST['_method']) ? $_POST['_method'] : $_SERVER['REQUEST_METHOD'];

        if (preg_match(self::prepareUri($uri), self::getUri(), $matches)) {
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
        $value = self::getValueFromUri(self::getUri());

        if (class_exists($controller) && method_exists($controller, $action)) {
            $controller = new $controller($value);
            return $controller->$action();
        } else {
            abort(404, 'Not Found');
        }
    }

    public static function getUri()
    {
        $uri = trim($_SERVER['REQUEST_URI'], '/');
        $uri = (strpos($uri, '?')) ? substr($uri, 0, strpos($uri, '?')) : $uri;

        return $uri;
    }

    public static function prepareUri(string $uri)
    {
        // TODO: Правильная замена множество флагов
        $pattern = '/:[a-z\/]+/';
        $uri = '#^' . preg_replace($pattern, '[0-9]+', trim($uri, '/')) . '$#';

        return $uri;
    }

    public static function getValueFromUri(string $uri)
    {
        // TODO: Получение значений нескольких флагов
        $pattern = '/[1-9]+/';
        preg_match($pattern, $uri, $matches);

        if (count($matches) > 0) {
            $value = $matches[0];
            return $value;
        }
    }

    public static function check()
    {
        $request_uri = trim($_SERVER['REQUEST_URI'], '/');
        $request_method = isset($_POST['_method']) ? $_POST['_method'] : $_SERVER['REQUEST_METHOD'];
        $flag = true;

        foreach (self::$routes as $method => $uri) {
            $method = preg_replace('/\d/', '', $method);
            if (preg_match($uri, $request_uri)) {
                if ($method == $request_method) {
                    $flag = false;
                }
            }
        }

        if ($flag) {
            abort(404, 'Not Found');
        }
    }
}
