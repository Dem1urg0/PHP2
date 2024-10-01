<?php

namespace App\modules;


class Cart extends Model
{
    public $user_id = 1; // в сущность
    public $id;
    public $count;


    public function getTableName(): string //в репозиторий
    {
        return 'cart';
    }
    /**
     * @return array|false - возвращает таблицу cart+goods
     */
    public function getCart()
    {
        $SQL = "SELECT goods.name, goods.price, goods.img, cart.count , goods.id
        FROM cart INNER JOIN goods ON cart.id = goods.id;";
        $request = $this->bd->queryObjects($SQL, static::class);
        return $request;
    }
    /**
     * @return void - добавляет товар в корзину или увлечивает его кол-во
     */
    public function addCart(){
        $SQL = "SELECT * FROM cart WHERE id = :id";
        $cart = $this->bd->queryObject($SQL, static::class, [':id' => $this->id]);
        if($cart){
            $SQL = "UPDATE dbphp.cart SET count = count + 1 WHERE id = :id";
            $this->bd->exec($SQL, [':id' => $this->id]);
        }else{
            $SQL = "INSERT INTO cart (id, user_id, count) VALUES (:id, 1, 1)";
            $this->bd->exec($SQL, [':id' => $this->id]);
        }
    }
    public function decCart(){
        $SQL = "SELECT count FROM cart WHERE id = :id";
        $count = ($this->bd->queryObject($SQL, static::class, [':id' => $this->id]))->count;
        if ($count == 1){
            $this->delete();
        } else {
            $SQL = "UPDATE cart SET count = count - 1 WHERE id = :id";
            $this->bd->exec($SQL, [':id' => $this->id]);
        }
    }
}