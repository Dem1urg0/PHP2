<?php

namespace App\services;

use App\main\App;

class AuthService
{
    public function auth($params)
    {

        if ($this->hasError($params) || empty($params)) {
            return [
                'msg' => 'Нет данных',
                'success' => false,
            ];
        }

        if (empty($userObj = $this->getUserByLogin($params['login']))) {
            return [
                'msg' => 'Пользователь не найден',
                'success' => false,
            ];
        }

        $userData = get_object_vars($userObj);

        if (password_verify($params['password'], $userData['password'])) {
            $userSession = [
                'id' => $userData['id'],
                'login' => $userData['login'],
                'role' => $userData['role']
            ];
        } else  return [
            'msg' => 'Не верные данные',
            'success' => false,
        ];

        $this->sessionSet('user', $userSession);

        return [
            'msg' => 'Успешно',
            'success' => true,
        ];
    }

    protected function hasError($params)
    {
        if (empty($params['login']) || empty($params['password'])) {
            return true;
        }
        return false;
    }

    protected function getUserByLogin($login)
    {
        return App::call()->UserRepository->getByLogin($login);
    }

    protected function sessionSet($name, $value)
    {
        return App::call()->Request->sessionSet($name, $value);
    }
}