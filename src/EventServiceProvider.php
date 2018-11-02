<?php

namespace NhuongPH\ExceptionLog;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'NhuongPH\ExceptionLog\Events\ExceptionLogsEvent' => [
            'NhuongPH\ExceptionLog\Listeners\ExceptionLogsListeners',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
