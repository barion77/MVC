<?php 

namespace app\core;

use \PDO;

class Model 
{
    private $db;
    protected $table;

    private $where = [];
    private $sort = '';
    private $limit = '';

    public function __construct()
    {
       $this->db = Database::getInstance();
    }

    public function all()
    {
        $result = $this->db->query('SELECT * FROM posts', $this->table);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $keys = array_keys($data);
        $fields = '(' . implode(', ', $keys) . ')';
        $keys = array_map(function($value) {
            return ':' . $value;
        }, $keys);

        $values = '(' . implode(', ', $keys) . ')';
        $result = $this->db->query('INSERT INTO ' . $this->table . ' ' . $fields . ' VALUES ' . $values, $data);
    }

    public function where(string $column, string $operator, string $operand)
    {
        $this->where[] = $column . " " . $operator . " '" . $operand . "'";

        return $this;
    }

    public function limit(string $limit)
    {
        $this->limit = "LIMIT " . $limit;

        return $this;
    }

    public function sort(string $sort)
    {
        $this->sort = $sort;

        return $this;
    }

    private function prepareWhereRequest(array $conditions)
    {
        $request = '';
        if (count($conditions) > 0) {
            $request = "WHERE ";
            foreach ($conditions as $key => $value) {
                if (count($conditions) > 1 && count($conditions) != $key + 1) {
                    $request .= $value . " AND ";
                } else {
                    $request .= $value;
                }
            }
        }

        return $request;
    }   

    public function get()
    {
        $where_request = $this->prepareWhereRequest($this->where);
        $sql = "SELECT * FROM " . $this->table . " " . $where_request . " " . $this->sort . " " . $this->limit;

        $result = $this->db->query(trim($sql, ' '));
        return $result->fetchAll();
    }
}