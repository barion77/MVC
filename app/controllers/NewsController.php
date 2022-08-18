<?php 

namespace app\controllers;

use app\core\Controller;
use app\core\View;

class NewsController extends Controller
{
    public function index()
    {
        // $this->view->layout = 'layouts.default';
        // $this->view->render(['content' => 'news.index']);

        return '123';
    }

    public function update()
    {
        return $this->values['slug'];
    }
}