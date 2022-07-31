<?php

namespace app\models;

use app\core\Model;

class Post extends Model
{
    public function getPosts()
    {
        return $this->DB->row('SELECT * FROM posts');
    }
}