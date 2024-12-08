<?php

namespace App\controllers;

use App\main\App;
use App\Repositories\UserRepository;

class UserController extends Controller
{

    public function allAction()
    {
        $users = App::call()->UserRepository->getAll();
        return $this->render(
            'users',
            [
                'users' => $users
            ]);
    }

    public function oneAction()
    {
        $id = $this->getRequest('id');
        $user = App::call()->UserRepository->getOne($id);

        return $this->render(
            'user',
            [
                'user' => $user,
                'title' => 'Name'
            ]);
    }
    public function addAction() //todo?
    {
        $this->postRequest('login');
    }
    public function updateAction()
    {

    }
}