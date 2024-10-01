<?php

namespace App\controllers;

use App\modules\Repositories\RCart;

class CartController extends ModelController
{
    protected $oCart;
    protected $defaultAction = 'get';

    public function __construct()
    {
        parent::__construct();
        $this->oCart = new RCart();
    }

    public function getAction()
    {
        $cart = $this->oCart->getCart();
        return [
            'cart' => $cart
        ];
    }

    public function deleteAction()
    {
        $this->oCart->setParams(['id' => $this->getGRequest('id')]);
        $this->oCart->delete();
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public function addAction()
    {
        $this->oCart->setParams(['id' => $this->getGRequest('id')]);
        $this->oCart->addCart();
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public function decAction()
    {
        $this->oCart->setParams(['id' => $this->getGRequest('id')]);
        $this->oCart->decCart();
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}