<?php

namespace App\Events;

use App\Events\Event;
use App\Link;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CreateLinkEvent extends Event
{
    use SerializesModels;

    public $link;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Link $link)
    {
        //
        $this-> link = $link;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
