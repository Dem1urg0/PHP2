<?php

namespace App\controllers;

use App\main\App;

class AuthController extends Controller
{
    protected $defaultAction = 'index';

    public function indexAction()
    {
        return $this->render->render('login', [
            'error' => false,
        ]);
    }

    public function loginAction()
    {
        $userPost = $this->request->post();

        if (App::call()->AuthService->auth($userPost)['success']) {
            $id = App::call()->Request->sessionGet('user')['id'];
            header('Location: /user/one?id=' . $id);
        } else {
            return $this->render->render('login', [
                'error' => true,
            ]);
        }
        // todo сделать страницу пользователя на которую переходим после логина
    }

    public function logoutAction()
    {
        App::call()->Request->sessionDelete('user');
    }
}
