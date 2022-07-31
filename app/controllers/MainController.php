<?php 

namespace app\controllers;

use app\core\Controller;
use app\database\DB;

class MainController extends Controller
{
    public function index()
    {
        $db = new DB;
        $this->view->render('Главная страница');
    }
}