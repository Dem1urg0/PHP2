<?php

namespace App\controllers;

use App\main\App;

class AdminController extends Controller
{
    protected $defaultAction = 'index';

    public function run($action){
        App::call()->RoleMiddleware->checkAdmin();

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
}