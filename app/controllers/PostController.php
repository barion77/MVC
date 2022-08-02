<?php 

namespace app\controllers;

use app\core\Controller;
use app\models\Post;

class PostController extends Controller
{
    public function index()
    {
        $this->view->layout = 'layouts.default';
        $this->view->render(['content' => 'post.index']);
    }
}