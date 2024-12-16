<?php

namespace App\Repositories;

use App\main\App;

class OrderRepository extends Repository
{
    public function getTableName(): string
    {
        return 'orders';
    }

    public function getEntityClass()
    {
        return get_class(App::call()->Order);
    }

    public function getOrdersByUserId($user_id)
    {
        $sql = "SELECT orders.id, name, price, count, date, address, status, user_id 
                FROM orders 
                INNER JOIN order_list ON orders.id = order_list.order_id 
                INNER JOIN goods ON goods.id = order_list.good_id 
                      WHERE user_id = :user_id";

        return $this->db->findAll($sql, [':user_id' => $user_id]);
    }

    public function getAllOrders()
    {
        $sql = "SELECT orders.id, name, price, count, date, address, status, user_id 
                FROM orders 
                INNER JOIN order_list ON orders.id = order_list.order_id 
                INNER JOIN goods ON goods.id = order_list.good_id";
        return $this->db->findAll($sql);
    }

    public function deleteOrder($order_id)
    {
        $sql = "DELETE  `orders`, `order_list`
                FROM `orders` INNER JOIN `order_list` ON order_list.order_id = orders.id
                WHERE orders.id = :order_id";
        return $this->db->exec($sql, [':order_id' => $order_id]);
    }
    public function changeOrderStatus($order_id, $status)
    {
        $sql = "UPDATE orders SET status = :status WHERE id = :order_id";
        return $this->db->exec($sql, [':order_id' => $order_id, ':status' => $status]);
    }
}