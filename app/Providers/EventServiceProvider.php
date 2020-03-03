<?php

namespace App\Providers;

use App\Events\SendSmsVisitorHost;
use App\Events\VisitorCheckedIn;
use App\Events\AdminReptionEmail;
use App\Events\SendSmsAdminRecption;
use App\Listeners\SendSmsAdminRecipient;
use App\Listeners\SendWelcomeEmailToAdminRecipteion;
use App\Listeners\SendSms;
use App\Listeners\SendWelcomeEmailToVisitor;
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
        SendSmsVisitorHost::class => [
            SendSms::class
        ],
        VisitorCheckedIn::class => [
            SendWelcomeEmailToVisitor::class
        ],
        SendSmsAdminRecption::class => [
            SendSmsAdminRecipient::class
        ],
        AdminReptionEmail::class => [
            SendWelcomeEmailToAdminRecipteion::class
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
