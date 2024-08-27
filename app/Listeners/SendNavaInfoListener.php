<?php

namespace App\Listeners;

use App\Events\SendNavaInfo;
use App\Jobs\SendNavaInfoJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNavaInfoListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SendNavaInfo $event): void
    {
        SendNavaInfoJob::dispatch($event->getNava());
    }
}
