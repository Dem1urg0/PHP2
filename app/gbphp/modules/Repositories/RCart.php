<?php

namespace App\modules\Repositories;

use App\modules\Entities\MCart;

class RCart extends Repository
{
    public function __construct()
    {
        parent::__construct(new MCart());
    }
    /**
     * @return array|false - возвращает таблицу cart+goods
     */
    public function getCart()
    {
        $SQL = "SELECT goods.name, goods.price, goods.img, cart.count , goods.id
        FROM cart INNER JOIN goods ON cart.id = goods.id;";
        $request = $this->bd->queryObjects($SQL, get_class($this->model));
        return $request;
    }
    /**
     * @return void - добавляет товар в корзину или увлечивает его кол-во
     */
    public function addCart(){
        $SQL = "SELECT * FROM cart WHERE id = :id";
        $cart = $this->bd->queryObject($SQL, get_class($this->model), [':id' => $this->model->id]);
        if($cart){
            $SQL = "UPDATE dbphp.cart SET count = count + 1 WHERE id = :id";
            $this->bd->exec($SQL, [':id' => $this->model->id]);
        }else{
            $SQL = "INSERT INTO dbphp.cart (id, user_id, count) VALUES (:id, 1, 1)";
            $this->bd->exec($SQL, [':id' => $this->model->id]);
        }
    }
    public function decCart(){
        $SQL = "SELECT count FROM cart WHERE id = :id";
        $count = ($this->bd->queryObject($SQL, get_class($this->model), [':id' => $this->model->id]))->count;
        if ($count == 1){
            $this->delete();
        } else {
            $SQL = "UPDATE cart SET count = count - 1 WHERE id = :id";
            $this->bd->exec($SQL, [':id' => $this->model->id]);
        }
    }
}