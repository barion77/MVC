<?php

namespace app\core;

class View
{
    private $path;
    public $route;
    public $layout = 'default';

    public function __construct($route)
    {
        $this->route = $route;
        $this->path = $route['view'];
    }

    public function render($title_view_page, $variables = [])
    {
        if (file_exists('../app/views/' . $this->path . '.php')) {
            extract($variables);
            ob_start();
            require '../app/views/' . $this->path . '.php';
            $view_page = ob_get_clean();
            require '../app/views/layouts/' . $this->layout . '.php';
        } 
    }

    public function redirect($url)
    {
        header('Location: ' . $url);
        exit;
    }

    public static function response_code($code, $msg)
    {
        http_response_code($code);
        require '../app/views/response.php';
        exit;
    }
}
