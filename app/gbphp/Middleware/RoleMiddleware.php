<?php

namespace App\Middleware;

use App\main\App;

class RoleMiddleware
{
    public function checkAdmin()
    {
        if (!($user = App::call()->Request->sessionGet('user')) || $user['role'] !== 1){
            return false;
        } else {
            return true;
        }
    }
}