<?php

namespace engine;

abstract class DB implements IDB
{
    private $link;
    protected $table;

    public function __construct()
    {
        $this->link = mysqli_connect('mariadb', 'root', 'rootroot', 'dbphp');
    }

    private function request($sql)
    {
        $result = mysqli_fetch_all(mysqli_query($this->link, $sql));
        return $result;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->request($sql);
    }

    public function getOne($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = {$id}";
        return $this->request($sql);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM $this->table WHERE id = {$id}";
        $this->request($sql);
    }

    public function update($id, $fields, $values)
    {
        $sql = "UPDATE $this->table SET";
        foreach ($fields as $field) {
            foreach ($values as $value) {
                $sql .= " $field = $value,";
            }
        }
        $sql .= " WHERE id ={$id}";
        $this->request($sql);
    }

    public function insert($fields, $values)
    {
        $sql = "INSERT INTO $this->table (";
        foreach ($fields as $field) {
            $sql .= "$field,";
        }
        $sql .= ") VALUES (";
        foreach ($values as $value) {
            $sql .= "$value,";
        }
        $sql .= ")";
        $this->request($sql);
    }
}