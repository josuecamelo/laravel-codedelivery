<?php

namespace CodeDelivery\Providers;

use CodeDelivery\Repositories\CategoryRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        //Category
        $this->app->bind(
            'CodeDelivery\Repositories\CategoryRepository', 'CodeDelivery\Repositories\CategoryRepositoryEloquent'
        );

        //Product
        $this->app->bind(
            'CodeDelivery\Repositories\ProductRepository', 'CodeDelivery\Repositories\ProductRepositoryEloquent'
        );

        //Client
        $this->app->bind(
            'CodeDelivery\Repositories\ClientRepository', 'CodeDelivery\Repositories\ClientRepositoryEloquent'
        );

        //Orders
        $this->app->bind(
            'CodeDelivery\Repositories\OrderRepository', 'CodeDelivery\Repositories\OrderRepositoryEloquent'
        );

        //Order Item
        $this->app->bind(
            'CodeDelivery\Repositories\OrderItemRepository', 'CodeDelivery\Repositories\OrderItemRepositoryEloquent'
        );

        //User
        $this->app->bind(
            'CodeDelivery\Repositories\UserRepository', 'CodeDelivery\Repositories\UserRepositoryEloquent'
        );

        //Cupom
        $this->app->bind(
            'CodeDelivery\Repositories\CupomRepository', 'CodeDelivery\Repositories\CupomRepositoryEloquent'
        );
    }
}
