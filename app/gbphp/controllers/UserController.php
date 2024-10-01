<?php

namespace App\controllers;

use App\modules\Repositories\RUser;

class UserController extends ModelController
{
    protected $oUser;

    public function __construct()
    {
        parent::__construct();
        $this->oUser = new RUser();
    }

    public function allAction()
    {
        $users = $this->oUser->getAll();
        return ['users' => $users];
    }

    public function oneAction()
    {
        $id = $this->getGRequest('id');
        $user = $this->oUser->getOne($id);

        return [
            'user' => $user,
            'title' => 'Name'
        ];
    }
}