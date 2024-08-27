<?php

namespace App\Listeners;

use App\Events\UploadFile;
use App\Jobs\UploadFileJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UploadFileListener
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
    public function handle(UploadFile $event): void
    {
        UploadFileJob::dispatch($event->getNava() , $event->getFieldName());
    }
}
