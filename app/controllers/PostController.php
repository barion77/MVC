<?php 

namespace app\controllers;

use app\core\Controller;
use app\models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = $this->model->getPosts();

        $this->view->render('Посты', [
            'posts' => $posts
        ]);
    }
}