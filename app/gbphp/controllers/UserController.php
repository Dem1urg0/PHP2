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

    public function addAction()
    {
        if (App::call()->Request->isPost()) {
            $params = [
                'login' => App::call()->Request->post('login'),
                'password' => App::call()->Request->post('password'),
            ];
            $result = App::call()->UserService->addUser($params);
            if ($result['success']) {
                header('Location: /auth/');
            } else {
                return $this->render('registration', ['error' => true]);
            }
        }
        return $this->render('registration', ['error' => false]);
    }

    public function editAction()
    {
        if (App::call()->Request->isPost()) {
            if (!empty($user = App::call()->Request->sessionGet('user'))) {
                $params = [
                    'id' => $user['id'],
                ];
                if (!empty(App::call()->Request->post('login'))) {
                    $params['login'] = App::call()->Request->post('login');
                }
                if (!empty(App::call()->Request->post('password'))) {
                    $params['password'] = App::call()->Request->post('password');
                }
                $result = App::call()->UserService->updateUser($params);
                if ($result['success']) {
                    App::call()->Request->sessionDelete('user');
                    header('Location: /user/all');
                }
            }
            return $this->render('edit', ['error' => true]);
        } else if (!empty(App::call()->Request->sessionGet('user')['id'])) {
            return $this->render('edit', ['error' => false]);
        } else {
            header('Location: /auth');
        }
    }

//    public function updateAction()
//    {
//        if (($user = App::call()->Request->sessionGet('user')) && App::call()->Request->isPost()) {
//            $params = [
//                'id' => $user['id'],
//            ];
//            if (!empty(App::call()->Request->post('login'))) {
//                $params['login'] = App::call()->Request->post('login');
//            }
//            if (!empty(App::call()->Request->post('password'))) {
//                $params['password'] = App::call()->Request->post('password');
//            }
//            $result = App::call()->UserService->updateUser($params);
//            if ($result['success']) {
//                App::call()->Request->sessionDelete('user');
//                header('Location: /user/all');
//            }
//        }
//        return $this->render('edit', ['error' => true]);
//    }
}