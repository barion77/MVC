<?php 

namespace app\controllers;

use app\core\Controller;

class PostController extends Controller
{
    public function index()
    {
        $posts = $this->model->where('id', '>', '2')->limit(1)->get();

        $this->view->layout = 'layouts.default';
        $this->view->render('post.index', 'Посты', ['posts' => $posts]);
    }
}