<?php

namespace App\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;
use App\Events\ApiRequestLogged;
use App\Listeners\LogApiRequest;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // \App\Events\ExampleEvent::class => [
        //     \App\Listeners\ExampleListener::class,
        // ],
        ApiRequestLogged::class => [
            LogApiRequest::class,
        ],
    ];

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return true;
    }
}
