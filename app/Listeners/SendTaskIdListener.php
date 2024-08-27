<?php

namespace App\Listeners;

use App\Events\SendTaskId;
use App\Helpers\Constant;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Client\Response as ClientResponse;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SendTaskIdListener
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
    public function handle(SendTaskId $event): void
    {
        $response = Http::withHeaders([
            'authKey' => getApiConfigValue("authKey")
        ])->post($this->getApi(), [
            'taskId' => $event->getTaskId(),
            'type' => "nava"
        ]);

        $values = $this->getValues($event , $response);

        $event->getNava()->update($values);
    }


    /**
     * 
     *
     * @param SendTaskId $event
     * @param ClientResponse $response
     * @return array
     */
    function getValues(SendTaskId $event , ClientResponse $response) : array
    {
        $doneValue = Constant::IS_SUCCESS;
        $logInfoValue = null;

        if ($response->status() !== Response::HTTP_OK) {
            $logInfoValue = $response->json()['message'] ?? $response->status();
            $doneValue = Constant::IS_FAILED;
        }

        $nava = $event->getNava();
        $done = $nava->done ?? [];
        $logInfo = $nava->log_info ?? [];

        $done[] = $doneValue;
        $logInfo[] = $logInfoValue;

        return [
            'done' => $done,
            'log_info' => $logInfo,
            'video_stream' => $event->getTaskId(),
        ];
    }


    /**
     * get service api for saving video task id
     *
     * @return string
     */
    public function getApi(): string
    {
        return getApiConfigValue("nava_server") . "/api/v1/video-stream/save-task-id";
    }
}
