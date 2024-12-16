<?php

namespace App\services;

use App\main\App;

class OrderService
{
    private $orderStatuses = [
        'created', 'in delivery', 'delivered'
    ];

    public function orderFill($cart, $userData)
    {
        if (empty($cart) || empty($userData)) {
            return [
                'msg' => 'Пустые значения',
                'success' => false,
            ];
        }
        $order = $this->getOrderObj();
        $orderItem = $this->getOrderItemObj();

        $order->user_id = $userData['id'];
        $order->address = $userData['address'];

        $orderItem->order_id = $this->saveOrder($order);

        foreach ($cart as $item) {
            $orderItem->good_id = $item['id'];
            $orderItem->count = $item['count'];
            $this->saveOrderItem($orderItem);
        }
        $this->sessionSet('cart', []);
        return [
            'msg' => 'Заказ создан',
            'success' => true,
        ];
    }

    public function sortProductsInOrders($orders)
    {
        if (empty($orders)) {
            return [];
        }

        $orderSort = [];
        $orders_id = [];

        foreach ($orders as $order) {
            $orders_id[] = $order->id;
        }
        $orders_id = array_unique($orders_id);

        foreach ($orders_id as $id) {
            foreach ($orders as $order) {
                if ($order->id == $id) {
                    if (empty($orderSort[$id]['info'])) {
                        $orderSort[$id]['info'] = [
                            'user_id' => $order->user_id,
                            'date' => $order->date,
                            'address' => $order->address,
                            'status' => $order->status
                        ];
                    }
                    $orderSort[$id]['products'][] = [
                        'name' => $order->name, //item name/price/ ...
                        'price' => $order->price,
                        'count' => $order->count,
                    ];
                }
            }
        }
        return $orderSort;
    }

    public function deleteOrder($params)
    {
        if ($this->deleteHasError($params)) {
            return [
                'success' => false,
                'msg' => 'Нет данных'
            ];
        }

        if (empty($this->getOrderById($params['order_id'])) ||
            (!$this->adminCheck() && $this->sessionGet('user')['id'] != $params['user_id'])) {
            return [
                'success' => false,
                'msg' => 'Неверные данные'
            ];
        }

        $this->deleteOrderFromDB($params['order_id']);

        return [
            'success' => true,
            'msg' => 'Заказ удален'
        ];

    }

    public function changeOrderStatus($params)
    {
        if ($this->changeHasError($params)) {
            return [
                'success' => false,
                'msg' => 'Нет данных'
            ];
        }

        if (empty($this->getOrderById($params['order_id']))
            || !in_array($params['status'], $this->orderStatuses)) {
            return [
                'success' => false,
                'msg' => 'Не вернные данные'
            ];
        }

        $this->changeOrderStatusInDB($params['order_id'], $params['status']);

        return [
            'success' => true,
            'msg' => 'Статус изменен'
        ];
    }

    public function changeHasError($params)
    {

        if (empty($params['order_id']) || empty($params['status'])) {
            return true;
        } else return false;
    }

    public function deleteHasError($params)
    {
        if (empty($params['user_id']) || empty($params['order_id'])) {
            return true;
        } else return false;
    }

    protected function getOrderObj()
    {
        return App::call()->Order;
    }

    protected function getOrderItemObj()
    {
        return App::call()->OrderItem;
    }

    protected function saveOrder($order)
    {
        return App::call()->OrderRepository->save($order);
    }

    protected function saveOrderItem($orderItem)
    {
        return App::call()->OrderItemRepository->save($orderItem);
    }

    protected function sessionSet($name, $value)
    {
        return App::call()->Request->sessionSet($name, $value);
    }

    protected function getOrderById($id)
    {
        return App::call()->OrderRepository->getOne($id);
    }

    protected function adminCheck()
    {
        return App::call()->RoleMiddleware->checkAdmin();
    }

    protected function sessionGet($name)
    {
        return App::call()->Request->sessionGet($name);
    }

    protected function deleteOrderFromDB($id)
    {
        return App::call()->OrderRepository->deleteOrder($id);
    }

    protected function changeOrderStatusInDB($id, $status)
    {
        return App::call()->OrderRepository->changeOrderStatus($id, $status);
    }
}