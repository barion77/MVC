<?php 

namespace app\controllers;

use app\core\Controller;
use app\core\View;

class NewsController extends Controller
{
    public function index()
    {
        $this->view->layout = 'layouts.default';
        $this->view->render(['content' => 'news.index'], ['count' => 20]);
    }
}