<?php 

namespace app\core;

use app\config\Config;
use PDO;

class Model 
{
    protected $table;
    protected $connect;

    public function __construct()
    {
        $this->connect = new PDO('mysql:host=' . Config::db_host . ';dbname=' . Config::db_name . '', Config::db_login, Config::db_password); 
    }

    private function query($sql, $params = [])
    {
        $stmt = $this->connect->prepare($sql);
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }
        }

        $stmt->execute();
        return $stmt;
    }


    public function row($sql, $params = []) 
    {
        $result = $this->query($sql, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function column($sql, $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetchColumn();
    }

    public function sqlExec($sql, $params = [])
    {
        $sql = $this->query($sql, $params);
    }
}