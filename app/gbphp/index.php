<?php

/*
1. Придумать класс, который описывает любую сущность из предметной области интернет-магазинов: продукт, ценник, посылка и т.п.
2. Описать свойства класса из п.1 (состояние).
3. Описать поведение класса из п.1 (методы).
4. Придумать наследников класса из п.1. Чем они будут отличаться?
*/

class Users
{
    protected $name;
    protected $email;
    protected $password;
    protected $phone;
    protected $isAdmin = false;

    public function __construct($name,$email,$pass,$phone)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $pass;
        $this->phone = $phone;
    }

    protected function getInfo()
    {
        $content = "Имя: $this->name </br> Email: $this->email </br> Телефон: $this->phone";
        return $content;
    }

    public function checkPass($pass)
    {
        if ($this->password == $pass) {
            return $this->getInfo();
        } else return 'Не верно';
    }
}

$user = new Users('Name1','true@mail','1234','800800');
echo $user->checkPass('134');

class Admin extends Users
{
    private $key = 'adminpass';

    public function isAdmin($key){
        if ($this->key ==$key){
            $this->isAdmin = true;
        } else {
            $this->isAdmin = false;
        }
    }
}