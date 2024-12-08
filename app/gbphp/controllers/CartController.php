<?php

namespace App\controllers;

use App\main\App;
use function PHPUnit\Framework\throwException;

class CartController extends Controller
{
    protected $defaultAction = 'all';

    public function allAction()
    {
        $cart = App::call()->CartService->getCart();
        return $this->render('cart', [
            'cart' => $cart
        ]);
    }

    public function addAction()
    {

        App::call()->CartService->addToCart($this->PostId());
    }

    public function decAction()
    {
        App::call()->CartService->decCart($this->PostId());
    }


    public function deleteAction()
    {
        App::call()->CartService->deleteFromCart($this->PostId());
    }

    public function PostId()
    {
        $id = App::call()->Request->post('id');
        if ($id == []) {
            throw new \Exception("404");
        } else {
            return $id;
        }
    }
}