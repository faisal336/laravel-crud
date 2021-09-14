<?php

namespace App\Providers;

use App\Events\ModelGeneratedEvent;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen('Illuminate\Console\Events\CommandFinished', function ($event) {
            if ($event->command === 'make:model') {
                echo 'Generating laravel-ide-helper' . PHP_EOL;

                echo 'php artisan clear-compiled' . PHP_EOL;
                Artisan::call('clear-compiled');

                echo 'php artisan ide-helper:generate' . PHP_EOL;
                Artisan::call('ide-helper:generate');

                echo 'php artisan ide-helper:models --write-mixin --no-interaction' . PHP_EOL;
                Artisan::call('ide-helper:models --write-mixin --no-interaction');

                echo 'php artisan ide-helper:meta' . PHP_EOL;
                Artisan::call('ide-helper:meta');
            }
        });
    }
}
