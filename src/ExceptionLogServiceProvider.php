<?php

namespace NhuongPH\ExceptionLog;

use Illuminate\Support\ServiceProvider;
use NhuongPH\ExceptionLog\Repository\Eloquent\ExceptionLogRepository;
use NhuongPH\ExceptionLog\Repository\ExceptionLogRepositoryInterface;

class ExceptionLogServiceProvider extends ServiceProvider
{

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        app()->bind(ExceptionLogRepositoryInterface::class, ExceptionLogRepository::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        app()->register(EventServiceProvider::class);
        app()->register(\BaoPham\DynamoDb\DynamoDbServiceProvider::class);
    }
}
