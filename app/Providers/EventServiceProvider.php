<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
        'order.created' => [
            'App\Events\OrderEvent@orderCreated',
        ],
        'order.updated' => [
            'App\Events\OrderEvent@orderUpdated',
        ],
        'order.updating' => [
            'App\Events\OrderEvent@orderUpdating',
        ],
        'user.created' => [
            'App\Events\UserEvent@userCreated',
        ],
        'withdraw.created' => [
            'App\Events\WithdrawEvent@withdrawCreated',
        ],
        'withdraw.updated' => [
            'App\Events\WithdrawEvent@withdrawUpdated',
        ],
        'topup.updating' => [
            'App\Events\TopupEvent@topupUpdating'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
