<?php

namespace app\core;

class View
{
    public $layout;
    public static $sectionValues = [];

    public function render($views = [], $variables = [])
    {
        $this->layout = '../app/views/' . str_replace('.', '/', $this->layout) . '.php';

        if (file_exists($this->layout)) {
            extract($variables);

            foreach ($views as $view => $path) {
                $path = '../app/views/' . str_replace('.', '/', $path) . '.php';
                if (file_exists($path)) {
                    ob_start();
                    require '../app/classes/template.php';
                    require $path;
                    $views[$view] = ob_get_clean();
                }
            }

            extract($views);

            require $this->layout;
        }
    }
    
}
