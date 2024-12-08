<?php

namespace App\services;

use App\main\App;

class CartService
{
    public function getCart()
    {
        $cart = [];
        if ($cartSession = $this->isCartExist()) {
            foreach ($cartSession as $product) {
                if ($item = get_object_vars(App::call()->GoodRepository->getOne($product['id']))) {
                    $cart[] = [
                        'id' => $item['id'],
                        'name' => $item['name'],
                        'price' => $item['price'],
                        'count' => $product['count']
                    ];
                }
            }
        }
        return $cart;
    }

    public function addToCart($id)
    {
        if ($cart = $this->isCartExist()) {
            foreach ($cart as $key => $product) {
                if ($product['id'] == $id) {
                    $cart[$key]['count'] += 1;
                    App::call()->Request->sessionSet('cart', $cart);
                    return;
                }
            }
            $cart[] = ['id' => $id, 'count' => 1];
            App::call()->Request->sessionSet('cart', $cart);
        } else {
            App::call()->Request->sessionSet('cart', [['id' => $id, 'count' => 1]]);
        }
    }

    public function decCart($id)
    {
        if (!$cart = $this->isCartExist()) {
            throw new \Exception("404");
        }

        foreach ($cart as $key => $product) {
            if ($product['id'] == $id) {
                if ($cart[$key]['count'] > 1) {
                    $cart[$key]['count'] -= 1;
                    App::call()->Request->sessionSet('cart', $cart);
                    return;
                } else {
                    $this->deleteAction();
                    return;
                }
            }
        }
    }

    public function deleteFromCart($id){
        if (!$cart = $this->isCartExist()) {
            throw new \Exception("404");
        }

        $cart = App::call()->Request->sessionGet('cart');

        foreach ($cart as $key => $product) {
            if ($product['id'] == $id) {
                unset($cart[$key]);
                App::call()->Request->sessionSet('cart', $cart);
                return;
            }
        }
    }

    private function isCartExist()
    {
        if ($cart = App::call()->Request->sessionGet('cart')) {
            return $cart;
        } else return false;
    }
}