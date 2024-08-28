<?php

namespace App\controllers;

use App\modules\User;

class UserController extends ModelController
{

    public function allAction()
    {
        $users = (new User())->getAll();
        return $this->render('users', ['users' => $users]);
    }

    public function oneAction()
    {
        $oUser = new User;
        $user = $oUser->getOne($_GET['id']);

        return $this->render('user', [
            'user' => $user,
            'title' => 'Name'
        ]);
    }
}