<?php

namespace App\controllers;

use App\main\App;

class OrderController extends Controller
{
    protected $defaultAction = 'one';

    public function oneAction()
    {
        if ($user = App::call()->Request->sessionGet('user')) {
            $user_id = $user['id'];
            $orders = App::call()->OrderRepository->getOrdersByUserId($user_id);
            $sortOrders = App::call()->OrderService->sortProductsInOrders($orders);
            return $this->render('orders',
                [
                    'orders' => $sortOrders,
                ]);
        } else {
            throw new \Exception("404");
        }
    }

    //todo смена статуса заказа
    public function setAction()
    {
        if (empty($userId = App::call()->Request->sessionGet('user')['id'])
            || empty($cart = App::call()->Request->sessionGet('cart'))) {
            return;
        }
        $userData = [
            'id' => $userId,
            'address' => '',
        ];
        App::call()->OrderService->orderFill($cart, $userData);
        return $this->oneAction();
    }

}