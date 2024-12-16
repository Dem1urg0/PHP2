<?php
return [
    'name' => 'Мой магазин',
    'defaultController' => 'user',

    'components' => [
        'db' => [
            'class' => \App\services\db::class,
            'config' => [
                'driver' => 'mysql',
                'host' => 'mariadb',
                'db' => 'dbphp',
                'charset' => 'UTF8',
                'username' => 'root',
                'password' => 'rootroot',
            ],
        ],
        'render' => [
            'class' => \App\services\renders\TwigRender::class,
        ],
        'UserRepository' => [
            'class' => \App\repositories\UserRepository::class,
        ],
        'GoodRepository' => [
            'class' => \App\repositories\GoodRepository::class,
        ],
        'UserService' => [
            'class' => \App\services\UserService::class,
        ],
        'Good' => [
            'class' => \App\Entities\Good::class,
        ],
        'User' => [
            'class' => \App\Entities\User::class,
        ],
        'Request' => [
            'class' => \App\services\Request::class,
        ],
        'Order' => [
            'class' => \App\Entities\Order::class
        ],
        'OrderRepository' => [
            'class' => \App\Repositories\OrderRepository::class
        ],
        'AuthService' => [
            'class' => \App\Services\AuthService::class
        ],
        'CartService' =>[
            'class' => \App\services\CartService::class
        ],
        'OrderService' => [
            'class' => \App\Services\OrderService::class
        ],
        'OrderItemRepository' => [
            'class' => \App\Repositories\OrderItemRepository::class
        ],
        'OrderItem' => [
            'class' => \App\Entities\OrderItem::class
        ],
        'RoleMiddleware' => [
            'class' => \App\Middleware\RoleMiddleware::class
        ],
    ],
];
