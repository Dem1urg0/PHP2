<?php

namespace App\controllers;

use App\main\App;

class AdminController extends Controller
{
    protected $defaultAction = 'index';

    public function run($action)
    {
        if (!App::call()->RoleMiddleware->checkAdmin()){
            return header('Location: /404');
        }
        return parent::run($action);
    }

    public function indexAction()
    {
        return $this->render->render('admin/index');
    }

    public function ordersAction()
    {
        $orders = App::call()->OrderRepository->getAllOrders();
        $sortOrders = App::call()->OrderService->sortProductsInOrders($orders);

        return $this->render('orders',
            [
                'orders' => $sortOrders,
            ]);
    }

    public function changeOrderStatusAction()
    {
        if (!App::call()->Request->isPost()) {
            header('Location: /admin/orders');
        }
        $params = [
            'order_id' => $this->request->post('id'),
            'status' => $this->request->post('status')
        ];
        App::call()->OrderService->changeOrderStatus($params);

        header('Location: /admin/orders');
    }
}