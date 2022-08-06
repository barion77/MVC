<?php 

namespace app\core;

use app\core\Config;
use PDO;

class Model 
{
    protected $table;
    protected $connect;

    public function __construct()
    {
        $config = Config::getSection('database');
        $this->connect = new PDO('mysql:host=' . $config['DB_HOST'] . ';dbname=' . $config['DB_DATABASE'] . '', $config['DB_USERNAME'], $config['DB_PASSWORD']); 
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