<?php 

namespace app\core;

use app\database\DB;

class Model 
{
    public $DB;

    public function __construct()
    {
        $this->DB = new DB;
    }
}