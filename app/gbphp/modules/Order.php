<?php
namespace App\modules;

class Order extends Model
{
    public $id; //сущ
    public $user_id;
    public $address;
    public $phone;
    public $email;
    public $status;

    /**
     * Возвращает имя таблицы в базе данных
     * @return string
     */
    public function getTableName(): string //реп
    {
        return 'order';
    }

    public function getOne($id)
    {
        $tableName = $this->getTableName();
        $sql = "SELECT 
                    o.id AS orderId, oi.id AS orderItemId
                FROM 
                    order AS o
                LEFT JOIN order_item AS oi ON oi.order_id = o.id
                WHERE 
                    o.id = :id
                ";
        return $this->bd->find($sql, [':id' => $id]);
    }

    public function getAll()
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName}";
        return $this->bd->findAll($sql);
    }

    public function getSumOrders()
    {
        $sql = "";
        return $this->bd->findAll($sql);
    }

}