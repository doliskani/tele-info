<?php

namespace App\Providers;

use App\Events\SendNavaInfo;
use App\Events\SendTaskId;
use App\Events\UploadFile;
use App\Listeners\SendNavaInfoListener;
use App\Listeners\SendTaskIdListener;
use App\Listeners\UploadFileListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UploadFile::class => [
            UploadFileListener::class,
        ],
        SendTaskId::class => [
            SendTaskIdListener::class,
        ],
        SendNavaInfo::class => [
            SendNavaInfoListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
