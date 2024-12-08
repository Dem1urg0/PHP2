<?php

namespace App\services;

use App\main\App;

class OrderService
{
    public function orderFill($cart, $userData)
    {
        if (empty($cart) || empty($userData)) {
            return [
                'msg' => 'Пустые значения',
                'success' => false,
            ];
        }
        $order = App::call()->Order;
        $orderItem = App::call()->OrderItem;

        $order->user_id = $userData['id'];
        $order->address = $userData['address'];

        $orderItem->order_id = App::call()->OrderRepository->save($order);

        foreach ($cart as $item) {
            $orderItem->good_id = $item['id'];
            $orderItem->count = $item['count'];
            App::call()->OrderItemRepository->save($orderItem);
        }
        App::call()->Request->sessionSet('cart', []);
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
                    if (empty($orderSort[$id]['info'])){
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
        return $orderSort; // todo проверить работу
    }
}