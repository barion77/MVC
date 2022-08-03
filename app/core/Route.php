<?php

namespace app\core;

use app\config\Config;
use Exception;

class Route
{
    private static $routes = [];

    public static function get($uri, $params)
    {
        self::$routes[] = $uri . '-' . 'GET';
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
                        abort(404, 'Not Found');
                    }
                }
            } else {
                if (Config::debug) {
                    throw new Exception(`Class: $controller does not exist`);
                } else {
                    abort(404, 'Not Found');
                }
            }
        }
    }

    public static function post($uri, $params)
    {
        self::$routes[] = $uri . '-' . 'POST';
        $method = $_SERVER['REQUEST_METHOD'];
        $current_uri = $_SERVER['REQUEST_URI'];
        $route = ['uri', 'params', 'method'];

        if ($method == 'POST' && $current_uri == $uri) {
            $controller = 'app\controllers\\' . explode('@', $params)[0];
            $action = explode('@', $params)[1];
            if (class_exists($controller)) {
                if (method_exists($controller, $action)) {
                    $route = array_combine($route, array($current_uri, $params, $method));
                    $controller = new $controller($route);
                    $controller->$action();
                } else {
                    if (Config::debug) {
                        throw new Exception(`Action: $action does not exist in $controller`);
                    } else {
                        abort(404, 'Not Found');
                    }
                }
            } else {
                if (Config::debug) {
                    throw new Exception(`Class: $controller does not exist`);
                } else {
                    abort(404, 'Not Found');
                }
            }
        }
    }

    public static function put($uri, $params)
    {
        self::$routes[] = $uri . '-' . 'PUT';

        $method = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['_method'])) {
                $method = strtoupper($_POST['_method']);  
            }
        }

        $current_uri = $_SERVER['REQUEST_URI'];
        $route = ['uri', 'params', 'method'];

        if ($method == 'PUT' && $current_uri == $uri) {
            $controller = 'app\controllers\\' . explode('@', $params)[0];
            $action = explode('@', $params)[1];
            if (class_exists($controller)) {
                if (method_exists($controller, $action)) {
                    $route = array_combine($route, array($current_uri, $params, $method));
                    $controller = new $controller($route);
                    $controller->$action();
                } else {
                    if (Config::debug) {
                        throw new Exception(`Action: $action does not exist in $controller`);
                    } else {
                        abort(404, 'Not Found');
                    }
                }
            } else {
                if (Config::debug) {
                    throw new Exception(`Class: $controller does not exist`);
                } else {
                    abort(404, 'Not Found');
                }
            }
        }
    }

    public static function patch($uri, $params)
    {
        self::$routes[] = $uri . '-' . 'PATCH';

        $method = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['_method'])) {
                $method = $_POST['_method'];
            }
        }

        $current_uri = $_SERVER['REQUEST_URI'];
        $route = ['uri', 'params', 'method'];

        if ($method == 'PATCH' && $current_uri == $uri) {
            $controller = 'app\controllers\\' . explode('@', $params)[0];
            $action = explode('@', $params)[1];
            if (class_exists($controller)) {
                if (method_exists($controller, $action)) {
                    $route = array_combine($route, array($current_uri, $params, $method));
                    $controller = new $controller($route);
                    $controller->$action();
                } else {
                    if (Config::debug) {
                        throw new Exception(`Action: $action does not exist in $controller`);
                    } else {
                        abort(404, 'Not Found');
                    }
                }
            } else {
                if (Config::debug) {
                    throw new Exception(`Class: $controller does not exist`);
                } else {
                    abort(404, 'Not Found');
                }
            }
        }
    }

    public static function delete($uri, $params)
    {
        self::$routes[] = $uri . '-' . 'DELETE';

        $method = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['_method'])) {
                $method = $_POST['_method'];
            }
        }

        $current_uri = $_SERVER['REQUEST_URI'];
        $route = ['uri', 'params', 'method'];

        if ($method == 'DELETE' && $current_uri == $uri) {
            $controller = 'app\controllers\\' . explode('@', $params)[0];
            $action = explode('@', $params)[1];
            if (class_exists($controller)) {
                if (method_exists($controller, $action)) {
                    $route = array_combine($route, array($current_uri, $params, $method));
                    $controller = new $controller($route);
                    $controller->$action();
                } else {
                    if (Config::debug) {
                        throw new Exception(`Action: $action does not exist in $controller`);
                    } else {
                        abort(404, 'Not Found');
                    }
                }
            } else {
                if (Config::debug) {
                    throw new Exception(`Class: $controller does not exist`);
                } else {
                    abort(404, 'Not Found');
                }
            }
        }
    }

    public static function check()
    {
        $method = isset($_POST['_method']) ? $_POST['_method'] : $_SERVER['REQUEST_METHOD'];

        if (!in_array($_SERVER['REQUEST_URI'] . '-' . $method, self::$routes)) {
            abort(404, 'Not Found');
        }
    }
}
