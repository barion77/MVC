<?php 

namespace app\database;

use PDO;

class DB 
{

    protected $connect;

    public function __construct()
    {
        $config = require '../app/config/db.php';
        $this->connect = new  PDO('mysql:host=' . $config['host'] . ';' . 'dbname=' . $config['dbname'] . '', $config['login'], $config['password']);
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

}