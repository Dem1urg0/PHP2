<?php

namespace App\services;

use App\main\App;

class AuthService
{
    public function auth($params)
    {

        if (App::call()->UserService->hasError($params) || empty($params)) {
            return [
                'msg' => 'Нет данных',
                'success' => false,
            ];
        }

        if(empty(App::call()->UserRepository->GetByLogin($params['login']))){
            return [
                'msg' => 'Пользователь не найден',
                'success' => false,
            ];
        }

        $userData = get_object_vars(App::call()->UserRepository->GetByLogin($params['login']));

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

        App::call()->Request->sessionSet('user', $userSession);
        return [
            'msg' => 'Успешно',
            'success' => true,
        ];
    }
    public function roleCheck()
    {
        //todo проверка на роль
    }
}