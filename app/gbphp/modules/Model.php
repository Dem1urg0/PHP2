<?php

namespace App\modules;

use App\services\DB;

/**
 * Class Model
 */
abstract class Model
{
    /**
     * @var DB
     */
    protected $bd;

    public function __construct()
    {
        $this->bd = DB::getInstance();
    }

    /**
     * Возвращает имя таблицы в базе данных
     * @return string
     */
    abstract public function getTableName(): string;

    public function getOne($id)
    {
        $this->id = $id;
        if (!$this->checkFillParams(['id'])) {
            return 'Не все параметры заполнены';
        }
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE id = :id";
        return $this->bd->queryObject($sql, static::class, [':id' => $id]);
    }

    public function getAll()
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName}";
        return $this->bd->queryObjects($sql, static::class);
    }

    public function delete()
    {
        $tableName = $this->getTableName();
        if (!$this->checkFillParams(['id'])) {
            return 'Не все параметры заполнены';
        }
        $sql = "DELETE FROM {$tableName} WHERE id = :id";
        $this->bd->exec($sql, [':id' => $this->id]);
    }

    private function insert()
    {
        if (!$this->checkFillParams(['name', 'price'])) {
            return 'Не все параметры заполнены';
        }
        $tableName = $this->getTableName();
        $sql = "INSERT INTO {$tableName} ({$this->getParams('names')}) VALUES ({$this->getParams('values')})";
        $this->bd->exec($sql, $this->getParams('params'));
    }

    private function update()
    {
        if (!$this->getParams('equality', ['id'])) {
            return 'Не все параметры заполнены';
        }
        $tableName = $this->getTableName();
        $sql = "UPDATE {$tableName} SET {$this->getParams('equality', ['id'])} WHERE id = :id";
        $this->bd->exec($sql, $this->getParams('params'));
    }

    public function save()
    {
        $isBusyId = false;
        if (!empty($this->id)) {
            $isBusyId = $this->getOne($this->id);
        }
        if (!$isBusyId) {
            $this->insert();
            return;
        }
        $this->update();
    }

    public function filling($params)
    {
        foreach ($params as $param => $value) {
            if ($this->checkParams($param)) {
                continue;
            }
            if (property_exists($this, $param)) {
                $this->$param = $value;
            }
        }
    }

    public function getParams($name, $filter = [])
    {
        $paramsReq = [];
        foreach ($this as $param => $value) {
            if ($this->checkParams($param) || in_array($param, $filter)) {
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

    public function checkParams($param)
    {
        if ($param == 'bd' || $param == 'names' || $param == 'values' || $param == 'params') {
            return true;
        } else {
            return false;
        }
    }

    public function checkFillParams($params = ['id', 'name', 'price'])
    {
        foreach ($params as $param) {
            if (empty($this->$param)) {
                return false;
            }
        }
        return true;
    }
}