<?php

namespace App\services;

use App\main\App;

class UserService
{
    public function fillUser($params)
    {
        if ($this->hasError($params)) {
            return [
                'msg' => 'Нет данных',
                'success' => false,
            ];
        }
        $user = App::call()->User;

        $user->login = $params['login'];
        $user->password = password_hash($params['password'],PASSWORD_DEFAULT);

        App::call()->UserRepository->save($user);

        return [
            'msg' => 'Пользователь сохранен',
            'success' => true,
        ];
    }

    public function hasError($params)
    {
        if (empty($params['login']) || empty($params['password'])) {
            return true;
        }
        return false;
    }
}