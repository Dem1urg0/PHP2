<?php

namespace App\modules\Repositories;

use App\services\DB;
use \App\modules\Entities\Model;

abstract class Repository
{
    protected $bd;
    protected $model;

    public function __construct(Model $model)
    {
        $this->bd = DB::getInstance();
        $this->model = $model;

    }

    public function getTableName()
    {
        return $this->model->getTableName();
    }

    public function getOne($id)
    {
        $this->model->id = $id;
        if (!$this->model->checkFillParams(['id'])) {
            return 'Не все параметры заполнены';
        }
        $tableName = $this->model->getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE id = :id";
        return $this->bd->queryObject($sql, get_class($this->model), [':id' => $id]);
    }

    public function getAll()
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName}";
        return $this->bd->queryObjects($sql, get_class($this->model));
    }

    public function delete()
    {
        $tableName = $this->model->getTableName();
        if (!$this->model->checkFillParams(['id'])) {
            return 'Не все параметры заполнены';
        }
        $sql = "DELETE FROM {$tableName} WHERE id = :id";
        $this->bd->exec($sql, [':id' => $this->model->id]);
    }

    public function save()
    {
        if (!empty($this->model->id)) {
            if ($this->getOne($this->model->id)) {
                $this->update();
            } else {
                $this->insert();
            }
        } else {
            $this->insert();
        }
    }

    private function insert()
    {
        if (!$this->model->checkFillParams(['name', 'price'])) {
            return 'Не все параметры заполнены';
        }

        $tableName = $this->getTableName();
        $sql = "INSERT INTO {$tableName} ({$this->getParams('names', $this->model)}) VALUES ({$this->getParams('values', $this->model)})";
        $this->bd->exec($sql, $this->getParams('params', get_class($this->model)));
    }

    private function update()
    {
        if (!$this->getParams('equality', ['id'])) {
            return 'Не все параметры заполнены';
        }

        $tableName = $this->getTableName();
        $sql = "UPDATE {$tableName} SET {$this->getParams('equality', ['id'])} WHERE id = :id";
        $this->bd->exec($sql, $this->getParams('params', get_class($this->model)));
    }

    private function getParams($name, $filter = [])
    {
        $paramsReq = [];
        foreach ($this->model as $param => $value) {
            if ($this->model->checkParams($param) || in_array($param, $filter)) {
                continue;
            }
            switch ($name) {
                case 'names':
                    $paramsReq[] = $param;
                    break;
                case 'values':
                    $paramsReq[] = ':' . $param;
                    break;
                case 'params':
                    $paramsReq[':' . $param] = $value;
                    break;
                case 'equality':
                    $paramsReq[] = $param . ' = :' . $param;
                    break;
            }
        }
        switch ($name) {
            case 'names':
            case 'values':
            case 'equality':
                return implode(', ', $paramsReq);
            case 'params':
                return $paramsReq;
            default:
                return null;
        }
    }
    public function setParams($params)
    {
        foreach ($params as $param => $value) {
            $this->model->$param = $value;
        }
    }
}
