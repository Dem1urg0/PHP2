<?php

namespace App\services;

use App\main\App;

class UserService
{
    public function addUser($params)
    {
        if ($this->hasErrorForAdd($params)) {
            return [
                'msg' => 'Нет данных',
                'success' => false,
            ];
        }
        if (!$this->validateLogin($params['login'])) {
            return [
                'msg' => 'Логин не валиден',
                'success' => false,
            ];
        }
        if (!$this->validatePassword($params['password'])) {
            return [
                'msg' => 'Пароль не валиден',
                'success' => false,
            ];
        }
        $user = $this->getUserObj();

        if (!empty($params['id'])) {
            $user->id = $params['id'];
        }

        $user->login = $params['login'];
        $user->password = password_hash($params['password'], PASSWORD_DEFAULT);

        $this->userSave($user);

        return [
            'msg' => 'Пользователь сохранен',
            'success' => true,
        ];
    }
    public function updateUser($params)
    {
        if ($this->hasErrorForUpdate($params)) {
            return [
                'msg' => 'Нет данных',
                'success' => false,
            ];
        }
        if (empty($user = $this->getUserById($params['id']))) {
            return [
                'msg' => 'Нет данных',
                'success' => false,
            ];
        }
        if (!empty($params['login'])) {
            if (!$this->validateLogin($params['login'])) {
                return [
                    'msg' => 'Логин не валиден',
                    'success' => false,
                ];
            }
        }
        if (!empty($params['password'])) {
            if (!$this->validatePassword($params['password'])) {
                return [
                    'msg' => 'Пароль не валиден',
                    'success' => false,
                ];
            }
        }
        $user->id = $params['id'];

        if (!empty($params['login'])) {
            $user->password = $params['login'];
        }
        if (!empty($params['password'])) {
            $user->password = password_hash($params['password'], PASSWORD_DEFAULT);
        }
        $this->userSave($user);
        return [
            'msg' => 'Пользователь сохранен',
            'success' => true,
        ];
    }

    public function getUserObj(){
        return App::call()->User;
    }

    public function validateLogin($login)
    {
        if (empty($login)) {
            return false;
        }
        if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $login)) {
            return false;
        }
        $user = $this->getUserByLogin($login);

        if (!empty($user)) {
            return false;
        }
        return true;
    }

    public function validatePassword($password)
    {
        if (empty($password)) {
            return false;
        }
        if (strlen($password) < 6 || strlen($password) > 50) {
            return false;
        }

        if (!preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
            return false;
        }
        return true;
    }

    protected function hasErrorForAdd($params)
    {
        if (empty($params['login']) || empty($params['password'])) {
            return true;
        }
        return false;
    }

    protected function hasErrorForUpdate($params)
    {
        if (empty($params['login']) && empty($params['password']) || empty($params['id'])) {
            return true;
        }
        return false;
    }

    protected function userSave($user)
    {
        App::call()->UserRepository->save($user);
    }

    protected function getUserById($id)
    {
        return App::call()->UserRepository->getOne($id);
    }

    protected function getUserByLogin($login)
    {
        return App::call()->UserRepository->getByLogin($login);
    }
}