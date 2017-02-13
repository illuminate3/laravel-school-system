<?php

namespace App\Events\Attendance;

use App\Events\Event;
use App\Models\Attendance;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AttendanceCreated extends Event implements ShouldBroadcast
{
    use SerializesModels;
    /**
     * @var Attendance
     */
    public $attendance;

    /**
     * Create a new event instance.
     * @param Attendance $attendance
     */
    public function __construct(Attendance $attendance)
    {
        $this->attendance = $attendance;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['sms_channel.user_' . $this->attendance->student->user->id];
    }
}
