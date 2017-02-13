<?php namespace App\Listeners;


use App\Events\Attendance\AttendanceCreated;
use App\Events\Mark\MarkCreated;
use App\Events\NotificationEvent;
use App\Models\User;

class NotificationListener
{
    public function onAttendanceCreated(AttendanceCreated $event)
    {
        $attendance = $event->attendance;

        //Get the responsible User
        $user = User::find($attendance->student->user->id);

        //Store the notification for responsible user.
        $notification = $user->notifications()->create([
            'title' => 'New attendance added',
            'type' => 'attendance',
            'type_id' => $attendance->id,
        ]);

        //event(new NotificationEvent($notification));
    }

    public function onMarkCreated(MarkCreated $event)
    {
        $mark = $event->mark;

        //Get the responsible User
        $user = User::find($mark->student->user->id);

        //Store the notification for responsible user.
        $notification = $user->notifications()->create([
            'title' => 'New mark added',
            'type' => 'mark',
            'type_id' => $mark->id,
        ]);

        //event(new NotificationEvent($notification));
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            AttendanceCreated::class,
            'App\Listeners\NotificationListener@onAttendanceCreated'
        );

        $events->listen(
            MarkCreated::class,
            'App\Listeners\NotificationListener@onMarkCreated'
        );

    }
}