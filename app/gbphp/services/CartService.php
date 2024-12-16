<?php

namespace App\services;

use App\main\App;

class CartService
{
    public function getCart()
    {
        $cart = [];
        if ($cartSession = $this->getCartFromSession()) {
            foreach ($cartSession as $product) {
                if ($item = get_object_vars($this->getProductsById($product['id']))) {
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
        if ($cart = $this->getCartFromSession()) {
            foreach ($cart as $key => $product) {
                if ($product['id'] == $id) {
                    $cart[$key]['count'] += 1;
                    $this->setCart($cart);
                    return [
                        'msg' => 'Количество увеличено',
                        'success' => true
                    ];
                }
            }
            $cart[] = ['id' => $id, 'count' => 1];
            $this->setCart($cart);
            return [
                'msg' => 'Товар добавлен',
                'success' => true
            ];
        } else {
            $this->setCart([['id' => $id, 'count' => 1]]);
            return [
                'msg' => 'Товар добавлен',
                'success' => true
            ];
        }
    }

    public function decCart($id)
    {
        if (!$cart = $this->getCartFromSession()) {
            return [
                'msg' => 'Корзина пуста',
                'success' => false
            ];
        }

        foreach ($cart as $key => $product) {
            if ($product['id'] == $id) {
                if ($cart[$key]['count'] > 1) {
                    $cart[$key]['count'] -= 1;
                    $this->setCart($cart);
                    return [
                        'msg' => 'Количество уменьшено',
                        'success' => true
                    ];
                } else {
                    return $this->deleteFromCart($id);
                }
            }
        }
        return [
            'msg' => 'Товар не найден',
            'success' => false
        ];
    }

    public function deleteFromCart($id)
    {
        if (!$cart = $this->getCartFromSession()) {
            return [
                'msg' => 'Корзина пуста',
                'success' => false
            ];
        }

        foreach ($cart as $key => $product) {
            if ($product['id'] == $id) {
                unset($cart[$key]);
                $this->setCart($cart);
                return [
                    'msg' => 'Товар удален',
                    'success' => true
                ];
            }
        }
        return [
            'msg' => 'Товар не найден',
            'success' => false
        ];
    }

    protected function setCart($cart)
    {
        App::call()->Request->sessionSet('cart', $cart);
    }

    protected function getCartFromSession()
    {
        if ($cart = App::call()->Request->sessionGet('cart')) {
            return $cart;
        } else return false;
    }

    protected function getProductsById($id)
    {
        return App::call()->GoodRepository->getOne($id);
    }
}