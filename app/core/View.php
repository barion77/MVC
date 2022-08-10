<?php

namespace app\core;

class View
{
    public $layout;
    public $config;

    public function __construct()
    {
        $this->config = require_once '../config/view.php';
    }

    public function render($view, $view_title, $variables = [])
    {
        $this->layout = $this->config['path'] . str_replace('.', '/', $this->layout) . '.php';
        $view = $this->config['path'] . str_replace('.', '/', $view) . '.php';
        if (file_exists($this->layout)) {
            extract($variables);
            unset($variables);
            if (file_exists($view)) {
                ob_start();
                require $view;
                unset($view);
                $view_content = ob_get_clean();
            }

            require $this->layout;
        }
    }
    
}
