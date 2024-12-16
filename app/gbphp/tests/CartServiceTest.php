<?php

namespace App\tests;

use App\Entities\Good;
use App\services\CartService;
use PHPUnit\Framework\TestCase;

class CartServiceTest extends TestCase
{
    /**
     * @param $cart
     * @param $products
     * @param $expected
     * @return void
     * @dataProvider dataTestGetCart
     */
    public function testGetCart($cart, $products, $expected)
    {
        $mockProducts = [];
        foreach ($products as $product) {
            $mockProduct = $this->createMock(Good::class);
            $mockProduct->id = $product['id'];
            $mockProduct->name = $product['name'];
            $mockProduct->price = $product['price'];
            $mockProducts[$product['id']] = $mockProduct;
        }

        $mockCartService = $this->getMockBuilder(CartService::class)
            ->onlyMethods(['getCartFromSession', 'getProductsById'])
            ->getMock();

        $mockCartService->method('getCartFromSession')->willReturn($cart);

        $mockCartService->method('getProductsById')
            ->willReturnCallback(function ($id) use ($mockProducts) {
                return isset($mockProducts[$id]) ? $mockProducts[$id] : null;
            });
        $result = $mockCartService->getCart();
        $this->assertEquals($expected, $result);
    }

    public function dataTestGetCart()
    {
        return [
            'single product cart' => [
                'cart' => [
                    ['id' => 1, 'count' => 2]
                ],
                'products' => [
                    ['id' => 1, 'name' => 'Product 1', 'price' => 100.50]
                ],
                'expected' => [
                    [
                        'id' => 1,
                        'name' => 'Product 1',
                        'price' => 100.50,
                        'count' => 2
                    ]
                ]
            ],
            'zero products cart' => [
                'cart' => [],
                'products' => [
                    ['id' => 1, 'name' => 'Product 1', 'price' => 100.50],
                    ['id' => 2, 'name' => 'Product 2', 'price' => 200.75]
                ],
                'expected' => []
            ],
            'multiple products cart' => [
                'cart' => [
                    ['id' => 1, 'count' => 2],
                    ['id' => 2, 'count' => 1]
                ],
                'products' => [
                    ['id' => 1, 'name' => 'Product 1', 'price' => 100.50],
                    ['id' => 2, 'name' => 'Product 2', 'price' => 200.75]
                ],
                'expected' => [
                    [
                        'id' => 1,
                        'name' => 'Product 1',
                        'price' => 100.50,
                        'count' => 2
                    ],
                    [
                        'id' => 2,
                        'name' => 'Product 2',
                        'price' => 200.75,
                        'count' => 1
                    ]
                ]
            ]
        ];
    }

    /**
     * @param $id
     * @param $cart
     * @param $expected
     * @return void
     * @dataProvider dataTestAddToCart
     */
    public function testAddToCart($id, $cart, $expected)
    {
        $mockCartService = $this->getMockBuilder(CartService::class)
            ->onlyMethods(['getCartFromSession', 'setCart'])->getMock();

        $mockCartService->method('getCartFromSession')->willReturn($cart);

        $result = $mockCartService->addToCart($id);

        $this->assertEquals($expected, $result);
    }

    public function dataTestAddToCart()
    {
        return [
            [
                1,
                [
                    ['id' => 1, 'count' => 1]
                ],
                [
                    'msg' => 'Количество увеличено',
                    'success' => true
                ]
            ],
            [
                1,
                [
                    ['id' => 2, 'count' => 1]
                ],
                [
                    'msg' => 'Товар добавлен',
                    'success' => true
                ]
            ],
            [
                1,
                [],
                [
                    'msg' => 'Товар добавлен',
                    'success' => true
                ]
            ],
        ];
    }

    /**
     * @param $id
     * @param $cart
     * @param $expected
     * @return void
     * @dataProvider dataForTestDecCart
     */
    public function testDecCart($id, $cart, $expected)
    {
        $mockCartService = $this->getMockBuilder(CartService::class)
            ->onlyMethods(['getCartFromSession', 'setCart'])->getMock();

        $mockCartService->method('getCartFromSession')->willReturn($cart);

        $result = $mockCartService->decCart($id);

        $this->assertEquals($expected, $result);
    }

    public function dataForTestDecCart()
    {
        return [
            [
                1,
                [
                    ['id' => 1, 'count' => 1]
                ],
                [
                    'msg' => 'Товар удален',
                    'success' => true
                ]
            ],
            [
                1,
                [
                    ['id' => 2, 'count' => 1]
                ],
                [
                    'msg' => 'Товар не найден',
                    'success' => false
                ]
            ],
            [
                1,
                [],
                [
                    'msg' => 'Корзина пуста',
                    'success' => false
                ]
            ],
            [
                1,
                [
                    ['id' => 1, 'count' => 3]
                ],
                [
                    'msg' => 'Количество уменьшено',
                    'success' => true
                ]
            ],
        ];
    }

    /**
     * @param $id
     * @param $cart
     * @param $expected
     * @return void
     * @dataProvider dataForTestDeleteFromCart
     */
    public function testDeleteFromCart($id, $cart, $expected)
    {
        $mockCartService = $this->getMockBuilder(CartService::class)
            ->onlyMethods(['getCartFromSession', 'setCart'])->getMock();

        $mockCartService->method('getCartFromSession')->willReturn($cart);

        $result = $mockCartService->deleteFromCart($id);
        $this->assertEquals($expected, $result);
    }

    public function dataForTestDeleteFromCart()
    {
        return [
            [
                1,
                [
                    ['id' => 1, 'count' => 1]
                ],
                [
                    'msg' => 'Товар удален',
                    'success' => true
                ]
            ],
            [
                1,
                [
                    ['id' => 2, 'count' => 1]
                ],
                [
                    'msg' => 'Товар не найден',
                    'success' => false
                ]
            ],
            [
                1,
                [],
                [
                    'msg' => 'Корзина пуста',
                    'success' => false
                ]
            ],
        ];
    }
}