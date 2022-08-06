<?php 

namespace app\controllers;

use app\core\Controller;

class PostController extends Controller
{
    public function index()
    {
        $posts = $this->model->row('SELECT * FROM posts');

        $this->view->layout = 'layouts.default';
        $this->view->render(['content' => 'post.index'], ['posts' => $posts]);
    }
}