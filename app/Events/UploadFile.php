<?php

namespace App\Events;

use App\Models\Nava;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UploadFile
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param Nava $nava
     * @param string $fieldName
     */
    public function __construct(public Nava $nava , public string $fieldName)
    {

    }

    /**
     * get nava object
     *
     * @return Nava
     */
    function getNava(): Nava
    {
        return $this->nava;    
    }

    /**
     * Get create a new event instance.
     */ 
    public function getFieldName()
    {
        return $this->fieldName;
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }

    
}