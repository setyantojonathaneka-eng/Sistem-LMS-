<?php

namespace App\View\Composers;

use App\Models\Notification;
use Illuminate\View\View;

class NotificationComposer
{
    public function compose(View $view)
    {
        $userId = auth()->id();

        $notifications = $userId
            ? Notification::forUser($userId)->latest()->take(10)->get()
                ->map(fn($n) => [
                    'title' => $n->title,
                    'body'  => $n->body ?? '',
                    'time'  => $n->timeForHumans(),
                    'color' => $n->color,
                    'link'  => $n->link,
                    'read'  => $n->is_read,
                ])
            : [];

        $unreadCount = $userId
            ? Notification::forUser($userId)->unread()->count()
            : 0;

        $view->with('notifications', $notifications)
             ->with('unreadCount', $unreadCount);
    }
}
