<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class userLogin
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
    public function handle(object $event): void
    {
        $notis = DB::table('notifications')
        ->leftJoin('users', 'users.id', '=', 'notifications.created_by_id')
        ->leftJoin('comments', 'notifications.comment_id', '=', 'comments.id')
        ->leftJoin('read_comments', 'comments.id', '=', 'read_comments.comment_id')
        ->leftJoin('read_posts', 'notifications.post_id', '=', 'read_posts.post_id')
        ->leftJoin('posts', 'notifications.post_id', '=', 'posts.id')
        ->select(
            'notifications.post_id',
            'users.name',
            'comments.comment',
            'comments.id As commentId',
            DB::raw('CASE WHEN COUNT(read_comments.comment_id) > 0 THEN TRUE ELSE FALSE END AS readComment')
        )
        ->where('posts.user_id', $event->user->id) // Use the authenticated user's ID
        ->groupBy('notifications.post_id', 'users.name', 'comments.comment', 'comments.id')
        ->get();
            // dd($notis);

        // Pass the notifications data to the view
        view()->share('notis', $notis);
    }
}
