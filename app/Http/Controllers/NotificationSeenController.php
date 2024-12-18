<?php

namespace App\Http\Controllers;

use Gate;
use Illuminate\Notifications\DatabaseNotification;

class NotificationSeenController extends Controller
{
    public function __invoke(DatabaseNotification $notification)
    {
// commented as for Laravel 9
//        $this->authorize('update', $notification);
        Gate::authorize('update', $notification);
        $notification->markAsRead();

        return redirect()->back()
            ->with('success', 'Notification marked as read.');
    }
}
