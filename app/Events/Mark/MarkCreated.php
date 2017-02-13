<?php

namespace App\Events\Mark;

use App\Events\Event;
use App\Models\Mark;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MarkCreated extends Event implements ShouldBroadcast
{
    use SerializesModels;
    /**
     * @var Mark
     */
    public $mark;

    /**
     * Create a new event instance.
     * @param Mark $mark
     */
    public function __construct(Mark $mark)
    {
        $this->mark = $mark;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['sms_channel.user_' . $this->mark->student->user->id];
    }
}
