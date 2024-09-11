<?php

namespace App\controllers;

use App\modules\User;

class UserController extends ModelController
{

    public function allAction()
    {
        $users = (new User())->getAll();
        return ['users' => $users];
    }

    public function oneAction()
    {
        $oUser = new User;
        $user = $oUser->getOne($_GET['id']);

        return [
            'user' => $user,
            'title' => 'Name'
        ];
    }
}