<?php

namespace app\core;

use app\exceptions\RouteException;

class Route
{
    private static $routes = [];
    private static $values = [];
    private static $patterns = [];

    private const PATTERN = '/:[a-z\d\._]+/';
    private const DEFAULT_PATTERN = '[1-9]+';

    public static function get(string $uri, $callback, $pattern = [])
    {
        self::addPattern($pattern);
        self::addRoute('GET', self::prepareUri($uri));
        $method = $_SERVER['REQUEST_METHOD'];
        if (preg_match(self::prepareUri($uri), self::getUri())) {
            if ($method == 'GET') {
                self::getValueFromUri($uri);
                if (is_string($callback)) {
                    echo self::stringHandler($callback);
                } else {
                    call_user_func($callback);
                }
            }
        }
    }

    public static function post(string $uri, $callback, $pattern = [])
    {
        self::addPattern($pattern);
        self::addRoute('POST', self::prepareUri($uri));
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

    public static function put(string $uri, $callback, $pattern = [])
    {
        self::addPattern($pattern);
        self::addRoute('PUT', self::prepareUri($uri));
        $method = isset($_POST['_method']) ? $_POST['_method'] : $_SERVER['REQUEST_METHOD'];

        if (preg_match(self::prepareUri($uri), self::getUri(), $matches)) {
            if ($method == 'PUT') {
                self::getValueFromUri($uri);
                if (is_string($callback)) {
                    echo self::stringHandler($callback);
                } else {
                    call_user_func($callback);
                }
            }
        }
    }

    public static function patch(string $uri, $callback, $pattern = [])
    {
        self::addPattern($pattern);
        self::addRoute('PATCH', self::prepareUri($uri));
        $method = isset($_POST['_method']) ? $_POST['_method'] : $_SERVER['REQUEST_METHOD'];

        if (preg_match(self::prepareUri($uri), self::getUri(), $matches)) {
            if ($method == 'PATCH') {
                self::getValueFromUri($uri);
                if (is_string($callback)) {
                    echo self::stringHandler($callback);
                } else {
                    call_user_func($callback);
                }
            }
        }
    }

    public static function delete(string $uri, $callback, $pattern = [])
    {
        self::addPattern($pattern);
        self::addRoute('DELETE', self::prepareUri($uri));
        $method = isset($_POST['_method']) ? $_POST['_method'] : $_SERVER['REQUEST_METHOD'];

        if (preg_match(self::prepareUri($uri), self::getUri(), $matches)) {
            if ($method == 'DELETE') {
                self::getValueFromUri($uri);
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
            $controller = new $controller(self::$values);
            return $controller->$action();
        } else {
            if (Config::getField('APP_DEBUG')) {
                throw new RouteException('Class or method does not exists ' . $controller . ' method: ' . $action);
            } else {
                if (Config::getField('APP_LOG')) {
                    logging('Class or method does not exists ' . $controller . ' method: ' . $action);
                }
                abort(404);
            }
        }
    }

    public static function getUri()
    {
        $uri = trim($_SERVER['REQUEST_URI'], '/');
        $uri = (strpos($uri, '?')) ? substr($uri, 0, strpos($uri, '?')) : $uri;

        return trim($uri, '/');
    }

    public static function prepareUri(string $uri)
    {
        $uri = trim($uri, '/');
        preg_match_all(self::PATTERN, $uri, $matches);
        foreach ($matches[0] as $parameter) {
            $parameter = trim($parameter, ':');
            if (isset(self::$patterns[$parameter])) {
                $pattern = '/:' . $parameter . '/';
                $replacement_pattern = self::$patterns[$parameter];
                $uri = preg_replace($pattern, $replacement_pattern, $uri);
            } else {
                $pattern = '/:' . $parameter . '/';
                $replacement_pattern = self::DEFAULT_PATTERN;
                $uri = preg_replace($pattern, $replacement_pattern, $uri);
            }
        }
        
        return '#^' . $uri . '$#';
    }

    public static function getValueFromUri($uri)
    {
        $uri = explode('/', trim($uri, '/'));
        $current_uri = explode('/', self::getUri());

        foreach ($uri as $key => $value) {
            if (preg_match(self::PATTERN, $value)) {
                $value = trim($value, ':');
                self::$values[$value] = $current_uri[$key];
            }
        }
    }

    public static function addRoute(string $method, string $route)
    {
        if (!isset(self::$routes[$route]) || self::$routes[$route] != $method) {
            self::$routes[$route] = $method;
        } else {
            throw new RouteException("Route [$route] already exists");
        }
    }

    public static function addPattern($pattern)
    {
        if (!empty($pattern)) {
            foreach ($pattern as $key => $value) {
                self::$patterns[$key] = $value;
            }
        }
    }


    public static function check()
    {
        $request_uri = trim($_SERVER['REQUEST_URI'], '/');
        $request_method = isset($_POST['_method']) ? $_POST['_method'] : $_SERVER['REQUEST_METHOD'];
        $flag = true;

        foreach (self::$routes as $uri => $method) {
            if (preg_match($uri, $request_uri)) {
                if ($method == $request_method) {
                    $flag = false;
                }
            }
        }

        if ($flag) {
            abort(404);
        }
    }
}
