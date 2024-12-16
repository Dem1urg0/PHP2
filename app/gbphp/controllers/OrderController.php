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
            throw new \Exception("/auth/");
        }
    }

    public function setAction()
    {
        if (empty($user_id = App::call()->Request->sessionGet('user')['id'])
            || empty($cart = App::call()->Request->sessionGet('cart'))) {
            throw new \Exception("404");
        }
        $userData = [
            'id' => $user_id,
            'address' => '',
        ];
        App::call()->OrderService->orderFill($cart, $userData);
        return $this->oneAction();
    }

    public function deleteAction(){
        if (($user = App::call()->Request->sessionGet('user')) && ($order_id = App::call()->Request->post('id'))){
            $params = [
                'user_id' => $user['id'],
                'order_id' => $order_id
            ];
            App::call()->OrderService->deleteOrder($params);
        }
        header('Location: /orders/');
        return;
    }
}